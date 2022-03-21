$(document).ready(function() {

    //=================================================================================================
    //                                              L O G I N
    //=================================================================================================
    $('.signin-form #email').focusin(function() {
        $("#animation-image").attr("src", "/includes/assets/img/enter-email.gif");
        setTimeout(() => {
            $("#animation-image").attr("src", "/includes/assets/img/enter-email.png");
        }, 1000);
    });
    $('.signin-form #password').focusin(function() {
        $("#animation-image").attr("src", "/includes/assets/img/enter-pass.gif");
        setTimeout(() => {
            $("#animation-image").attr("src", "/includes/assets/img/enter-pass.png");
        }, 1500);
    });
    $('.signin-form input').focusout(function() {
        $("#animation-image").attr("src", "/includes/assets/img/account.png");
    });
    $('span#toggle-pass').click(function() {
        if ($('input.password').attr('type') == 'password') {
            $(this).removeClass('la-eye').addClass('la-eye-slash');
            $('input.password').prop('type', 'text');
        } else {
            $(this).removeClass('la-eye-slash').addClass('la-eye');
            $('input.password').prop('type', 'password');
        }
    });
    $('.signin-form #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/controls/logUser.php';
        let form = $(".signin-form")[0]; // You need to use standard javascript object here
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
    });
    //=================================================================================================
    //                                             A D D  U S E R
    //=================================================================================================
    $('select#designaton').on('change', function() {
        let rank = $(this).find(':selected').attr('data-rank');
        $('#rank').val(rank);
    });

    $('#newUserForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/controls/addUser.php';
        let form = $('#newUserForm')[0]; // You need to use standard javascript object here
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
                    alert('The user data was saved successfully!');
                    setTimeout('window.location.href = "/users"', 500);
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
    });
    //=================================================================================================
    //                                             V I E W  U S E R
    //=================================================================================================
    $('.view-user').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = $(this).attr('href');

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            success: function(response) {
                $('body').replaceWith(response);
                history.pushState(" ", " ", "/users/view_user");
            }
        })
    })

})