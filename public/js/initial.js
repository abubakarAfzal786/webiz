$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.fn.doneTyping = function (callback, $wait_time = 350) {
    let _this = $(this);
    let x_timer;
    _this.keyup(function () {
        clearTimeout(x_timer);
        x_timer = setTimeout(clear_timer, $wait_time);
    });

    function clear_timer() {
        clearTimeout(x_timer);
        callback.call(_this);
    }
};

$(document).on('click', '.delete-swal', function () {
    let item_id = $(this).data('id');
    let url = $(this).data('url');

    if (confirm("Are you sure?")) {
        $.ajax({
            url: url + item_id,
            type: 'DELETE',
            success: function () {
                $('#myDataTable').DataTable().draw();
            },
            error: function () {
                alert("Something went wrong.")
            }
        });
    }
});