@php
    $meId = auth()->id();
    $avatarUrl = auth()->user()->avatar;
@endphp

{{-- <div id="chat-box" style="height:320px; overflow-y:auto; border:1px solid #e3e3e3; padding:10px; border-radius:8px;">
    @foreach ($messages as $msg)
        <div class="mb-2 @if ($msg->user_id == $meId) text-end @endif">
            <span class="text-white p-2 rounded tp_propage_text" style="background: teal;">{{ $msg->message }}</span>
        </div>
    @endforeach
</div> --}}
<div id="chat-box"
    style="height:320px; overflow-y:auto; border:1px solid #e3e3e3; padding:10px; border-radius:8px; background:#fafafa;">
    @foreach ($messages as $msg)
        <div
            class="mb-3 d-flex @if ($msg->user_id == $meId) justify-content-end @else justify-content-start @endif">

            {{-- If it's not me, show avatar on the left --}}
            @if ($msg->user_id != $meId)
                <div class="me-2">
                    <img src="{{ $msg->user->avatar ?? asset('user-theme/assets/images/chat/profile.jpg') }}"
                        alt="avatar" class="rounded-circle" width="32" height="32">
                </div>
            @endif

            <div>
                <span class="text-white p-2 rounded tp_propage_text"
                    style="background: {{ $msg->user_id == $meId ? 'teal' : '#6c757d' }};">
                    {{ $msg->message }}
                </span>
                <div class="small text-muted mt-1">
                    {{ $msg->created_at->format('H:i') }}
                </div>
            </div>

            {{-- If it’s me, show avatar on the right --}}
            @if ($msg->user_id == $meId)
                <div class="ms-2">
                    <img src="{{ auth()->user()->avatar ?? asset('user-theme/assets/images/chat/profile.jpg') }}"
                        alt="avatar" class="rounded-circle" width="32" height="32">
                </div>
            @endif
        </div>
    @endforeach
</div>

<div class="mt-2 d-flex gap-2">
    <input id="message-input" type="text" class="form-control" placeholder="Type a message…">
    <button type="button" class="btn btn-info" id="send-btn">Send</button>
</div>

<div id="debug-overlay"
    style="position:fixed;bottom:10px;right:10px;width:300px;height:200px;background:rgba(0,0,0,0.7);color:#fff;padding:10px;overflow:auto;font-size:12px;z-index:9999;">
    <strong>Debug Log</strong>
    <div id="debug-log"></div>
</div>

<script>
    function initChatWindow() {
        var meId = {{ $meId }};
        var avatarUrl = "{{ $avatarUrl ?? asset('user-theme/assets/images/chat/profile.jpg') }}";
        var partnerId = {{ $partner->id }};
        var $chatBox = $('#chat-box');
        var $input = $('#message-input');
        var $sendBtn = $('#send-btn');
        var $debugLog = $('#debug-log');

        function logDebug(msg) {
            var $div = $('<div>').text(msg);
            $debugLog.append($div);
            $debugLog.scrollTop($debugLog[0].scrollHeight);
        }

        logDebug('MeID: ' + meId + ', PartnerID: ' + partnerId);

        $sendBtn.off('click').on('click', function() {
            logDebug('✅ Send button clicked!');
            sendMessage();
        });

        $input.off('keydown').on('keydown', function(ev) {
            if (ev.key === 'Enter') {
                sendMessage();
            }
        });

        // 🟢 FIXED appendMessage with proper structure & avatar placement
        function appendMessage(text, fromMe) {
            var $wrapper = $('<div>')
                .addClass('mb-3 d-flex')
                .addClass(fromMe ? 'justify-content-end' : 'justify-content-start');

            if (!fromMe) {
                // Avatar on the LEFT
                $wrapper.append(
                    $('<div class="me-2">').append(
                        $('<img>', {
                            src: 'user-theme/assets/images/chat/profile.jpg', // you can replace with sender avatar from event
                            class: 'rounded-circle',
                            width: 32,
                            height: 32
                        })
                    )
                );
            }

            var $content = $('<div>')
                .append(
                    $('<span>')
                    .addClass('text-white p-2 rounded tp_propage_text')
                    .css('background', fromMe ? 'teal' : '#6c757d')
                    .text(text)
                )
                .append(
                    $('<div>')
                    .addClass('small text-muted mt-1')
                    .text(new Date().toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }))
                );

            $wrapper.append($content);

            if (fromMe) {
                // Avatar on the RIGHT
                $wrapper.append(
                    $('<div class="ms-2">').append(
                        $('<img>', {
                            src: avatarUrl,
                            class: 'rounded-circle',
                            width: 32,
                            height: 32
                        })
                    )
                );
            }

            $chatBox.append($wrapper);
            $chatBox.scrollTop($chatBox[0].scrollHeight);
        }

        function sendMessage() {
            var text = $input.val().trim();
            if (!text) {
                logDebug('❌ Message input is empty. Aborting.');
                return;
            }
            logDebug('Sending message: "' + text + '"');
            appendMessage(text, true);
            $input.val('');
            $.ajax({
                url: "{{ route('chat.send', ['locale' => app()->getLocale()]) }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    message: text,
                    receiver_id: partnerId
                }),
                success: function(data) {
                    logDebug('✅ Server response: ' + JSON.stringify(data));
                },
                error: function(xhr) {
                    logDebug('❌ Server returned non-200 status: ' + xhr.status);
                }
            });
        }

        if (window.Echo) {
            window.Echo.private('chat.' + meId)
                .listen('.MessageSent', function(e) {
                    if (String(e.sender.id) === String(partnerId)) {
                        appendMessage(e.message, false);
                        logDebug('📩 Incoming message from ' + (e.sender.full_name || ('User #' + e.sender.id)) +
                            ': ' + e.message);
                    }
                });
        }
    }
    if ($('#chat-box').length) {
        initChatWindow();
    }
</script>
