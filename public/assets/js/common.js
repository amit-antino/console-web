// const { exit } = require("browser-sync");

jQuery.fn.exists = function () {
    return this.length > 0;
};
$(document).on("click", '[data-request="remove"]', function () {
    var $this = $(this);
    var $target = $this.attr("data-target");
    $($target).hide("slow", function () {
        $($target).remove();
    });
});

$(document).on("click", '[data-request="ajax-submit"]', function () {
    /*REMOVING PREVIOUS ALERT AND ERROR CLASS*/
    $("#cover").show();
    $("#submit_button_id").hide();
    $("#submit_button_loader").show();
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".help-block").remove();
    var $this = $(this);
    var $target = $this.data("target");
    var $url = $($target).attr("action");
    var $method = $($target).attr("method");
    var $modal = $this.data("modal");
    var $data = new FormData($($target)[0]);
    if ($("#ace_html").length) {
        var editor = ace.edit("ace_html");
        var $file_details = editor.getValue();
        $data.append("file_details", $file_details);
    }
    if ($("#simpleMdeExample").length) {
        var simplemde = new SimpleMDE({
            element: $("#simpleMdeExample")[0],
        });
        var $note = simplemde.value();
        $data.append("note", $note);
    }
    if (!$method) {
        $method = "get";
    }

    $.ajax({
        url: $url,
        data: $data,
        cache: false,
        type: $method,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function ($response) {
            if ($response.status === true) {
                if ($response.redirect) {
                    if ($response.modal) {
                        $($target).trigger("reset");
                        $($modal).attr("data-success", $response.redirect);
                        if ($response.successimage == "error") {
                            link_err =
                                '<a href="/custome_error?lat=' +
                                $response.message +
                                ">Why do I have this issue?</a>";
                            title_msg = "Oops...";
                            msg = "Something went wrong! Please Contact Admin";
                        } else {
                            link_err = "";
                            msg = $response.message;
                            title_msg = "";
                        }

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: $response.successimage,
                            title: $response.message,
                        });

                        if ($response.redirect == "reload_fail") {
                            //window.location.reload(true);
                            if ($response.triggertab != false) {
                                $(".modal").modal("hide");
                                $($response.triggertab).trigger("click");
                            }
                            return false;
                        }
                        if ($response.redirect != true) {
                            setTimeout(function () {
                                window.location.href = $response.redirect;
                            }, 10);
                        }
                        if ($response.redirect == true) {
                            window.location.reload(true);
                        }
                    } else {
                        if ($response.redirect == "reload_fail") {
                            if ($response.triggertab != false) {
                                $($response.triggertab).trigger("click");
                            }
                            return false;
                        }
                        if ($response.redirect != true) {
                            window.location.href = $response.redirect;
                        }
                        if ($response.redirect == true) {
                            window.location.reload(true);
                        }
                    }
                }
            } else {
                if (
                    $response.message.length > 0 &&
                    $response.message !== "M0000"
                ) {
                    $(".messages").html($response.message);
                }

                if (Object.size($response.data) > 0) {
                    // onloadCallback();
                    show_validation_error($response.data);
                }
            }
            $("#cover").hide();
            $("#submit_button_loader").hide();
            $("#submit_button_id").show();
        },
    });
    $("#submit_button_loader").hide();
    $("#submit_button_id").show();
});

$(document).on("click", '[data-request="ajax-confirm"]', function () {
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $url = $this.data("url");
    var $ask = $this.data("ask");
    if (
        $this.data("ask_image") == "undefined" ||
        $this.data("ask_image") == ""
    ) {
        var $askImage = "";
    } else {
        var $askImage = $this.data("ask_image");
    }

    var $method = $this.data("method");
    var $target = $this.data("target");
    var $id = $this.data("id");
    var $appendId = $this.data("name");
    if (typeof $appendId !== "undefined" || $appendId == "") {
        $appendId = $this.data("name");
    } else {
        $appendId = "";
    }
    if ($id == "bulk-delete") {
        $("#popup").show();
        $(".alert").remove();
        $(".has-error").removeClass("has-error");
        $(".error-message").remove();
        var $values = $("input[name='select_all" + $appendId + "[]']:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
        if (typeof $values !== "undefined" && $values.length == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        $formData.append("bulk[]", $values);
    }
    swal.fire({
        html: $ask,
        showLoaderOnConfirm: true,
        showCancelButton: true,
        showCloseButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        // imageUrl :  $askImage,
        icon: $askImage,
        imageClass: "ask-image-popup",
        confirmButtonText: "YES, SURE",
        cancelButtonText: "NOT NOW",
        confirmButtonColor: "#0FA1A8",
        cancelButtonColor: "#CFCFCF",
        preConfirm: function (res) {
            return new Promise(function (resolve, reject) {
                if (res === true) {
                    $.ajax({
                        method: $method,
                        url: $url,
                        data: $formData,
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                    }).done(function ($response) {
                        if ($response.status == true) {
                            if (typeof LaravelDataTables !== "undefined") {
                                LaravelDataTables["dataTableBuilder"].draw();
                            }
                            if ($response.message) {
                                if ($(".alert").length > 0) {
                                    $("html, body").animate(
                                        {
                                            scrollTop:
                                                $(".alert").offset().top - 100,
                                        },
                                        200
                                    );
                                }
                            }
                            if ($response.redirect == "reload_fail") {
                                if ($target == "#process-simulation") {
                                    $($target).html(response.html);
                                    swal.close();
                                } else $($target).remove();
                            } else {
                                if ($response.redirect != true) {
                                    window.location.href = $response.redirect;
                                } else if ($response.redirect === true) {
                                    if ($response.message) {
                                        // swal.fire({
                                        //     text: $response.message,
                                        //     confirmButtonText: "Close",
                                        //     confirmButtonClass: "btn btn-danger",
                                        //     width: "350px",
                                        //     height: "10px",
                                        //     icon: "warning",
                                        // });
                                        // setTimeout(function () {
                                        //     window.location.reload(1);
                                        // }, 500);
                                        //return false
                                    } else {
                                        window.location.reload();
                                    }
                                } else if ($($response.redirect).length > 0) {
                                    $($response.redirect).remove();
                                }
                            }
                            resolve();
                        }
                    });
                }
            });
        },
    })
        .then(
            function (isConfirm) {
                if (
                    $target == "#auth_logo_remove" ||
                    $target == "#main_logo_remove" ||
                    $target == "#banner_image_remove" ||
                    $target == "#process-simulation"
                ) {
                } else window.location.reload();
            },
            function (dismiss) {}
        )
        .catch(swal.noop);
});

$(document).on("change", '[data-request="ajax-confirm-change"]', function () {
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $url = $this.data("url");
    var $ask = $this.data("ask");
    var $askImage = $this.data("ask_image");
    var $method = $this.data("method");
    var $target = $this.data("target");
    var $id = $this.data("id");
    console.log($(this).val());
    $formData.append("status_name", $(this).val());
    swal.fire({
        html: $ask,
        showLoaderOnConfirm: true,
        showCancelButton: true,
        showCloseButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        // imageUrl :  $askImage,
        icon: $askImage,
        imageClass: "ask-image-popup",
        confirmButtonText: "YES, SURE",
        cancelButtonText: "NOT NOW",
        confirmButtonColor: "#0FA1A8",
        cancelButtonColor: "#CFCFCF",
        preConfirm: function (res) {
            return new Promise(function (resolve, reject) {
                if (res === true) {
                    $.ajax({
                        method: $method,
                        url: $url,
                        data: $formData,
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                    }).done(function ($response) {
                        if ($response.status == true) {
                            if (typeof LaravelDataTables !== "undefined") {
                                LaravelDataTables["dataTableBuilder"].draw();
                            }
                            if ($response.message) {
                                if ($(".alert").length > 0) {
                                    $("html, body").animate(
                                        {
                                            scrollTop:
                                                $(".alert").offset().top - 100,
                                        },
                                        200
                                    );
                                }
                            }
                            if ($response.redirect == "reload_fail") {
                                //var $this = $(this);
                                //var $target = $this.attr("data-target");
                                $($target).hide("slow", function () {
                                    $($target).remove();
                                });
                            } else {
                                if ($response.redirect != true) {
                                    window.location.href = $response.redirect;
                                } else if ($response.redirect === true) {
                                    if ($response.message) {
                                        swal.fire({
                                            text: $response.message,
                                            confirmButtonText: "Close",
                                            confirmButtonClass:
                                                "btn btn-danger",
                                            width: "350px",
                                            height: "10px",
                                            icon: "warning",
                                        });
                                        return false;
                                    } else {
                                        window.location.reload();
                                    }
                                } else if ($($response.redirect).length > 0) {
                                    $($response.redirect).remove();
                                }
                            }
                            resolve();
                        }
                    });
                }
            });
        },
    })
        .then(
            function (isConfirm) {},
            function (dismiss) {}
        )
        .catch(swal.noop);
});

$(document).on("click", '[data-request="add-another"]', function () {
    $("#popup").show();
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $target = $this.data("target");
    var $url = $this.data("url");
    var $type = $this.data("types");
    var $count = parseInt($this.attr("data-count"));
    var $new_count = parseInt($this.attr("data-new_count"));
    if ($new_count != "") {
        $formData.append("new_count", $new_count);
    } else {
        $formData.append("new_count", 0);
    }
    $count + 1;
    $this.attr("data-count", $count + 1);
    $formData.append("count", $count);
    $formData.append("type", $type);
    $.ajax({
        url: $url,
        type: "POST",
        data: $formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
            if ($response.status == true) {
                $($response.html).hide().appendTo($target).fadeIn(1000);
                if ($(".js-example-basic-single").length) {
                    $(".js-example-basic-single").select2();
                }
                $(".add_more_recommended").change(function () {
                    $(".add_more_recommended").prop("checked", false);
                    $(this).prop("checked", true);
                });
            }
        },
    });
});

$(document).on(
    "click",
    '[data-request="add-another-with-form-data"]',
    function () {
        $("#popup").show();
        $(".alert").remove();
        $(".has-error").removeClass("has-error");
        $(".error-message").remove();
        var $this = $(this);
        var $form_target = $this.data("form_target");
        var $target = $this.data("target");
        var $type = $this.data("type");
        var $form_type = $this.data("form_type");
        var $edit_target = $this.data("edit_target");
        var $count = parseInt($this.attr("data-count"));
        var $url = $($form_target).attr("action");
        var $method = $($form_target).attr("method");
        var $modal = $this.data("modal");
        console.log();
        var $formData = new FormData($($form_target)[0]);
        $.ajax({
            url: $url,
            type: $method,
            data: $formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function ($response) {
                if ($response.status == true) {
                    $count + 1;
                    $this.attr("data-count", $count + 1);
                    if ($form_type == "edit") {
                        $($edit_target).remove();
                        console.log($edit_target);
                        $($response.html).hide().appendTo($target).fadeIn(1000);
                    } else {
                        $($response.html).hide().appendTo($target).fadeIn(1000);
                    }
                }
            },
        });
    }
);

$(document).on(
    "click",
    '[data-request="add-another-display-text"]',
    function () {
        $("#popup").show();
        $(".alert").remove();
        $(".has-error").removeClass("has-error");
        $(".error-message").remove();
        var $formData = new FormData();
        var $this = $(this);
        var $target = $this.data("target");
        var $url = $this.data("url");
        var $type = $this.data("types");
        var $count = parseInt($this.attr("data-count"));
        var $simulation_type = $("#simulation_type").val();
        if ($this.data("remove")) var $remove_key = $this.data("remove");
        var $process_simulation = $("#process_simulation").val();
        var $process_simulation = $("#process_simulation").val();
        var $dataset = $("#dataset").val();
        var simulation = [];
        $("input[name^=simulation").each(function (index, value) {
            val = this.value;
            simulation.push(val);
        });
        var process_sim = [];
        $("input[name^=process_sim").each(function (index, value) {
            val = this.value;
            process_sim.push(val);
        });
        var dataset = [];
        $("input[name^=dataset").each(function (index, value) {
            val = this.value;
            dataset.push(val);
        });

        $formData.append("process_sim", process_sim);
        $formData.append("simulation", simulation);
        $formData.append("count", $count);
        $formData.append("type", $type);
        if ($this.data("status")) {
            if ($this.data("remove")) $formData.append("remove", $remove_key);
            else $formData.append("remove", 0);
        }
        $formData.append("process_simulation", $process_simulation);
        $formData.append("simulation_type", $simulation_type);
        $formData.append("dataset", $dataset);
        $.ajax({
            url: $url,
            type: "POST",
            data: $formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function ($response) {
                console.log($response);
                if ($response.status == true) {
                    $("#error").html("");
                    $count + 1;
                    $this.attr("data-count", $count + 1);
                    $("#process-simulation").html($response.html);
                    //$($response.html).hide().appendTo($target).fadeIn(1000);
                } else {
                    $("#error").html($response.msg);
                }
            },
        });
    }
);

////////////////////////AJAX FORM////////////////////
$(document).on("click", '[data-request="ajax-popup"]', function () {
    $("#popup").show();
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $target = $this.data("target");
    var $count = parseInt($this.attr("data-count"));
    var $tab = $this.data("tab");
    var $url = $this.data("url");
    var $type = $this.data("type");
    if ($type == "add-button") {
        $url = $url + "count=" + $count;
        $tab = $tab + $count;
        $new_count = $count - 1;
        $($tab + $new_count).remove();
    }
    var $simulation_input_id = $("#dataset_edit_id").val();
    $formData.append("simulation_input_id", $simulation_input_id);
    $formData.append("type", $type);
    $formData.append("count", $count);
    $.ajax({
        url: $url,
        type: "GET",
        data: $formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
            console.log("ajax-tooltip");
            // $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
            // $("[rel=tooltip]").tooltip();
            //$('[data-toggle="tooltip"]').tooltip();
            $(".tooltip-test").tooltip();

            if ($response.status == true) {
                $count + 1;
                $this.attr("data-count", $count + 1);
                $($target).html($response.html);
                // $($response.html).hide().appendTo($target);
                $($tab).modal("show");
            }
        },
    });
});

$(document).on("change", '[data-request="ajax-append-fields"]', function () {
    $("#popup").show();
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $target = $this.data("target");
    var $parameters = $(this).val();
    var $url = $this.data("url");
    var $type = $this.data("type");
    var $count = $this.data("count");
    var $method = $this.data("method");
    var $process_experiment_id = $this.data("process_experiment_id");
    if ($method == "") {
        $method = "GET";
    }
    if ($count == "") {
        var $newurl = $url + "?parameters=" + $parameters;
    } else {
        var $newurl = $url + "?parameters=" + $parameters + "&count=" + $count;
    }
    if ($this.data("level")) {
        if ($this.data("level") == 1) {
            $($target).attr("data-extra", $parameters);
        }
    }
    if ($this.data("extra")) {
        var $newurl =
            $url +
            "?parameters=" +
            $parameters +
            "&count=" +
            $count +
            "&extra=" +
            $("#process_simulation").val();
    }
    $formData.append("type", $type);
    $formData.append("process_experiment_id", $process_experiment_id);
    $.ajax({
        url: $newurl,
        type: $method,
        data: $formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
            if ($response.status == true) {
                $($target).html($response.html);
            }
        },
    });
});

$(document).on("click", '[data-request="show-details"]', function () {
    $("#popup").show();
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $target = $this.data("target");
    var $url = $this.data("url");
    var $type = $this.data("type");
    var $count = parseInt($this.attr("data-count"));
    var $stoic_coef_reac = $("input[name='stoic_coef_reac[]']")
        .map(function () {
            return $(this).val();
        })
        .get();
    var $chemical = $("select[name='chemical_reac[]']")
        .map(function () {
            return $(this).val();
        })
        .get();
    $formData.append("count", $count);
    $formData.append("type", $type);
    $formData.append("chemical[]", $chemical);
    $formData.append("stoic_coef_reac[]", $stoic_coef_reac);
    $.ajax({
        url: $url,
        type: "POST",
        data: $formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
            if ($response.status == true) {
                $this.attr("data-count", $count + 1);
                $($response.html).hide().appendTo($target).fadeIn(1000);
            }
        },
    });
});

$(document).on(
    "keypress keyup",
    '[data-request="isnumeric"]',
    function (event) {
        if (
            $(this).val().indexOf(".") != -1 &&
            $(this)
                .val()
                .substring(
                    $(this).val().indexOf("."),
                    $(this).val().indexOf(".").length
                ).length > 15
        ) {
            event.preventDefault();
        }
    }
);

$(document).on(
    "keypress keyup",
    '[data-request="isalphanumeric"]',
    function (event) {
        keyCode = event.keyCode;
        //alert(keyCode)
        return (
            (keyCode >= 48 && keyCode <= 57 && isShift == false) ||
            (keyCode >= 65 && keyCode <= 90) ||
            keyCode == 8 ||
            (keyCode >= 97 && keyCode <= 122) ||
            keyCode == 32
        );
    }
);

$(document).on("click", '[data-request="ajax-submit-popup-form"]', function () {
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".help-block").remove();
    var $this = $(this);
    var $target = $this.data("target");
    var $model_id = $this.data("model_id");
    var $ajax_list = $this.data("ajax_list");
    var $url = $($target).attr("action");
    var $method = $($target).attr("method");
    var $modal = $this.data("modal");
    var $data = new FormData($($target)[0]);
    var $simulation_input_id = $("#dataset_edit_id").val();
    var $dataset_form_type = $("#dataset_form_type").val();
    $data.append("simulation_input_id", $simulation_input_id);
    $data.append("dataset_form_type", $dataset_form_type);
    if (!$method) {
        $method = "get";
    }
    $.ajax({
        url: $url,
        data: $data,
        cache: false,
        type: $method,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function ($response) {
            if ($response.status === true) {
                if ($response.redirect) {
                    if ($response.modal) {
                        $($target).trigger("reset");
                        $($modal).attr("data-success", $response.redirect);
                        $($model_id).modal("hide");
                        $($ajax_list).html($response.html);
                        // const Toast = Swal.mixin({
                        //     toast: true,
                        //     position: "top-end",
                        //     showConfirmButton: false,
                        //     timer: 3000,
                        // });
                        // Toast.fire({
                        //     icon: "success",
                        //     title: $response.message,
                        // });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        Toast.fire({
                            icon: "success",
                            title: $response.message,
                        });
                    }
                }
            } else {
                if (
                    $response.message.length > 0 &&
                    $response.message !== "M0000"
                ) {
                    $(".messages").html($response.message);
                }
                if (Object.size($response.data) > 0) {
                    show_validation_error($response.data);
                }
            }
        },
    });
});

$(".sidebar-toggler").click(function () {
    var $method = "GET";
    var $url = window.location.origin + "/set_side_bar_cookie";
    $.ajax({
        url: $url,
        data: {},
        cache: false,
        type: $method,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function ($response) {
            console.log("session set");
        },
    });
});

function show_validation_error(msg) {
    if ($.isPlainObject(msg)) {
        $data = msg;
    } else {
        $data = $.parseJSON(msg);
    }
    $.each($data, function (index, value) {
        var name = index.replace(/\./g, "][");
        if (index.indexOf(".") !== -1) {
            name = name + "]";
            name = name.replace("]", "");
        }
        if (name.indexOf("[]") !== -1) {
            $('form [name="' + name + '"]')
                .last()
                .closest("")
                .addClass("has-error");
            $('form [name="' + name + '"]')
                .last()
                .closest(".form-group")
                .find("")
                .append(
                    '<span class="help-block text-danger">' + value + "</span>"
                );
            // } else if ($('form [name="' + name + '[]"]').length > 0) {
            //     if (value == "The product field is required.") {
            //         $("#product").addClass("has-error");
            //         $("#product-error").after(
            //             '<span class="help-block text-danger">' + value + "</span>"
            //         );
            //     } else if (value == "The main product input field is required.") {
            //         $("#main_product_input").addClass("has-error");
            //         $("#main_product_input-error").after(
            //             '<span class="help-block text-danger">' + value + "</span>"
            //         );
            //     } else if (value == "The main product output field is required.") {
            //         $("#main_product_output").addClass("has-error");
            //         $("#main_product_output-error").after(
            //             '<span class="help-block text-danger">' + value + "</span>"
            //         );
            //     } else {
            //         $('form [name="' + name + '[]"]')
            //             .closest(".form-group")
            //             .addClass("has-error");
            //         $('form [name="' + name + '[]"]')
            //             .parent()
            //             .after(
            //                 '<span class="help-block text-danger">' +
            //                     value +
            //                     "</span>"
            //             );
            //     }
        } else {
            if (
                $('form [name="' + name + '"]').attr("type") == "checkbox" ||
                $('form [name="' + name + '"]').attr("type") == "radio"
            ) {
                if (
                    $('form [name="' + name + '"]').attr("type") == "checkbox"
                ) {
                    $('form [name="' + name + '"]')
                        .closest(".form-group")
                        .addClass("has-error");
                    $('form [name="' + name + '"]')
                        .parent()
                        .after(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                } else {
                    $('form [name="' + name + '"]')
                        .closest(".form-group")
                        .addClass("has-error");
                    $('form [name="' + name + '"]')
                        .parent()
                        .parent()
                        .append(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                }
            } else if ($('form [name="' + name + '"]').get(0)) {
                if (
                    $('form [name="' + name + '"]').get(0).tagName ==
                        "select" ||
                    $('form [name="' + name + '"]').get(0).tagName == "SELECT"
                ) {
                    $('form [name="' + name + '"]')
                        .closest(".form-group")
                        .addClass("has-error");
                    $('form [name="' + name + '"]')
                        .parent()
                        .append(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                } else if (
                    $('form [name="' + name + '"]').attr("type") ==
                        "password" &&
                    $('form [name="' + name + '"]').hasClass(
                        "hideShowPassword-field"
                    )
                ) {
                    $('form [name="' + name + '"]')
                        .closest(".form-group")
                        .addClass("has-error");
                    $('form [name="' + name + '"]')
                        .parent()
                        .after(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                } else {
                    if ($("span").hasClass(name)) {
                        document.getElementById(name).innerHTML =
                            '<span class="help-block text-danger">' +
                            value +
                            "</span>";
                    } else {
                        $('form [name="' + name + '"]')
                            .closest(".form-group")
                            .addClass("has-error");
                        $('form [name="' + name + '"]').after(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                    }
                }
            } else if ($('form [name="' + name + '[]"]').get(0)) {
                if (
                    $('form [name="' + name + '[]"]').get(0).tagName == "SELECT"
                ) {
                    $('form [name="' + name + '[]"]')
                        .closest(".form-group")
                        .addClass("has-error");
                    $('form [name="' + name + '[]"]')
                        .parent()
                        .append(
                            '<span class="help-block text-danger">' +
                                value +
                                "</span>"
                        );
                }
            } else {
                $('form [name="' + name + '"]')
                    .closest(".form-group")
                    .addClass("has-error");
                $('form [name="' + name + '"]').after(
                    '<span class="help-block text-danger">' + value + "</span>"
                );
            }
        }
    });
    scroll();
}

function scroll() {
    if ($(".help-block").not(".modal .help-block").length > 0) {
        $("html, body").animate(
            {
                scrollTop: $(".help-block").offset().top - 100,
            },
            200
        );
    }
}

Object.size = function (obj) {
    var size = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

$(document).on("change", '[data-request="get-value"]', function () {
    var $this = $(this);
    var $target = $this.data("target");
    var $count = $this.data("count");
    var $unit_name = $("#equipment_unit_name").val();
    var $flow_type = $("#stream_flow_type" + $count).val();
    // var $rand_no  =  Math.floor(100000000 + Math.random() * 900000000);
    var $number = $count + 1;
    var $res_unit_name = $unit_name.replace(" ", "_");
    var $stream_name = $res_unit_name + "_" + $flow_type + "_" + $number;
    $($target + $count).val($stream_name);
});

$(document).on("change", '[data-request="alert-popup-reaction"]', function () {
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $this = $(this);
    var $ask = $this.data("ask");
    var $target = $this.data("target");
    var $askImage = $this.data("ask_image");
    if ($this.val() == "true") {
        swal.fire({
            html: $ask,
            showLoaderOnConfirm: true,
            showCancelButton: true,
            showCloseButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            icon: $askImage,
            imageClass: "ask-image-popup",
            confirmButtonText: "YES, SURE",
            cancelButtonText: "NOT NOW",
            confirmButtonColor: "#0FA1A8",
            cancelButtonColor: "#CFCFCF",
        })
            .then(
                function (isConfirm) {
                    if (isConfirm) {
                        $($target).val("false");
                        $this.val("true");
                    }
                },
                function (dismiss) {}
            )
            .catch(swal.noop);
    }
});

$(document).on("click", '[data-request="ajax-permission-denied"]', function () {
    var $this = $(this);
    // var $ask = $this.data("ask");
    var $ask = "you dont have access permission.Please contact with admin.";
    var $askImage = $this.data("ask_image");
    swal.fire({
        text: $ask,
        confirmButtonText: "Close",
        confirmButtonClass: "btn btn-danger",
        width: "350px",
        height: "10px",
        icon: "warning",
    });
});
$(document).on("click", '[data-request="ajax-append-list"]', function () {
    $("#loading_no_spin").hide();
    $("#loading_spin").show();
    var $this = $(this);
    var $target = $this.data("target");
    var $url = $this.data("url");
    var $method = "GET";
    $.ajax({
        url: $url,
        type: $method,
        data: {},
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
            if ($response.status == true) {
                setTimeout(function () {
                    $(".deletebulk").hide();
                    $("#loading_no_spin").show();
                    $("#loading_spin").hide();
                }, 1000);

                $($target).html($response.html);
                //$($response.html).append($target).fadeIn(1000);
            }
        },
    });
});

$(document).on("change", '[data-request="ajax-confirm-onchange"]', function () {
    $(".alert").remove();
    $(".has-error").removeClass("has-error");
    $(".error-message").remove();
    var $formData = new FormData();
    var $this = $(this);
    var $url = $this.data("url");
    var $ask = $this.data("ask");
    var $askImage = $this.data("ask_image");
    var $method = $this.data("method");
    var $target = $this.data("target");
    // console.log($this.val());
    $new_url = $url + "?status=" + $this.val();
    //$formData.append("new_status", $this.val());
    swal.fire({
        html: $ask,
        showLoaderOnConfirm: true,
        showCancelButton: true,
        showCloseButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        // imageUrl :  $askImage,
        icon: $askImage,
        imageClass: "ask-image-popup",
        confirmButtonText: "YES, SURE",
        cancelButtonText: "NOT NOW",
        confirmButtonColor: "#0FA1A8",
        cancelButtonColor: "#CFCFCF",
        preConfirm: function (res) {
            return new Promise(function (resolve, reject) {
                if (res === true) {
                    $.ajax({
                        method: $method,
                        url: $new_url,
                        data: $formData,
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                    }).done(function ($response) {
                        if ($response.status == true) {
                            if (typeof LaravelDataTables !== "undefined") {
                                LaravelDataTables["dataTableBuilder"].draw();
                            }
                            if ($response.message) {
                                if ($(".alert").length > 0) {
                                    $("html, body").animate(
                                        {
                                            scrollTop:
                                                $(".alert").offset().top - 100,
                                        },
                                        200
                                    );
                                }
                            }
                            if ($response.redirect == "reload_fail") {
                                $($target).hide("slow", function () {
                                    $($target).remove();
                                });
                            } else {
                                if ($response.redirect != true) {
                                    window.location.href = $response.redirect;
                                } else if ($response.redirect === true) {
                                    if ($response.message) {
                                        swal.fire({
                                            text: $response.message,
                                            confirmButtonText: "Close",
                                            confirmButtonClass:
                                                "btn btn-danger",
                                            width: "350px",
                                            height: "10px",
                                            icon: "warning",
                                        });
                                        window.location.reload();
                                        //return false
                                    } else {
                                        window.location.reload();
                                    }
                                } else if ($($response.redirect).length > 0) {
                                    $($response.redirect).remove();
                                }
                            }
                            resolve();
                        }
                    });
                }
            });
        },
    })
        .then(
            function (isConfirm) {
                window.location.reload();
            },
            function (dismiss) {}
        )
        .catch(swal.noop);
});
function isNumber(evt) {
    evt = evt ? evt : window.event;
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function alertconfirmation(msg, icon, url) {
    swal.fire({
        html: msg,
        showLoaderOnConfirm: true,
        showCancelButton: true,
        showCloseButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        // imageUrl :  $askImage,
        icon: icon,
        imageClass: "ask-image-popup",
        confirmButtonText: "YES, SURE",
        cancelButtonText: "NOT NOW",
        confirmButtonColor: "#0FA1A8",
        cancelButtonColor: "#CFCFCF",
        preConfirm: function (res) {
            return new Promise(function (resolve, reject) {
                if (res === true) {
                    window.location.href = window.location.origin + url;
                }
            });
        },
    })
        .then(
            function (isConfirm) {
                window.location.reload();
            },
            function (dismiss) {}
        )
        .catch(swal.noop);
}
$("select.form-control").addClass("js-example-basic-single");
