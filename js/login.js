$(document).on('submit', '#loginForm', function (e) {
    e.preventDefault();

    $.ajax({
        method: "POST",
        url: "api/login.php",
        data: $(this).serialize(),
        success: function (data) {

            if (data != 'ERROR') {
                window.location.href = 'inedx.php'
            } else {
                alert("ERROR");
            }

        }
    });
});