<table id="datatable" class="table table-bordered" data-controller="memtor/feedback">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Email</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Interests</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($list)) : foreach($list as $key => $value) : ?>
            <tr>
                <td><?= $value->id; ?></td>
                <td><?php echo $value->created_time; ?></td>
                <td><?php echo $value->email; ?></td>
                <td><?php echo $value->first_name; ?></td>
                <td><?php echo $value->last_name; ?></td>
                <td><?php echo '- ', implode('<br>- ', json_decode($value->interests, true)); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <tr><td colspan="5"><h3>We could not found any subcribers!!!</h3></td></tr>
        </tr>
    <?php endif; ?>                            
</tbody>
</table>
<?php if(!empty($list)) : ?>
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