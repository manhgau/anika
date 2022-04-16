<table id="datatable" class="table table-bordered" data-controller="memtor/feedback">
    <thead>
        <tr>
            <th>STT</th>
            <th>Portfolio</th>
            <th>Mentor</th>
            <th>Title</th>
            <th>Feedback</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($feedbacks)) : foreach($feedbacks as $key => $value) : ?>
            <tr>
                <td><?= $value->order; ?></td>
                <td><?php echo $value->portfolio_name; ?></td>
                <td><?php echo $value->mentor_name; ?></td>
                <td><?php echo $value->title; ?></td>
                <td><?php echo $value->feedback; ?></td>
                <td>
                    <?php
                    echo btn_edit('memtor/feedbackEdit/'.$value->id);
                    echo btn_delete('memtor/feedbackDelete/' . $value->id);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <tr><td colspan="5"><h3>We could not found any feedbacks!!!</h3></td></tr>
        </tr>
    <?php endif; ?>                            
</tbody>
</table>
<?php if(!empty($feedbacks)) : ?>
<script>
    $(() => {
        $('#datatable').DataTable({
            dom:'Bitip',
            ordering:false,
            buttons:[]
        });
    })
</script>
<?php endif; ?>  