<div class="modal-header">
    <h3>Login CI_CMS Dashboard</h3>
    <p>Login your information!</p>
</div>

<div class="modal-body">

<?php echo form_open(); ?>
<table>
    <tr>
        <td>Email</td>
        <td><?php echo form_input('email'); ?></td>
        <td><span style="color: #EA1243;"><?php echo form_error('email'); ?></span></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><?php echo form_password('password'); ?></td>
        <td><span style="color: #EA1243;"><?php echo form_error('password'); ?></span></td>
    </tr>
    <tr>
        <td colspan="3"><?php echo form_submit('submit','Log in','class="btn-small btn-primary"'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>
</div>