// A $( document ).ready() block.
$(document).ready(function() {

    $('#role_list_table').DataTable({
        "processing": true,
        "serverSide": true,
        "type": 'get',
        "ajax": "role_list",
        "order": [
            [0, "asc"] // asc OR desc
        ],
        aLengthMenu: [ // Sort Numbers of Rows
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 10, // Default Display Numbers of Rows
        "autoWidth": true,
        "columns": [{
                data: 'role_name',
                name: 'role_name',
                title: "Name",
                orderable: true,
                searchable: true
            },
            {
                data: 'role_alias',
                name: 'role_alias',
                title: "Alias",
                orderable: true,
                searchable: true
            },
            {
                data: 'role_description',
                name: 'role_description',
                title: "Description",
                orderable: true,
                searchable: true
            },
            {
                data: 'status',
                name: 'status',
                title: "Status",
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                title: "Action",
                orderable: false,
                searchable: false
            },
        ],
        dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center mb-2'B><'col-sm-12 col-md-3'f>>" + // Top Header
            "<'row'<'col-sm-12'tr>>" + // Table Body
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Bottom Footer
        buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                filename: 'ExcelReport',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // [0, 1, 2, 3]
                }
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV',
                width: 'auto',
                filename: 'CSVReport',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
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
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-file-pdf-o"></i>',
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
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-default',
                text: '<i class="fa fa-refresh"></i>',
                titleAttr: 'Reload',
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                }
            }
        ]
    });
});