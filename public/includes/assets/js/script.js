$(document).ready(function() {
    //=================================================================================================
    //                                  D A S H B O A R D  C O U N T S
    //=================================================================================================

    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).data('value')
        }, {
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                $(this).text(this.Counter.toFixed(0));
            }
        });
    });
    //=================================================================================================
    //                                              A L E R T S
    //=================================================================================================
    function showAlertNotification(message, type) {
        $('.alert').removeClass("alert-right").removeClass(type + "-message");
        $('.alert p').text(message);

        if (type == 'error') {
            $('.alert').addClass("alert-right").addClass(type + "-message");
        } else {
            $('.alert').addClass("alert-right").addClass(type + "-message");
        }

        setTimeout(() => {
            $('.alert').removeClass("alert-right") //.removeClass(type + "-message");
        }, 5000);
        setTimeout(() => {
            $('.alert').removeClass(type + "-message") //.removeClass(type + "-message");
        }, 5500);
    }

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
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Logging you in...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('Your login was successful!', 'success');
                    setTimeout('window.location.href = "/dashboard"', 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error')
                    }
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
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Creating your user...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('The user data was saved successfully!', 'success');
                    setTimeout('window.location.href = "/users"', 500);
                } else {
                    error = response.split("=");
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
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
                    showAlertNotification(error[1], 'error');
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
    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {
            // get position of first decimal this prevents multiple decimals from being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            // input_val = "$" + left_side + "." + right_side;
            input_val = left_side + "." + right_side;
        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            // input_val = "$" + input_val;
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                // input_val += ".00";
                input_val += "";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    $('input.number-input').on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });
    $('#newProjectForm #btn-submit').click(function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Redirecting you to Project metrics...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('The project data was saved successfully! You\'ll be directed to enter the project metrics shortly.', 'success');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
                }
            }
        })
    });
    //=================================================================================================
    //                                         A D D  P R O J E C T  M E T R I C S
    //=================================================================================================
    $('#newProjectMetricsForm #btn-submit').click(function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Saving Project Metrics...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('The project metrics was saved successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        const error_element = error[1].split("for ")[1];

                        $('html, body').animate({
                            scrollTop: $("#" + error_element).offset().top - 100
                        }, 1000);

                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
                }
            }
        })
    });

    //=================================================================================================
    //                                             E D I T  P R O J E C T S
    //=================================================================================================
    $('#editProjectForm #btn-submit').click(function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Updating project data...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('The project data was saved successfully! You\'ll be directed to enter the project metrics shortly.', 'success');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
                }
            }
        })
    });
    //=================================================================================================
    //                                             E D I T  P R O J E C T  M E T R I C S
    //=================================================================================================
    $('#editProjectMetricsForm #btn-submit').click(function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Updating project metrics...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification('The project metrics was saved successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        const error_element = error[1].split("for ")[1];

                        $('html, body').animate({
                            scrollTop: $("#" + error_element).offset().top - 100
                        }, 1000);

                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
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
    $(document).on('click', '.modal-open', function(e) {
        e.preventDefault();
        let modal = $(this).data('modal');
        $('.' + modal).removeClass('hidden');
        setTimeout(() => {
            $('.' + modal).removeClass('fadeOut');
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
                        <p class="p4 notice"><span><i class="las la-check-circle"></i></span><br/>Select a list below to finish approving this project...</p>
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
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Approving project...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification(message, 'success');
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
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
                        <p class="p4 notice"><span style="background-color: #f78a8aba"><i style="color: var(--danger);" class="las la-exclamation-triangle"></i></span><br/>Are you sure you want to suspend this project?</p>
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
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Suspending project...</p></span>');
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
                    $('#recha').remove();
                    showAlertNotification(message, 'success');
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
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
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Reactivating project...</p></span>');
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
                    $('#recha').remove();
                    message = response.split("=")[1];
                    showAlertNotification(message, 'success');
                    setTimeout(() => {
                        window.location.href = '/projects';
                    }, 500);
                } else {
                    error = response.split("=");
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
                }
            }
        })
    })

    //=================================================================================================
    //                            C O M P A R E  P R O J E C T S
    //=================================================================================================
    $(document).on('change', '.compare-select', function(e) {
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Loading project comparisons...</p></span>');

        var parent_siblings = $(this).parent().parent().siblings('.form-group');
        var parent_next_select = $(this).parent().parent().next().find('.compare-select');
        var options = $(this).children("option:not(:selected)").clone();
        // var options_all = $(this).children("option").clone();
        var id = $(this).find('option:selected').attr('id');
        var finder = ($(this).attr('id')).split("-")[1];
        let link = '/includes/config/compareProject.php';
        var project = $(this).find('option:selected').val();


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

        $.ajax({
            url: link,
            type: "POST",
            data: {
                project: project,
            },
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    $('#recha').remove();
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
                    $('#recha').remove();
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
                }
            }
        })
    });

    //=================================================================================================
    //                            C R E A T E   B U D G E T
    //=================================================================================================
    $(document).on('click', '#budget-create', function(e) {
        e.preventDefault();

        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Creating budget...</p></span>');
        let link = '/includes/config/jobBudget.php';
        let form = $('#budget-form')[0]; //You need to use standard javascript object here
        let data = new FormData(form);
        var input = $(this).parent().siblings().find('input:not(.total)');
        var button = $(this).parent().find('button');

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];

                    $('#recha').remove();
                    showAlertNotification(message, 'success');
                    setTimeout(() => {
                        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Refreshing...</p></span>');
                        window.location.href = window.location.href;
                    }, 5500);
                } else {
                    $('#recha').remove();
                    error = response.split("=");
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
                }
            }
        })
    });

    $(document).on('click', '#edit-budget', function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Please wait...</p></span>');
        var input = $(this).parent().siblings().find('input#amount');
        input.removeAttr('readonly');
        $(this).html('Update Annual Budget');
        $(this).attr('id', 'budget-create');
        $('#recha').remove();
    });

    $(document).on('input', '#funding', function(e) {
        let main_budget = parseFloat($('#fullBudget').val().replace(/,/g, ''));
        input_keyup = 1;
        distributeBudget($(this), main_budget, input_keyup);
    });

    $(document).on('click', '#assign-evenly', function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Please wait...</p></span>');
        let main_budget = parseFloat($('#fullBudget').val().replace(/,/g, ''));

        var input = $("input#funding");
        var inputs = input.length;
        input_keyup = 0;

        var funding = main_budget / inputs;

        input.each(function() {
            $(this).val(funding.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
            distributeBudget($(this), main_budget, input_keyup);
        });

        $('#recha').remove();
    });

    $(document).on('click', '#assign-score', function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Please wait...</p></span>');
        let main_budget = parseFloat($('#fullBudget').val().replace(/,/g, ''));

        var input = $("input#funding");
        input_keyup = 0;

        total_score = 0
        input.each(function() {
            total_score += parseInt($(this).data('score'));
        });

        score = total_score

        input.each(function() {
            var funding = parseFloat($(this).data('score') / score) * main_budget;
            $(this).val(funding.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
            distributeBudget($(this), main_budget, input_keyup);
        });

        $('#recha').remove();
    });

    function distributeBudget(input, budget, input_keyup) {
        var siblings_input = input.parent().parent().siblings().find('input#funding')

        funding = 0
        sum = 0
        siblings_input.each(function() {
            sum += parseFloat($(this).val().replace(/,/g, ''))
        });

        var project_cost = input.data('cost');

        if (input.val().length === 0) {
            funding = 0
        } else {
            var funding = parseFloat(input.val().replace(/,/g, ''));
        }

        totalfunding = parseFloat(sum.toFixed(2)) + parseFloat(funding.toFixed(2));

        if (funding < project_cost) {
            var shortfall = 0;
        } else {
            var shortfall = funding - project_cost;
        }

        if (totalfunding > budget && input_keyup === 1) {
            showAlertNotification('You cannot enter an amount that will result in a sum greater than the total budget!', 'error');
            setTimeout(() => {
                remaining_budget = parseFloat($('.funding-val').text().replace(/,/g, ''));
                input.val((budget - sum - remaining_budget).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                input.parent().siblings().find('#shortfall').val(((budget - sum - remaining_budget) - project_cost).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

            }, 2500);
            budgetleft = 0
        } else {
            var budgetleft = budget - totalfunding;
        }

        $('.funding-val').text(budgetleft.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('#leftBudget').val(budgetleft.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        input.parent().siblings().find('#shortfall').val(shortfall.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    };

    $(document).on('click', '#budget-dist-save', function(e) {
        e.preventDefault();

        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Updating project budget...</p></span>');
        let link = '/includes/config/jobBudget.php';
        let form = $('#budget-list-form')[0]; //You need to use standard javascript object here
        let data = new FormData(form);
        var input = $(this).parent().siblings().find('input:not(.total)');
        var button = $(this).parent().find('button');

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];

                    $('#recha').remove();
                    showAlertNotification(message, 'success');
                    setTimeout(() => {
                        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Refreshing...</p></span>');
                        window.location.href = window.location.href;
                    }, 5500);
                } else {
                    $('#recha').remove();
                    error = response.split("=");
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');
                    }
                }
            }
        })
    });

    //=================================================================================================
    //                            E D I T  J O B S
    //=================================================================================================
    $(document).on('click', '#edit-jobs', function(e) {
        e.preventDefault();
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Please wait...</p></span>');
        var input = $(this).parent().siblings().find('input:not(.total)');
        input.removeAttr('readonly');
        $(this).html('Save data');
        $(this).attr('id', 'btn-submit');
        $('#recha').remove();
    });


    $(document).on('keyup', '#jobFormEdit input:not(.total)', '#jobFormEdit input:not(.budget_per_total_jobs)', function(e) {
        const direct = $('#jobFormEdit input.direct').val() != '' ? parseInt($('#jobFormEdit input.direct').val().replace(/,/g, '')) : 0;
        const indirect = $('#jobFormEdit input.indirect').val() != '' ? parseInt($('#jobFormEdit input.indirect').val().replace(/,/g, '')) : 0;
        const induced = $('#jobFormEdit input.induced').val() != '' ? parseInt($('#jobFormEdit input.induced').val().replace(/,/g, '')) : 0;

        let grndTotal = direct + indirect + induced;

        $('#jobFormEdit input.total').val(grndTotal);
        $('#jobFormEdit input.total').val($('#jobFormEdit input.total').val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

    });

    $(document).on('change', '#jobs-sectorList', function(e) {
        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Getting jobs data...</p></span>');
        var sector = $(this).val();
        let link = '/includes/config/jobBudget.php';
        $.ajax({
            url: link,
            type: "POST",
            data: {
                sector: sector,
            },
            success: function(response) {
                if (response.split("!=")[0] === 'success') {
                    $('#recha').remove();
                    var jobs_budget = response.split("!=")[1];
                    $('#jobs-stats-metrics').html(jobs_budget);

                } else {
                    $('#recha').remove();
                    error = response.split("=");
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
                }
            }
        })
    })

    $(document).on('click', '#jobFormEdit #btn-submit', function(e) {
        e.preventDefault();

        $('body').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Updating jobs data...</p></span>');
        let link = '/includes/config/jobBudget.php';
        let form = $('#jobFormEdit')[0]; // You need to use standard javascript object here
        let data = new FormData(form);
        var input = $(this).parent().siblings().find('input:not(.total)');
        var button = $(this).parent().find('button');

        $.ajax({
            url: link,
            processData: false,
            contentType: false,
            type: "POST",
            data: data,
            success: function(response) {
                if (response.split("=")[0] === 'success!') {
                    message = response.split("=")[1];

                    input.prop('readonly', true);
                    button.html('Edit data');
                    button.prop('id', 'edit-jobs');

                    $('#recha').remove();
                    showAlertNotification(message, 'success');
                } else {
                    $('#recha').remove();
                    error = response.split("=");
                    if (error[0] === 'error') {
                        showAlertNotification(error[1], 'error');
                    } else {
                        showAlertNotification(response, 'error');;
                    }
                }
            }
        })
    });

    //=================================================================================================
    //                            P R I N T E R
    //=================================================================================================
    function printDiv(divName) {
        var printContents = divName.html();
        var originalContents = $('body').html();
        let header = `<div class="header" style="background-color: #049a5d; color: #fff; padding: 32px 0px; font-weight: 700; font-size: 13px;">Infrastructre Selection and Prioritization System</div><hr/>`;

        $('body').css({ "padding-left": "0" }).html(header + printContents);
        $('.p-name, .p5, legend').css({ "font-size": "10px" });
        $('.p3').css({ "font-size": "14px" });
        $('h2, .h2').css({ "font-size": "12px", "text-align": "left" });
        $('.percentage').css({ "font-size": "4px" });
        $('.progress').css({ "margin-bottom": "12px" });
        $('.info_top_right').css({ "width": "100%", "text-align": "center" });
        $('.info_top_left').css({ "width": "100%" });
        $('.single-chart').css({ "justify-content": "flex-start", "text-align": "left", "width": "120px" });
        $('.info_bottom_title').css({ "margin-bottom": "12px" });
        $('.top-title').css({ "margin-bottom": "0" });
        $('.circular-chart').css({ "max-height": "120px", "max-width": "100%", "margin": "10px 0", "display": "inline" });
        $('.info_top').css({ "flex-direction": "column-reverse", "align-items": "flex-start", "padding-top": "0" });
        $('.info_bottom_body fieldset').css({ "padding": "24px 16px" });
        $('.info_bottom_body span:last-child, .p-data').css({ "font-size": "10px" });

        window.print();
        $('body').removeAttr('style');
        $('.p-name, .p5, legend').removeAttr('style');
        $('.p3').removeAttr('style');
        $('h2, .h2').removeAttr('style');
        $('.percentage').removeAttr('style');
        $('.progress').removeAttr('style');
        $('.info_top_right').removeAttr('style');
        $('.info_top_left').removeAttr('style');
        $('.single-chart').removeAttr('style');
        $('.info_bottom_title').removeAttr('style');
        $('.circular-chart').removeAttr('style');
        $('.top-title').removeAttr('style');
        $('.info_top').removeAttr('style');
        $('.info_bottom_body fieldset').removeAttr('style');
        $('.info_bottom_body span:last-child, .p-data').removeAttr('style');
        $('body').html(originalContents);

    }
    $('#downloadPDF').click(function() {
        let div = $('#proj-info');
        printDiv(div);
    });


    //=================================================================================================
    //                            S E A R C H  P R O J E C T S
    //=================================================================================================
    let originalList = $('.projects-List').html();
    $('.main_project_search input').on("keyup", function() {

        $('.projects-List #recha').remove();
        $('.projects-List').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Searching...</p></span>');

        if ($('.main_project_search input').val().length === 0) {
            $('.projects-List #recha').remove();
            $('.projects-List').html(originalList);
        } else {
            $.ajax({
                url: '/includes/config/searchProjects.php',
                type: "POST",
                data: 'keyword=' + $(this).val(),
                success: function(response) {
                    $('.projects-List').html(response);
                }
            });
        }
    });

    //=================================================================================================
    //                            F I L T E R  P R O J E C T S
    //=================================================================================================
    $('.filter').on("click", function() {

        $('.projects-List #recha').remove();
        $('.projects-List').prepend('<span id="recha"><i class="las la-sync"></i><p class="p4">Searching...</p></span>');

        if ($(this).siblings().hasClass('active')) {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        } else {
            $(this).toggleClass('active');
        }

        if ($(this).hasClass('active')) {
            let search = $(this).data('value');
            $.ajax({
                url: '/includes/config/filterProjects.php',
                type: "POST",
                data: 'keyword=' + search,
                success: function(response) {
                    $('.projects-List').html(response);
                }
            });
        } else {
            $('.projects-List #recha').remove();
            $('.projects-List').html(originalList);
        }
    });

    //=================================================================================================
    //                            D A S H B O A R D  C H A R T
    //=================================================================================================
    if (window.location.href.indexOf("dashboard") > -1 || window.location.pathname == '/' || window.location.href.indexOf("sector") > -1) {
        //--------------------------------------------
        //------------------Regions categorization
        //--------------------------------------------
        var data = { labels: [], count: [] }

        for (let i = 0; i < chartRegions.length; i++) {
            data.labels.push(chartRegions[i]['region'])
            data.count.push(chartRegions[i]['count'])
        }

        var type = 'project(s)';
        var fixed_num = 0;
        var currency = '';
        var geoPieElement = document.getElementById("geoPieChart");
        makePieChat(geoPieElement, data, type, fixed_num, currency);


        //--------------------------------------------
        //---------------------Funds categorization
        //--------------------------------------------
        var funds = { labels: [], count: [] }

        for (let i = 0; i < chartFunds.length; i++) {
            funds.labels.push(chartFunds[i]['label'])
            funds.count.push(chartFunds[i]['count'])
        }

        var type = 'project(s)';
        var fixed_num = 0;
        var currency = '';
        var fundPieElement = document.getElementById("fundingTypeChart");
        makePieChat(fundPieElement, funds, type, fixed_num, currency);
        //--------------------------------------------
        //-----Funding and shortfalls categorization
        //--------------------------------------------
        var funding = { labels: [], count: [] }

        for (let i = 0; i < projectShortfallTypeChart.length; i++) {
            funding.labels.push(projectShortfallTypeChart[i]['label'])
            funding.count.push(projectShortfallTypeChart[i]['count'])
        }

        var type = '';
        var fixed_num = 2;
        var currency = '₦';
        var fundPieElement = document.getElementById("projectShortfallTypeChart");
        makePieChat(fundPieElement, funding, type, fixed_num, currency);
        //--------------------------------------------
        //-----Category Type categorization
        //--------------------------------------------
        var metrics = { labels: [], fullLabels: [], count: [] }

        for (let i = 0; i < metricsArrayBarChart.length; i++) {
            metrics.labels.push(metricsArrayBarChart[i]['label'].substring(0, 3))
            metrics.fullLabels.push(metricsArrayBarChart[i]['label'])
            metrics.count.push(metricsArrayBarChart[i]['count'])
        }
        console.log(metricsArrayBarChart)

        var metricsBarElement = document.getElementById("metricsArrayBarChart");
        makeBarChat(metricsBarElement, metrics, bp = 0.5);
    }

    function makePieChat(pieElement, data, type, fixed_num, currency) {
        var canvasP = pieElement;
        var ctxP = canvasP.getContext('2d');
        var myPieChart = new Chart(
            ctxP, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Number of Projects',
                        data: data.count,
                        backgroundColor: ["#64B5F6", "#1dbd47", "#002c91", "#ff6e07", "#db3737", "#a56e2a"],
                        hoverBackgroundColor: ["#B2EBF2", "#95e0a8", "#698ad5", "#ffd557", "#e56d6d", "#b98e59"]
                    }]
                },
                options: {
                    responsive: false,
                    spacing: 0,
                    borderRadius: 2,
                    plugins: {
                        labels: {
                            render: function(ctxP) {
                                let sum = 0;
                                let dataArr = ctxP.dataset.data;
                                $.each(dataArr, function() {
                                    sum += parseInt(this, 10);
                                });
                                let percentage = ((ctxP.value / sum) * 100).toFixed(2) + "%";

                                return `${percentage}`;
                            },
                            fontColor: '#fff',
                            fontStyle: 'bold',
                            fontSize: 11,
                        },
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                usePointStyle: true,
                                boxWidth: 10
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctxP) {
                                    return `${ctxP.label} - ${currency}${ctxP.parsed.toFixed(fixed_num).replace(/\d(?=(\d{3})+\.)/g, '$&,')} ${type}`;
                                }
                            }
                        }
                    }
                }
            }
        )
    }

    function makeBarChat(barElement, data, bp) {
        var canvasP = barElement;
        var ctxP = canvasP.getContext('2d');
        var myBarChart = new Chart(
            ctxP, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        barPercentage: bp,
                        label: 'Project Type Distribution',
                        data: data.count,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(204, 175, 186)',
                            'rgb(15, 209, 15)',
                            'rgb(232, 162, 126)',
                            'rgb(249, 22, 246)',
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(204, 175, 186)',
                            'rgb(15, 209, 15)',
                            'rgb(232, 162, 126)',
                            'rgb(249, 22, 246)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]

                },
                options: {
                    legend: {
                        display: false,
                        position: 'bottom',
                        labels: {
                            boxWidth: 0
                        }
                    },
                    plugins: {
                        labels: {
                            render: () => {}
                        },
                        tooltip: {
                            callbacks: {
                                afterTitle: (ctxP) => 'Project Type: ' + data.fullLabels[ctxP['0'].dataIndex]
                            }
                        },
                        legend: {
                            display: false,
                            labels: {
                                boxWidth: 0
                            }
                        }
                    },
                }
            }
        )
    }

})