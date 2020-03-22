// A $( document ).ready() block.
$(document).ready(function() {

    $('#role_list_table').DataTable({
        "processing": true,
        "serverSide": true,
        "type": 'get',
        "ajax": "role_list",
        "columns": [
            { data: 'role_name', name: 'role_name' },
            { data: 'role_alias', name: 'role_alias' },
            { data: 'role_description', name: 'role_description' },
            { data: 'status', name: 'status' }
        ]
    });
});