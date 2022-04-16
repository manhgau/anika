<script>
  const ITEM_STATUS = <?= json_encode($this->feedback_model->feedbackStatus) ?>;
  const TYPE_NAME = <?= json_encode($this->feedback_model->typeName) ?>;
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="/admin/assets/js/app/feedback/index-datatable.js?v=1.07" defer></script>