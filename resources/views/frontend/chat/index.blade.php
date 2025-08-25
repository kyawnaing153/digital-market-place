<div class="row">
    <div class="col-md-3 border-end">
        <h5 class="mb-3 fw-bold">{{ ucfirst($type ?? 'users') }}</h5>
        <ul class="list-group" id="chat-user-list">
            {{-- @php dd($chatUsers) @endphp --}}
            {{-- @php dd($chatUsers, $activeUserId); @endphp --}}
            @forelse($chatUsers ?? [] as $u)
                <li class="list-group-item d-flex justify-content-between align-items-center {{ $loop->first ? 'active-user' : '' }}">
                    <a href="#" class="open-chat" data-id="{{ $u->id }}">
                        {{ $u->full_name ?? ($u->username ?? 'User #' . $u->id) }}
                    </a>
                </li>
            @empty
                <li class="list-group-item">No users found.</li>
            @endforelse
        </ul>
    </div>

    <div class="col-md-8">
        <div id="chat-window">
            <p class="text-muted">Select a {{ $type ?? 'user' }} to start chatting.</p>
        </div>
    </div>
</div>

{{-- <script type="text/javascript" src="{{ $ASSET_URL }}js/jquery.min.js"></script> --}}
<script src="{{ asset('admin-theme/assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
$(document).on('click', '.open-chat', function(e) {
    e.preventDefault();

    var $li = $(this).closest('li'); // get parent <li>
    var id = $(this).data('id');

    // Remove 'active-user' from all and add to clicked
    $('#chat-user-list li').removeClass('active-user');
    $li.addClass('active-user');

    // AJAX to load chat window
    var url = "{{ route('chat.open', ['locale' => app()->getLocale(), 'partnerId' => 0]) }}".replace('/0', '/' + id);
    $.ajax({
        url: url,
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        success: function(html) {
            $('#chat-window').html(html);
            if (typeof initChatWindow === 'function') {
                initChatWindow();
            }
        }
    });
});
</script>

