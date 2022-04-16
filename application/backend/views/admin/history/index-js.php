<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#datatable').DataTable({
            dom: "Bfrtip",
            pageLength: 100,
            "oLanguage": {
                "sSearch": "Tìm kiếm:&nbsp;"
            },
            columnDefs : [
                {
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                }
            ],
            lengthMenu: [ 10, 25, 50, 75, 100 ],
            order: [[0, 'desc']],
        });
    });
</script>
