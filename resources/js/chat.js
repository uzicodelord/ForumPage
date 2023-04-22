$(document).ready(function() {
    // handle form submission via AJAX
    $('#chat-form').submit(function(e) {
        e.preventDefault(); // prevent the form from submitting normally

        var message = $('#chat-message').val(); // get the chat message from the input field

        $.ajax({
            url: '/chat', // use the URL for the chat message store method
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'), // include the CSRF token for security
                'message' : message // send the chat message as data
            },
            success: function(response) {
                $('#chat-message').val(''); // clear the input field after a successful chat message send
                var messageHtml = `<div style="padding-bottom: 5px;">
                <a href="/profiles/${response.user.id}">
                ${response.user.name}<span class="font-shadow" style="font-size: 16px;"> ${response.user.rank}:</span>
                </a>
                ${response.message}
                </div>`;
                $('#messages').append(messageHtml); // append the chat message to the messages container
            },

            error: function() {
                alert('An error occurred while sending your message.');
            }
        });
    });
});
