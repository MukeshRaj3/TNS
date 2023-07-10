$(document).ready(function () {
    if ($.fn.DataTable.isDataTable('#datatable-users')) {
        $('#datatable-users').DataTable().destroy();
    }
    // datatables
    tableaaa = $('#datatable-users').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        responsive: true,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url+"admin/users/ajax_list",
            "type": "POST",
            "data": function (data) {
                data.Name = $('#Name').val();
                data.Email = $('#Email').val();
                data.Phone = $('#Phone').val();
                data.LastLogin = $('#LastLogin').val();
                data.CreatedOn = $('#CreatedOn').val();
            }
        },
        //Set column definition initialisation properties.
        "aaSorting": [],
        "columnDefs": [
            {"width": "2%", "targets": 0},
            {"targets": [3,4], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2]).every(function () {
                var column = this;
                var inputTitle = '';
                var placeholder = 'Search...';
                inputTitle = $('#datatable-users thead th').eq(column.index()).text();
                $('<input type="text" style="width: 150px;" class="form-control" id="' + inputTitle.replace(/\s+/g, '') + '" placeholder="' + placeholder + '" />')
                .appendTo($(column.footer()).empty())
                .on('keyup change', function () {
                    if (column.search() !== this.value) {
                        column
                                .search(this.value)
                                .draw();
                    }
                });
            });
        }
    });
});