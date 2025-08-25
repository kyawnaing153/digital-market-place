<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // List (for the left sidebar)
    public function list()
    {
        $user = auth()->user();

        if ($user->role == 2) { // vendor
            $chatUsers = User::whereIn('id', function ($q) use ($user) {
                $q->select('customer_id')->from('chat_requests')->where('vendor_id', $user->id);
            })->orderByDesc('id')->get();
            $type = 'customer';
        } elseif ($user->role == 1) { // customer
            $chatUsers = User::where('role', 2)->orderByDesc('id')->get();
            $type = 'vendor';
        } else { // admin
            $chatUsers = User::whereIn('role', [0, 1, 2])->orderByDesc('id')->get();
            $type = 'all';
        }

        return view('frontend.chat.index', compact('chatUsers', 'type'));
    }

    // Open a specific conversation (right pane)
    public function open($locale, $partnerId)
    {
        $me = auth()->user();
        $partner = User::findOrFail($partnerId);

        // Authorization rule: vendors may only open chats with customers that have requested them.
        if ($me->role == 2 && $partner->role == 1) {
            $exists = DB::table('chat_requests')
                ->where('vendor_id', $me->id)
                ->where('customer_id', $partner->id)
                ->exists();

            abort_if(!$exists, 403, 'No chat request from this customer.');
        }

        // Load conversation (ascending by id)
        $messages = Message::where(function ($q) use ($me, $partnerId) {
            $q->where('user_id', $me->id)->where('receiver_id', $partnerId);
        })->orWhere(function ($q) use ($me, $partnerId) {
            $q->where('user_id', $partnerId)->where('receiver_id', $me->id);
        })
            ->orderBy('id', 'asc')
            ->with('sender:id,full_name,username')
            ->get();

        return view('frontend.chat.window', compact('partner', 'messages'));
    }

    // Send message
    public function send(Request $request)
    {
        // $request->validate([
        //     'receiver_id' => 'required|exists:users,id|different:' . auth()->id(),
        //     'message'     => 'required|string|max:5000',
        // ]);

        $me = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);

        // Create or refresh the chat_requests relation
        // (customer_id is the role=1 user; vendor_id is role=2 user)
        $customerId = $me->role == 1 ? $me->id : ($receiver->role == 1 ? $receiver->id : null);
        $vendorId   = $me->role == 2 ? $me->id : ($receiver->role == 2 ? $receiver->id : null);

        if ($customerId && $vendorId) {
            DB::table('chat_requests')->updateOrInsert(
                ['customer_id' => $customerId, 'vendor_id' => $vendorId],
                ['updated_at' => now(), 'created_at' => now()]
            );
        }

        $message = Message::create([
            'user_id'     => $me->id,
            'receiver_id' => $receiver->id,
            'message'     => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['ok' => true]);
    }
}
