<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>

<script type="text/javascript">
    var filterForm = $('#filter-form');
    
    filterForm.on('submit', (event) => {
        event.preventDefault();
        loadFeedback();
    })
    
    filterForm.on('change', 'input, select', (event) => {
        event.preventDefault();
        loadFeedback();
    })

    const loadFeedback = ()=> {
        $.get('/memtor/feedbackList', filterForm.serializeArray(), (response) => {
            $('#list-data').html(response);
        })
    }

    $(document).on('click', '.delete-btns', (event) => {
        event.preventDefault();
        let btn = $(event.target);
        if (confirm('xóa nội dung này?')==true) {
            $.get(btn.attr('data-href'), (response) => {
                loadFeedback()
            })
        };
    })

    $(document).on('ready', function(){
        console.log('ready');
        loadFeedback()
    })
</script>