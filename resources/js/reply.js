$(document).ready(function() {
    $('#submitReply').click(function() {
        var form = $('#replyForm');
        var formData = form.serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            success: function(response) {
                // Add the new reply to the page
                var newReply = '<div class="mb-3"><a href="' + response.user.profile_url + '"><div class="font-weight-bold"><img src="' + response.user.profile_picture_url + '" alt="' + response.user.name + '\'s Profile Picture" class="rounded-circle mr-2" width="40" height="40"><b style="color: #fff">' + response.user.name + ' <span class="user-rank ' + response.user.rank + '">[' + response.user.rank + ']: </span></b></div></a><div class="card-footer" style="margin-top: 10px;">' + response.body + '<span class="text-muted" style="float:right;font-size: 14px;">' + response.created_at + '</span></div></div>';
                $('#repliesContainer').append(newReply);
                $('#replyBody').val('');
            }
        });
    });
});
