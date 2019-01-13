$(document).on('click', '.delete-user', function (e) {
    e.preventDefault();
    var deleteController = $(this).attr('href');
    answer = confirm('Do you want delete this user?');
    if (answer) {
        location.href = deleteController;
    }
});