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
        let link = '/includes/config/logUser.php';
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
        switch ($(this).val()) {

            case 'budgeting officer':
                var level = ["level 8", "level 9", "level 10", "level 11", "level 12", "level 13", "level 14", "level 15", "level 16"];
                $(this).parent().removeClass('full-width');
                if ($(".rank").length == 0) {
                    $(this).parent().parent().addClass('dual').append('<div class="rank"><label for="rank" class="form-label">Choose a level <span>(Required)</span></label><select id="rank" name="rank" class="form-control" required><option value="" disabled selected hidden>Choose...</option></select></div>');
                }
                $('.rank select').find('option').remove().end().append($('<option value=" " disabled selected hidden>Choose...</option>'));
                $.each(level, function(key, value) {
                    $('.rank select').append($('<option>', { value: value }).text(value));
                });
                break;

            default:
                if (!$(this).parent().hasClass('full-width')) {
                    $(this).parent().addClass('full-width');
                    $(this).parent().parent().removeClass('dual')
                }
                if ($(".rank").length > 0) {
                    $(".rank").remove();
                }
                break;
        }
    });

    $('#newUserForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/addUser.php';
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
    //                                  A D D  M I D W A Y  I N F O
    //=================================================================================================
    var input = $('#midway');
    input.attr('readonly', false);
    $('span#plus').on('click', function() {
        if (input.val() >= 3) {
            return;
        } else {
            input.val(+input.val() + 1);
        }
        show_midway(input);
    })
    $('span#minus').on('click', function() {
        if (input.val() <= 0) {
            return;
        } else {
            input.val(+input.val() - 1);
            show_midway(input);
        }
    })

    $('#midway').on('keyup change', function() {
        if ($(this).val() > 3) {
            $(this).val('3');
        }
        show_midway($(this));
    });

    if ($('.rem.mid-content.edit').length > 0) {
        var totNum = $('.rem.mid-content.edit').length;
    } else {
        var totNum = 0;
    }

    function show_midway(params) {
        var num = params.val();
        if (num != "") {
            for (var i = num; i < totNum; i++) {
                $('#mid-box .rem:last-child').remove();
            }
            for (var i = totNum; i < num; i++) {
                var x = i;
                x++;
                $('#mid-box').append(
                    '<div class="rem mid-content">' +
                    '<div class="form-group dual">' +
                    '<div class="">' +
                    '<label for="midwayState" class="form-label">Midway State ' + x + '</label>' +
                    '<input type="text" class="form-control state" name="midwayState[]" id="midwayState" placeholder="E.g. Adamawa">' +
                    '<div class="show-off"></div>' +
                    '</div>' +
                    '<div class="">' +
                    '<label for="midwayLGA" class="form-label">Midway LGA ' + x + '</label>' +
                    '<select class="form-control lga" name="midwayLGA[]" id="midwayLGA" placeholder="">' +
                    '<option value="">Choose LGA...</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group dual">' +
                    '<div class="">' +
                    '<label for="midwayLongitude" class="form-label">Midway Longitude ' + x + '</label>' +
                    '<input type="text" class="form-control lng" name="midwayLongitude[]" id="midwayLongitude" readonly placeholder="E.g. 10. 12212322">' +
                    '</div>' +
                    '<div class="">' +
                    '<label for="midwayLatitude" class="form-label">Midway Latitude ' + x + '</label>' +
                    '<input type="text" class="form-control lat" name="midwayLatitude[]" id="midwayLatitude" readonly placeholder="E.g. 10. 12212322">' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
            }
            totNum = num;

            if (totNum == 0) {
                $('#mid-box .full-width').remove();
            }
        }
    }

    //=================================================================================================
    //                                  S T A T E S  A N D  C A P I T A L
    //=================================================================================================
    function getLGAs($param, $lga) {
        let link = '/includes/config/findProjectLocData.php?check=lga';
        $.ajax({
            url: link,
            type: "POST",
            data: 'keyword=' + $param,
            success: function(response) {
                $($lga).empty().append(response);
            }
        })
    }

    function getLngLat($param, $lat, $lng) {
        let link = '/includes/config/findProjectLocData.php?check=lnglat';
        $.ajax({
            url: link,
            type: "POST",
            data: 'keyword=' + $param,
            success: function(response) {
                // console.log(response);
                let loc = response.split(":");
                var latitude = loc[0];
                var longitude = loc[1];
                $($lat).val(latitude);
                $($lng).val(longitude);
            }
        })
    }

    $(document).on("keyup click", ".state ", function() {
        let link = '/includes/config/findProjectLocData.php';
        let show_off = $(this).siblings('.show-off');
        let data = $(this).val();
        $.ajax({
            url: link,
            type: "POST",
            data: 'keyword=' + data,
            success: function(response) {
                if (response.includes('error')) {
                    show_off.fadeOut();
                    error = response.split("=");
                    alert(error[1]);
                } else {
                    if (data.length == 0) {
                        show_off.fadeOut();
                    } else {
                        show_off.fadeIn().html(response);

                        var parent = show_off.parent();

                        $(document).mouseup(function(e) {
                            if ($(e.target).closest(parent).length) return;
                            if (!show_off.is(e.target) && show_off.has(e.target).length === 0) {
                                show_off.fadeOut();
                            }
                        });
                        $('.show-off ul li').click(function() {
                            parent.find('input').val($(this).html());
                            getLGAs($(this).html(), parent.siblings('div').find('select.lga'));
                            getLngLat($(this).html(), parent.parent().siblings('div').find('input.lat'), parent.parent().siblings('div').find('input.lng'));
                            show_off.fadeOut();
                        })
                    }
                }
            }
        })
    });
    //=================================================================================================
    //                                             A D D  P R O J E C T S
    //=================================================================================================
    $('input.number-input').keyup(function(e) {
        $(this).val(function(index, value) {
            // Keep only digits and decimal points:
            return value
                .replace(/[^\d.]/g, "")
                // Remove duplicated decimal point, if one exists:
                .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                // Keep only two digits past the decimal point:
                .replace(/\.(\d{2})\d+/, '.$1')
                // Add thousands separators:
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        });
    });
    $('#newProjectForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/addProject.php';
        let form = $('#newProjectForm')[0]; // You need to use standard javascript object here
        let data = new FormData(form);

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    href = response.split("=")[1];
                    // $('#recha').remove();
                    alert('The project data was saved successfully! You\'ll be directed to enter the project metrics shortly.');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
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
    //                                         A D D  P R O J E C T  M E T R I C S
    //=================================================================================================
    $('#newProjectMetricsForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/addProject.php';
        let form = $('#newProjectMetricsForm')[0]; // You need to use standard javascript object here
        let data = new FormData(form);

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    href = response.split("=")[1];
                    // $('#recha').remove();
                    alert('The project metrics was saved successfully!');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        const error_element = error[1].split("for ")[1];

                        $('html, body').animate({
                            scrollTop: $("#" + error_element).offset().top - 100
                        }, 1000);

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
    //                                             E D I T  P R O J E C T S
    //=================================================================================================
    $('#editProjectForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/editProject.php';
        let form = $('#editProjectForm')[0]; // You need to use standard javascript object here
        let data = new FormData(form);

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    href = response.split("=")[1];
                    // $('#recha').remove();
                    alert('The project data was saved successfully! You\'ll be directed to enter the project metrics shortly.');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
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
    //                                             E D I T  P R O J E C T  M E T R I C S
    //=================================================================================================
    $('#editProjectMetricsForm #btn-submit').click(function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/editProject.php';
        let form = $('#editProjectMetricsForm')[0]; // You need to use standard javascript object here
        let data = new FormData(form);

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    href = response.split("=")[1];
                    // $('#recha').remove();
                    alert('The project metrics was saved successfully!');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        const error_element = error[1].split("for ")[1];

                        $('html, body').animate({
                            scrollTop: $("#" + error_element).offset().top - 100
                        }, 1000);

                        alert(error[1]);
                    } else {
                        alert(response);
                    }
                    // $('#recha').remove();
                }
            }
        })
    });

    //=================================================================================================
    //                                     M O D A L  C L O S E
    //=================================================================================================
    $(document).on('click', '.modal-close', function(e) {
        e.preventDefault();
        $('.modal').addClass('fadeOut');
        setTimeout(() => {
            $('.modal').addClass('hidden');
        }, 600);
    })

    //=================================================================================================
    //                             A P P R O V E  P R O J E C T S  M O D A L
    //=================================================================================================
    $('.approve').on('click', function(e) {
        e.preventDefault();
        $('.content').append(
            `<div class="modal full-width text-align-center d-flex flex-column justify-content-center align-items-center">
                <div class="modal-content">
                    <div class="modal-content-text">
                        <p class="h4 notice"><i class="las la-check-circle"></i><br/>Select a list below to finish approving this project...</p>
                    </div>
                    <div class="radio-container d-flex full-width justify-content-center align-items-center">
                        <label class="container">
                            <input type="radio" name="project-type-list" value="priority-list">
                            <span class="checkmark"></span>
                            <span>Priority List</span>
                        </label>
                        <label class="container">
                            <input type="radio" name="project-type-list" value="execution-list">
                            <span class="checkmark"></span>
                            <span>Execution List</span>
                        </label>
                    </div>
                    <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                        <a class="btn tertiary modal-close" href="#" id="modal-close">I\'ll do that later</a>
                        <a class="btn approve-go" href="#" id="go-metrics">Approve this project</a>
                    </div>
                </div>
            </div>`
        );
    })

    $(document).on('click', '.approve-go', function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let project_id = $("input#project_id").val();
        let list_type = $("input[name='project-type-list']:checked").val();
        let link = '/includes/config/approveProject.php';

        $.ajax({
            url: link,
            type: "POST",
            data: {
                project_id: project_id,
                list_type: list_type,
            },
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];
                    // $('#recha').remove();
                    alert(message);
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
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
    //                             S U S P E N D  P R O J E C T S  M O D A L
    //=================================================================================================
    $('.suspend').on('click', function(e) {
        e.preventDefault();
        $('.content').append(
            `<div class="modal full-width text-align-center d-flex flex-column justify-content-center align-items-center">
                <div class="modal-content">
                    <div class="modal-content-text">
                        <p class="h4 notice"><i style="color: var(--danger);" class="las la-exclamation-triangle"></i><br/>Are you sure you want to suspend this project?</p>
                    </div>
                    <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                        <a class="btn secondary modal-close" href="#" id="modal-close">No, do not suspend it</a>
                        <a class="btn suspend-go danger" href="#" id="go-metrics">Yes, suspend it</a>
                    </div>
                </div>
            </div>`
        );
    })
    $(document).on('click', '.suspend-go', function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let project_id = $("input#project_id").val();
        let link = '/includes/config/suspendProject.php';

        $.ajax({
            url: link,
            type: "POST",
            data: {
                project_id: project_id,
            },
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];
                    // $('#recha').remove();
                    alert(message);
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        alert(error[1]);
                    } else {
                        alert(response);
                    }
                    // $('#recha').remove();
                }
            }
        })
    })

    //=================================================================================================
    //                            R E A C T I V A T E  P R O J E C T S  M O D A L
    //=================================================================================================
    $('.activate').on('click', function(e) {
        e.preventDefault();
        $('.content').append(
            `<div class="modal full-width text-align-center d-flex flex-column justify-content-center align-items-center">
                <div class="modal-content">
                    <div class="modal-content-text">
                        <p class="h4 notice"><i class="las la-check-circle"></i><br/>Are you sure you want to re-activate this project?</p>
                    </div>
                    <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                        <a class="btn tertiary modal-close" href="#" id="modal-close">No, leave it</a>
                        <a class="btn activate-go" href="#" id="go-metrics">Yes, re-activate it</a>
                    </div>
                </div>
            </div>`
        );
    })
    $(document).on('click', '.activate-go', function(e) {
        e.preventDefault();
        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let project_id = $("input#project_id").val();
        let link = '/includes/config/reactivateProject.php';

        $.ajax({
            url: link,
            type: "POST",
            data: {
                project_id: project_id,
            },
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];
                    // $('#recha').remove();
                    alert(message);
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        alert(error[1]);
                    } else {
                        alert(response);
                    }
                    // $('#recha').remove();
                }
            }
        })
    })

    //=================================================================================================
    //                            C O M P A R E  P R O J E C T S
    //=================================================================================================
    $(document).on('change', '.compare-select', function(e) {
        var parent_siblings = $(this).parent().parent().siblings('.form-group');
        var parent_next_select = $(this).parent().parent().next().find('.compare-select');
        var options = $(this).children("option:not(:selected)").clone();
        // var options_all = $(this).children("option").clone();
        var id = $(this).find('option:selected').attr('id');
        var finder = ($(this).attr('id')).split("-")[1];


        if ($(parent_next_select).children().length == 1) {
            $(parent_next_select).empty().append(options);
        } else {
            // if ($(parent_next_select).children().length > 1) {}
            for (let len = 0; len <= parent_siblings.length; len++) {
                // for (let len = 0; len < parent_siblings.length; len++) {

                if ($(this).val() === $(parent_siblings[len]).find('.compare-select').val()) {
                    var find_val_class = ($(parent_siblings[len]).find('.compare-select').attr('id')).split("-")[1];
                    $('p[id$="-' + find_val_class + '"]').html('-');
                    $(parent_siblings[len]).find('.compare-select option#' + id).remove();
                }

                for (let option_len = 0; option_len < options.length; option_len++) {
                    var option_id = options[option_len].id;
                    if (option_id != '') {
                        if (!$(parent_siblings[len]).find('.compare-select option#' + option_id).length) {
                            $(parent_siblings[len]).find('.compare-select').remove('option#' + option_id).append('<option id="' + option_id + '" value="' + options[option_len].value + '">' + options[option_len].value + '</option>');
                        }
                    }
                }
            }
        }

        // $('body').prepend('<span id = "recha"><i class="fas fa-3x fa-spinner fa-spin"></i></span>');
        let link = '/includes/config/compareProject.php';
        var project = $(this).find('option:selected').val();

        $.ajax({
            url: link,
            type: "POST",
            data: {
                project: project,
            },
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    // $('#recha').remove();
                    var rankingsList = response.split("=")[1];
                    var ranking = rankingsList.split("-");

                    $('.val').html() == '-' || $('.val').html() != '' ? '' : $('.val').html('-');

                    $('#score-' + finder).html(ranking[0]);
                    $('#rank-' + finder).html(ranking[1]);
                    $('#fund-' + finder).html(ranking[2]);
                    $('#population-' + finder).html(ranking[3].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#co2-' + finder).html(ranking[4].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#jobs-' + finder).html(ranking[5].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

                    $('.compare-bottom').removeClass('hidden');

                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        alert(error[1]);
                    } else {
                        alert(response);
                    }
                    // $('#recha').remove();
                }
            }
        })


    })
})