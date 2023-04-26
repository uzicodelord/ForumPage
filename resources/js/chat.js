$(document).ready(function() {
    // handle form submission via AJAX
    $('#chat-form').submit(function(e) {
        e.preventDefault();

        var message = $('#chat-message').val();

        $.ajax({
            url: '/chat',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'message' : message
            },
            success: function(response) {
                $('#chat-message').val('');
                    var messageHtml = `<div style="padding-bottom: 5px;">
                        <a href="/profiles/${response.user.id}">
                            ${response.user.name}<span class="user-rank ${response.user.rank}">&nbsp[${response.user.rank}]:</span>
                        </a>
                        ${response.message}
                    </div>`;
                    $('#messages').append(messageHtml);
            },
            error: function() {
                var messageHtml = `<div style="color: red; font-weight: bold;">You need to be verified to start chat.</div>`;
                $('#messages').append(messageHtml);
            }
        });
    });
});

