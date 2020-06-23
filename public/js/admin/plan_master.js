$(document).ready(function() {

    // Datatables Operation Starts
    $('#plan_list_table').DataTable({
        processing: true,
        serverSide: true,
        type: 'get',
        ajax: "plan_list",
        order: [
            [1, "asc"] // asc OR desc
        ],
        aLengthMenu: [ // Sort Numbers of Rows
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 10, // Default Display Numbers of Rows
        autoWidth: true,
        columns: [{ // First Column As a Checkbox
            targets: 0,
            searchable: false,
            orderable: false,
            className: "dt-body-center",
            render: function(data, type, full, meta, row) { // function to modify dynamic data
                return '<input type="checkbox" class="child_chkbox" name="child_chkbox[]" value="' + $('<div/>').text(full.plan_id).html() + '">';
            }
        }, {
            width: "10%",
            visible: true, // Hide Which Column Do not need to show in Datatable list
            data: 'plan_name',
            name: 'plan_name',
            title: "Name",
            orderable: true,
            searchable: true
        }, {
            data: 'plan_alias',
            name: 'plan_alias',
            title: "Alias",
            orderable: true,
            searchable: true
        }, {
            data: 'plan_description',
            name: 'plan_description',
            title: "Description",
            orderable: true,
            searchable: true
        }, {
            width: "11%",
            data: 'status',
            name: 'status',
            title: "Status",
            orderable: true,
            searchable: true
        }, {
            width: "15%",
            data: 'action',
            name: 'action',
            title: "Action",
            orderable: false,
            searchable: false
        }, ],
        dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center mb-2'B><'col-sm-12 col-md-3'f>>" + // Top Header
            "<'row'<'col-sm-12'tr>>" + // Table Body
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Bottom Footer
        buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-excel"></i>',
                titleAttr: 'Excel',
                filename: 'ExcelReport',
                sheetName: "Sheet1",
                autoFilter: false,
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-csv"></i>',
                titleAttr: 'CSV',
                width: 'auto',
                filename: 'CSVReport',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                className: 'btn btn-default',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Print',
                filename: 'PrintReport',
                autoPrint: true,
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-pdf"></i>',
                titleAttr: 'PDF',
                filename: 'PDFReport',
                title: 'PDF Title', // Heading Title
                orientation: 'portrait', // portrait OR landscape
                pageSize: 'LEGAL', // LETTER OR TABLOID OR A3 OR A4 OR A5 OR 
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'copyHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-copy"></i>',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-default',
                text: '<i class="fas fa-sync-alt"></i>',
                titleAttr: 'Reload',
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                }
            },
            { // Delete All Custom Button
                className: 'btn btn-default',
                text: '<i class="fa fa-trash"></i>',
                titleAttr: 'Delete Selected',
                action: function(e, dt, node, config) {
                    var select_all_chkbx = $(".select_all_chkbox").val();
                    var child_chkbx = [];
                    $("input:checkbox[name='child_chkbox[]']:checked").map(function(_, el) {
                        child_chkbx.push($(el).val());
                    }).get();

                    if (select_all_chkbx == 1 || child_chkbx.length !== 0) { // Checkbox Selected for Delete
                        if (confirm("Are you sure you want to Delete?")) {
                            // Ajax CSRF Token Setup
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            ajaxDelete(child_chkbx)
                        }
                        return false;
                    } else { // Delete Operation Error Select Alteast 1 Checkbox
                        var warning_head = "";
                        var warning_body = "";
                        warning_head += '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                        warning_body += 'Before Delete, Please select alteast ONE CheckBox..!';
                        $(".modal-header h4").html(warning_head);
                        $(".modal-body p").html(warning_body);
                        $('.error_modal').trigger('click');
                        setTimeout(function() { $('.close').trigger('click'); }, 2000);
                    }
                }
            }
        ]
    });
    // Datatables Operation Ends

    /* Bulk Delete ajax Starts */
    function ajaxDelete(ids = []) {
        $.ajax({
            url: APPURL + "/admin/delete_plans",
            type: "POST",
            data: { 'ids': ids },
            dataType: 'JSON',
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head += '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += 'Plans are Deleted successfully.';
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head += '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body += 'Plans are not deleted... Please try after sometime. ';
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }
    /* Bulk Delete ajax Ends */

    // Handle click on "Select all" control Starts
    $(document).on('click', '#select_all_chkbox', function() {
        var attr = $(this).attr('checked');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).prop("checked", false);
            $(this).removeAttr("checked");
            $(this).val(0);
            // Datatables Child Checkbox
            $('.child_chkbox').removeAttr("checked");
            $('.child_chkbox').prop("checked", false);
            $('.child_chkbox').closest("tr").removeClass("bg-secondary text-white");
        } else {
            $(this).prop("checked", true);
            $(this).attr("checked", 'checked');
            $(this).val(1);
            // Datatables Child Checkbox
            $('.child_chkbox').prop("checked", true);
            $('.child_chkbox').attr("checked", 'checked');
            $('.child_chkbox').closest("tr").addClass("bg-secondary text-white");
        }
    });
    // Handle click on "Select all" control Ends

    // Checkbox checked popup Starts
    $(document).on('click', '.child_chkbox', function() {
        var attr = $(this).attr('checked');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).prop("checked", false);
            $(this).removeAttr("checked");
            // $(this).val(0);
            $(this).closest("tr").removeClass("bg-secondary text-white");
        } else {
            $(this).prop("checked", true);
            $(this).attr("checked", 'checked');
            // $(this).val(1);

            $(this).closest("tr").addClass("bg-secondary text-white");
        }
    });
    // Checkbox checked popup Ends


    // Action Delete Specific Starts
    $(document).on('click', '.btn_delete', function() {
        if (confirm("Are you sure you want to Delete?")) {
            // Ajax CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            ajaxDeleteSpecific($(this).attr('delete_id'));
        } else {
            return false;
        }
    });
    // Action Delete Specific Ends

    /* Bulk Delete ajax Starts */
    function ajaxDeleteSpecific(ids) {
        $.ajax({
            url: APPURL + "/admin/plan_delete/" + ids,
            type: "get",
            dataType: 'JSON',
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head += '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += 'Plan is Deleted successfully.';
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head += '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body += 'Plan is not deleted... Please try after sometime. ';
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }
    /* Bulk Delete ajax Ends */

    // Status Change Dynamically Starts
    $(document).on('click', '.btn_status', function() {
        // Ajax CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: APPURL + "/admin/plan_status",
            type: "POST",
            data: { 'id': $(this).attr('plan_id'), 'status': $(this).attr('status') },
            dataType: 'JSON',
            beforeSend: function() {
                $(".modal-header h4").html("");
                $(".modal-body p").html("");
            },
            success: function(data, textStatus, jqXHR) {
                if (data.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head += '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += data.message;
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(success_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head += '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Operation Fails...!';
                    warning_body += 'Plan is In Activated... Please try after sometime. ';
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(warning_body);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    });
    // Status Change Dynamically Ends
});
