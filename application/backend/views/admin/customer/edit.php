<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <?php echo form_open('','role="form"'); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputText1">Display Name</label> <?php echo form_error('display_name');?>
                            <?php echo form_input('display_name',set_value('display_name',$customer->display_name),'class="form-control"'); ?>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="exampleInputText1">Full Name</label> <?php echo form_error('fullname');?>
                            <?php echo form_input('fullname',set_value('fullname',$customer->fullname),'class="form-control"'); ?>
                        </div>                          
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label> <?php echo form_error('email');?>
                            <?php echo form_input('email',set_value('email',$customer->email),'class="form-control"'); ?>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label> <?php echo form_error('address');?>
                            <?php echo form_input('address',set_value('address',$customer->address),'class="form-control"'); ?>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company</label> <?php echo form_error('company');?>
                            <?php echo form_input('company',set_value('company',$customer->company),'class="form-control"'); ?>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label> <?php echo form_error('phone');?>
                            <?php echo form_input('phone',set_value('phone',$customer->phone),'class="form-control"'); ?>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label> <?php echo form_error('status');?>
                            <?php echo form_checkbox('status','1', ($customer->status == 1) ? TRUE : FALSE); ?>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>