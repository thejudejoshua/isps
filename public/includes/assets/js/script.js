$(document).ready(function() {
    $('#btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/components/logUser.php';
        let form = $('.signin-form')[0]; // You need to use standard javascript object here
        let data = new FormData(form);
        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.trim() === 'success!') {
                    // $('#recha').remove();
                    alert('Your login was successful!');
                    setTimeout('window.location.href = "/dashboard"', 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        alert(error[1]);
                    } else {
                        alert(response)
                    }
                    // $('#recha').remove();
                }
            }
        })
    })

})