<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-heading">
                    <h3 class="box-title">Journey</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-name">Journey name</label>
                            <input type="text" class="form-control" name="name" id="input-name" placeholder="" value="<?php echo $journey->name;?>">
                        </div>
                        <div class="form-group">
                            <label for="position">Vị trí</label>
                            <input type="number" class="form-control" id="position" name="position" placeholder="" value="<?php echo $journey->position;?>">
                        </div>
                        <div class="form-group">
                            <label for="url">Ghi chú</label>
                            <input type="text" class="form-control" id="url" name="note" placeholder="" value="<?php echo $journey->note;?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($journey->id): ?>
            <div class="box box-primary">
                <div class="box-heading">
                    <div style="padding:15px">
                        <h3 class="box-title">Milestone</h3>
                        <a href="#" class="btn btn-success btn-xs" id="addmore-milestone"><i class="fa fa-plus"></i> Add more</a>
                        <input type="hidden" name="journey_id" value="<?php echo $journey->id; ?>">
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Milestones</th>
                                    <th>Activities</th>
                                    <th>Output</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="defined-milestone" class="hidden">
                                    <td style="width:50px">
                                        <input type="number" name="position" class="form-control">
                                    </td>
                                    <td style="width:200px">
                                        <input type="text" name="milestone" class="form-control">
                                    </td>
                                    <td>
                                        <textarea class="form-control pre-wrap" name="activities" rows="1"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control pre-wrap" name="output" rows="1"></textarea>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-default btn-save-milestone"><i class="fa fa-floppy-o blue"></i></a>
                                        <a href="#" class="btn btn-xs btn-default btn-cancel hidden"><i class="fa fa-times red"></i></a>
                                    </td>
                                </tr>
                                <?php if ($milestone): foreach ($milestone as $key => $value) : ?>
                                    <tr id="<?php echo $value->id; ?>">
                                        <td style="width:50px">
                                            <input type="number" name="position" value="<?php echo $value->position; ?>" class="form-control">
                                        </td>
                                        <td style="width:200px">
                                            <input type="text" name="milestone" class="form-control" value="<?php echo $value->milestone; ?>">
                                        </td>
                                        <td>
                                            <textarea class="form-control pre-wrap" name="activities" rows="1"><?php echo $value->activities; ?></textarea>
                                        </td>
                                        <td>
                                            <textarea class="form-control pre-wrap" name="output" rows="1"><?php echo $value->output; ?></textarea>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-default btn-save-milestone"><i class="fa fa-floppy-o blue"></i></a>
                                            <a href="#" class="btn btn-xs btn-default btn-remove-milestone"><i class="fa fa-times red"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>