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
    $('input[name="missing_date_filter"]').daterangepicker({
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
      var dataTable =  $("#my_missing_person_list_table").DataTable({
        processing: true,
        serverSide: true,
        type: "get",
        ajax: {url:"mymissing_person_list",'data': function(data){  
            
            data.enable_missed_data = $('#missdate_validity_chkbx').val();
            data.missed_date = $('#missing_date_filter').val();
            data.name = $('#missing_name').val();
            data.gender = $('#gender_select').val();
            data.age = $('#missing_age').val();
            data.country_id = $('#country_select').val();
            data.state_id = $('#state_select').val();
            data.city_id = $('#city_select').val();
         }},
        order: [
            [0, "asc"] // asc OR desc
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
                width: "15%",
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
                orderable: false,
                searchable: false
            },
            {
                data: "location",
                name: "location",
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
                data: "missing_status",
                name: "missing_status",
                title: "Missing Status",
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
                    columns: [0, 2, 3, 4, 5, 6]
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
                    columns: [0, 2, 3, 4, 5, 6]
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
                    columns: [0, 1, 2, 3, 4, 5, 6]
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
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: "copyHtml5",
                className: "btn btn-default",
                text: '<i class="fa fa-copy"></i>',
                titleAttr: "Copy",
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6]
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
            }
        ]
    });
    // Datatables Operation Ends

    // Radio button Gender Starts
    $(document).on("change", "input:radio[name=gender]", function() {
        $("input:radio[name=gender]").removeAttr("checked");
        $(this).prop("checked", true);
        $(this).attr("checked", "checked");
    });
    // Radio button Gender Ends

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
                        $("#select_state_hidden").val().length != 0
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
    /* Dynamic Country Wise State , City Ends */

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
        $("#country_select").trigger("change");
    }

    $(document).on("click", ".btn_view", function() {
        var view_id = $(this).attr("view_id");
        if (view_id) {
            $.ajax({
                type: "GET", // Default GET
                url: APPURL + "/customer/get_missing_person/" + view_id,
                dataType: "json", // text , XML, HTML
                beforeSend: function() {},
                success: function(data_resp, textStatus, jqXHR) {
                    if (data_resp.status) {
                        // Missing Person Information
                        $("#missing_person_view").attr(
                            "src",
                            data_resp.data.missing_person_img
                        );
                        $(".person_name").text(
                            data_resp.data.missing_full_name
                        );
                        $(".person_country").text(data_resp.data.country_name);
                        $(".person_gender").text(data_resp.data.missing_gender);
                        $(".person_birthdate").text(data_resp.data.birth_date);
                        $(".person_age").text(data_resp.data.missing_age);
                        $(".person_height").text(data_resp.data.missing_height);
                        $(".person_weight").text(data_resp.data.missing_weight);
                        $(".person_address").text(
                            data_resp.data.missing_address
                        );
                        $(".person_pincode").text(data_resp.data.pincode);
                        $(".person_country").text(data_resp.data.country_name);
                        $(".person_state").text(data_resp.data.state_name);
                        $(".person_city").text(data_resp.data.city_name);
                        $("#missing_person_face_view").attr(
                            "src",
                            data_resp.data.jaw_img
                        );
                        $("#missing_person_skin_view").attr(
                            "src",
                            data_resp.data.skin_img
                        );
                        $("#missing_person_hair_view").attr(
                            "src",
                            data_resp.data.hair_img
                        );
                        $("#missing_person_nose_view").attr(
                            "src",
                            data_resp.data.nose_img
                        );
                        $("#missing_person_eyebrow_view").attr(
                            "src",
                            data_resp.data.eye_brow_img
                        );
                        $("#missing_person_eye_view").attr(
                            "src",
                            data_resp.data.eye_img
                        );
                        $("#missing_person_ear_view").attr(
                            "src",
                            data_resp.data.ear_img
                        );
                        $("#missing_person_lip_view").attr(
                            "src",
                            data_resp.data.lip_img
                        );
                        $(".cloths_description").text(
                            data_resp.data.cloth_description
                        );
                        $(".remarks_description").text(data_resp.data.remark);

                        // Parents Information
                        $(".parent_name").text(data_resp.data.parent_full_name);
                        $(".parent_address").text(
                            data_resp.data.parent_address
                        );
                        $(".parent_email").text(data_resp.data.parent_email);
                        $(".parent_mobile").text(data_resp.data.parent_mobile);
                        var symbol = data_resp.data.symbol;
                        if (symbol === undefined || symbol === null) {
                            $(".parent_rewards").text(data_resp.data.amount);
                        } else {
                            $(".parent_rewards").text(
                                data_resp.data.amount +
                                    " " +
                                    data_resp.data.symbol
                            );
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {},
                complete: function() {}
            });
        }
    });

    $(document).on("click", ".btn_response", function() {
        $("#find_id_hidden").val($(this).attr("find_id"));
        $("#missing_id_hidden").val($(this).attr("response_id"));
        // parents calls based child attr find        
        var img_src = $(this).closest("tr").find("[src]").attr('src');
        if(img_src !== null || img_src !== ""){
            $("#response_form").find("[src]").first().attr("src",img_src.replace('thumbnail/thumb_',''));
        }             
        $("#response_form").find("[src]").last().attr("src",window.location.origin+"/uploads/users/"+$(this).attr('response_user_img'));
        var pathname = window.location.pathname; // Returns path only (/path/example.html)
        var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
        var origin   = window.location.origin;   // Returns base URL (https://example.com)
    });

    /* Bootstrap Modal file File upload */
    $("#response_form").on("submit", function(e) {
        e.preventDefault();

        // Ajax CSRF Token Setup
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var formData = new FormData(this);
        $.ajax({
            type: "POST", // Default GET
            url: APPURL + "/customer/response_person",
            data: formData,
            dataType: "json", // text , XML, HTML
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".btn_request_submit").attr("disabled", "disabled");
                $(".btn_close").removeAttr("disabled", "disabled");
                $(".modal-body").css("opacity", ".5");
            },
            success: function(data_resp, textStatus, jqXHR) {
                if (data_resp.status) {
                    $("#find_person_img").val("");
                    $("#message").val("");
                    $(".statusMsg").html(
                        '<span style="color:green;"> Thanks for contacting us, we\'ll get back to you soon.</p>'
                    );
                } else {
                    $(".statusMsg").html(
                        '<span style="color:red;"> Some problem occurred, please try again.</span>'
                    );
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".statusMsg").html(
                    '<span style="color:red;"> Some problem occurred, please try again.</span>'
                );
            },
            complete: function() {
                $(".btn_request_submit").removeAttr("disabled", "disabled");
                $(".btn_close").removeAttr("disabled", "disabled");
                $(".modal-body").css("opacity", "");
            }
        });
    });
});
