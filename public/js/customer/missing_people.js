$(document).ready(function() {
    // Date Range
    $('input[name="missing_date"]').daterangepicker({
        singleDatePicker: true,
        maxDate: new Date(),
        locale: {
            format: "DD/MM/YYYY"
        }
    });

    // Date Range
    $('input[name="birth_date"]').daterangepicker({
        singleDatePicker: true,
        maxDate: new Date(),
        locale: {
            format: "DD/MM/YYYY"
        }
    });

    /* File Upload Starts  */
    $("#missing_person_img").on("change", function() {
        // Add the following code if you want the name of the file appear on select
        var fileName = $(this)
            .val()
            .split("\\")
            .pop();
        $(this)
            .siblings(".custom-file-label")
            .addClass("selected")
            .html(fileName);
        // File Reader Convert into Base64 and Preview file
        if (this.files && this.files[0]) {
            var FR = new FileReader();
            FR.addEventListener("load", function(e) {
                document.getElementById("img_view").src = e.target.result;
                // document.getElementById("b64").innerHTML = e.target.result;
            });
            FR.readAsDataURL(this.files[0]);
            $(".file_preview").removeClass("d-none");
        }
    });

    // Remove file from upload text
    $(".close").on("click", function() {
        $(".custom-file-label").html("Upload Missing Person Image");
        document.getElementById("img_view").src = "#";
        $(".file_preview").addClass("d-none");
    });
    /* File Upload Ends  */

    // Datatables Operation Starts
    $("#missing_person_list_table").DataTable({
        processing: true,
        serverSide: true,
        type: "get",
        ajax: "missing_person_list",
        order: [
            [1, "asc"] // asc OR desc
        ],
        aLengthMenu: [
            // Sort Numbers of Rows
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 10, // Default Display Numbers of Rows
        autoWidth: true,
        columns: [
            {
                // First Column As a Checkbox
                targets: 0,
                searchable: false,
                orderable: false,
                className: "dt-body-center",
                render: function(data, type, full, meta, row) {
                    // function to modify dynamic data
                    return (
                        '<input type="checkbox" class="child_chkbox" name="child_chkbox[]" value="' +
                        $("<div/>")
                            .text(full.missing_id)
                            .html() +
                        '">'
                    );
                }
            },
            {
                width: "10%",
                visible: true, // Hide Which Column Do not need to show in Datatable list
                data: "missing_full_name",
                name: "missing_full_name",
                title: "Name",
                orderable: true,
                searchable: true
            },
            {
                data: "missing_person_img",
                name: "missing_person_img",
                title: "Image",
                orderable: true,
                searchable: true
            },
            {
                data: "country_name",
                name: "country_name",
                title: "Location",
                orderable: true,
                searchable: true
            },
            {
                data: "age",
                name: "age",
                title: "Age",
                orderable: true,
                searchable: true
            },
            {
                data: "missing_date",
                name: "missing_date",
                title: "Missing Date",
                orderable: true,
                searchable: true
            },
            {
                data: "parent_mobile",
                name: "parent_mobile",
                title: "Emergency Contact",
                orderable: true,
                searchable: true
            },
            {
                width: "15%",
                data: "action",
                name: "action",
                title: "Action",
                orderable: false,
                searchable: false
            }
        ],
        dom:
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center mb-2'B><'col-sm-12 col-md-3'f>>" + // Top Header
            "<'row'<'col-sm-12'tr>>" + // Table Body
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Bottom Footer
        buttons: [
            {
                extend: "excelHtml5",
                className: "btn btn-default",
                text: '<i class="fa fa-file-excel"></i>',
                titleAttr: "Excel",
                filename: "ExcelReport",
                sheetName: "Sheet1",
                autoFilter: false,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: "csvHtml5",
                className: "btn btn-default",
                text: '<i class="fa fa-file-csv"></i>',
                titleAttr: "CSV",
                width: "auto",
                filename: "CSVReport",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: "print",
                className: "btn btn-default",
                text: '<i class="fa fa-print"></i>',
                titleAttr: "Print",
                filename: "PrintReport",
                autoPrint: true,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: "pdfHtml5",
                className: "btn btn-default",
                text: '<i class="fa fa-file-pdf"></i>',
                titleAttr: "PDF",
                filename: "PDFReport",
                title: "PDF Title", // Heading Title
                orientation: "portrait", // portrait OR landscape
                pageSize: "LEGAL", // LETTER OR TABLOID OR A3 OR A4 OR A5 OR
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: "copyHtml5",
                className: "btn btn-default",
                text: '<i class="fa fa-copy"></i>',
                titleAttr: "Copy",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: "pdfHtml5",
                className: "btn btn-default",
                text: '<i class="fas fa-sync-alt"></i>',
                titleAttr: "Reload",
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                }
            },
            {
                // Delete All Custom Button
                className: "btn btn-default",
                text: '<i class="fa fa-trash"></i>',
                titleAttr: "Delete Selected",
                action: function(e, dt, node, config) {
                    var select_all_chkbx = $(".select_all_chkbox").val();
                    var child_chkbx = [];
                    $("input:checkbox[name='child_chkbox[]']:checked")
                        .map(function(_, el) {
                            child_chkbx.push($(el).val());
                        })
                        .get();

                    if (select_all_chkbx == 1 || child_chkbx.length !== 0) {
                        // Checkbox Selected for Delete
                        if (confirm("Are you sure you want to Delete?")) {
                            // Ajax CSRF Token Setup
                            $.ajaxSetup({
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content")
                                }
                            });
                            ajaxDelete(child_chkbx);
                        }
                        return false;
                    } else {
                        // Delete Operation Error Select Alteast 1 Checkbox
                        var warning_head = "";
                        var warning_body = "";
                        warning_head +=
                            '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                        warning_body +=
                            "Before Delete, Please select alteast ONE CheckBox..!";
                        $(".modal-header h4").html(warning_head);
                        $(".modal-body p").html(warning_body);
                        $(".error_modal").trigger("click");
                        setTimeout(function() {
                            $(".close").trigger("click");
                        }, 2000);
                    }
                }
            }
        ]
    });
    // Datatables Operation Ends

    /* Bulk Delete ajax Starts */
    function ajaxDelete(ids = []) {
        $.ajax({
            url: APPURL + "/admin/delete_discounts",
            type: "POST",
            data: { ids: ids },
            dataType: "JSON",
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += "Discounts are Deleted successfully.";
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body +=
                        "Discounts are not deleted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }
    /* Bulk Delete ajax Ends */

    // Handle click on "Select all" control Starts
    $(document).on("click", "#select_all_chkbox", function() {
        var attr = $(this).attr("checked");
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).prop("checked", false);
            $(this).removeAttr("checked");
            $(this).val(0);
            // Datatables Child Checkbox
            $(".child_chkbox").removeAttr("checked");
            $(".child_chkbox").prop("checked", false);
            $(".child_chkbox")
                .closest("tr")
                .removeClass("bg-secondary text-white");
        } else {
            $(this).prop("checked", true);
            $(this).attr("checked", "checked");
            $(this).val(1);
            // Datatables Child Checkbox
            $(".child_chkbox").prop("checked", true);
            $(".child_chkbox").attr("checked", "checked");
            $(".child_chkbox")
                .closest("tr")
                .addClass("bg-secondary text-white");
        }
    });
    // Handle click on "Select all" control Ends

    // Checkbox checked popup Starts
    $(document).on("click", ".child_chkbox", function() {
        var attr = $(this).attr("checked");
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).prop("checked", false);
            $(this).removeAttr("checked");
            // $(this).val(0);
            $(this)
                .closest("tr")
                .removeClass("bg-secondary text-white");
        } else {
            $(this).prop("checked", true);
            $(this).attr("checked", "checked");
            // $(this).val(1);

            $(this)
                .closest("tr")
                .addClass("bg-secondary text-white");
        }
    });
    // Checkbox checked popup Ends

    // Action Delete Specific Starts
    $(document).on("click", ".btn_delete", function() {
        if (confirm("Are you sure you want to Delete?")) {
            // Ajax CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            ajaxDeleteSpecific($(this).attr("delete_id"));
        } else {
            return false;
        }
    });
    // Action Delete Specific Ends

    /* Bulk Delete ajax Starts */
    function ajaxDeleteSpecific(ids) {
        $.ajax({
            url: APPURL + "/admin/discount_delete/" + ids,
            type: "get",
            dataType: "JSON",
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += "Discount is Deleted successfully.";
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body +=
                        "Discount is not deleted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }
    /* Bulk Delete ajax Ends */

    // Status Change Dynamically Starts
    $(document).on("click", ".btn_status", function() {
        // Ajax CSRF Token Setup
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            url: APPURL + "/admin/discount_status",
            type: "POST",
            data: {
                id: $(this).attr("discount_id"),
                status: $(this).attr("status")
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += data.message;
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body +=
                        "Discount is In Activated... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    });
    // Status Change Dynamically Ends

    //Select Option Change Selected Status
    $(document).on("change", "#plan_id_select", function() {
        $("#plan_id_select").removeAttr("selected", "selected");
        $("option:selected", this).attr("selected", "selected");
    });

    // Checkbox checked popup Starts
    $(document).on("click", ".discount_validity_chkbx", function() {
        var attr = $(this).attr("checked");
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).prop("checked", false);
            $(this).removeAttr("checked");
            $(this).val(0);
            $("#discount_validity").attr("disabled", "disabled");
        } else {
            $(this).prop("checked", true);
            $(this).attr("checked", "checked");
            $(this).val(1);
            $("#discount_validity").removeAttr("disabled");
        }
    });
    // Checkbox checked popup Ends

    // Checkbox checked popup Starts
    $(document).on("change", "#discount_type_select", function() {
        var get_selected_val = $(this)
            .find(":selected")
            .val();
        if (
            $(this)
                .find(":selected")
                .val() !== "none"
        ) {
            $("#discount_amount").removeAttr("disabled");
        } else {
            $("#discount_amount").attr("disabled", "disabled");
        }
    });
    // Checkbox checked popup Ends

    /* Dynamic Country Wise State , City Starts */

    $(document).on("change", "#country_select", function() {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/customer/getstate/" + country_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {},
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#state_select").empty();
                        $("#city_select").empty();
                        $("#city_select").append(
                            "<option>Select City</option>"
                        );
                        $("#state_select").append(
                            "<option>Select State</option>"
                        );
                        $.each(data_resp.data, function(key, value) {
                            var selected = "";
                            if (
                                $("#select_state_hidden").val() != "" &&
                                $("#select_state_hidden").val() ==
                                    value.state_id
                            ) {
                                selected = "selected";
                            }
                            $("#state_select").append(
                                '<option value="' +
                                    value.state_id +
                                    '" ' +
                                    selected +
                                    ">" +
                                    value.name +
                                    "</option>"
                            );
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {
                    // Dynamic Dependent Validation Selected
                    if (
                        $("#select_state_hidden").val() != "" ||
                        $('#select_state_hidden').val().length != 0
                    ) {
                        $("#state_select").trigger("change");
                    }
                }
            });
        }
    });

    $(document).on("change", "#state_select", function() {
        var state_id = $(this).val();
        if (state_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/customer/getcity/" + state_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {},
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#city_select").empty();
                        $("#city_select").append(
                            "<option>Select City</option>"
                        );

                        $.each(data_resp.data, function(key, value) {
                            var selected = "";
                            if (
                                $("#select_city_hidden").val() != "" &&
                                $("#select_city_hidden").val() == value.city_id
                            ) {
                                selected = "selected";
                            }

                            $("#city_select").append(
                                '<option value="' +
                                    value.city_id +
                                    '" ' +
                                    selected +
                                    " >" +
                                    value.name +
                                    "</option>"
                            );
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#hair_select", function() {
        var hair_id = $(this).val();
        if (hair_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/gethair/" + hair_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#hair_img_view").hide();
                    $("#hair_img_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#hair_img_view").show();
                        $("#hair_img_view").attr(
                            "src",
                            data_resp.data[0].hair_img
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#eye_select", function() {
        var eye_id = $(this).val();
        if (eye_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/geteye/" + eye_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#eye_img_view").hide();
                    $("#eye_img_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#eye_img_view").show();
                        $("#eye_img_view").attr(
                            "src",
                            data_resp.data[0].eye_img
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#eyebrow_select", function() {
        var eyebrow_id = $(this).val();
        if (eyebrow_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/geteyebrow/" + eyebrow_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#eye_brow_view").hide();
                    $("#eye_brow_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#eye_brow_view").show();
                        $("#eye_brow_view").attr(
                            "src",
                            data_resp.data[0].eye_brow_img
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#face_jaw_select", function() {
        var jaw_id = $(this).val();
        if (jaw_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/getjaw/" + jaw_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#jaw_view").hide();
                    $("#jaw_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#jaw_view").show();
                        $("#jaw_view").attr("src", data_resp.data[0].jaw_img);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#lip_select", function() {
        var lip_id = $(this).val();
        if (lip_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/getlip/" + lip_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#lip_view").hide();
                    $("#lip_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#lip_view").show();
                        $("#lip_view").attr("src", data_resp.data[0].lip_img);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#skin_select", function() {
        var skin_id = $(this).val();
        if (skin_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/getskin/" + skin_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#skin_view").hide();
                    $("#skin_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#skin_view").show();
                        $("#skin_view").attr("src", data_resp.data[0].skin_img);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#ear_select", function() {
        var ear_id = $(this).val();
        if (ear_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/getear/" + ear_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#ear_view").hide();
                    $("#ear_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#ear_view").show();
                        $("#ear_view").attr("src", data_resp.data[0].ear_img);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("change", "#nose_select", function() {
        var nose_id = $(this).val();
        if (nose_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/admin/getnose/" + nose_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {
                    $("#nose_view").hide();
                    $("#nose_view").attr("src", "");
                },
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        $("#nose_view").show();
                        $("#nose_view").attr("src", data_resp.data[0].nose_img);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    // Dynamic Dependent Select Box While Validation Fails Selected    
    if ($("#select_country_hidden").val()) {
       $("#country_select").trigger('change');
    }
    
});
