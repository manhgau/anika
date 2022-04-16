<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header" style="margin: 10px 0 0 0;padding: 10px 0 0px 0;">
                    <form action="" method="get">
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <select id="year-filter" class="form-control filter" style="width:100px;display:inline-block" name="year">
                        <?php 
                        for($y=2016;$y<=date('Y',time());$y++){
                            if($year===$y)
                                echo '<option value="'.$y.'" selected="selected"> '.$y.' </option>';
                            else 
                                echo '<option value="'.$y.'"> '.$y.' </option>';
                        }
                        ?>
                    </select>
                    <select id="month-filter" class="form-control filter" style="width:100px;display:inline-block" name="month">
                        <?php 
                        for($m=1;$m<=12;$m++){
                            if($month===$m)
                                echo '<option value="'.$m.'" selected="selected"> '.$m.' </option>';
                            else 
                                echo '<option value="'.$m.'"> '.$m.' </option>';
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-info">Lọc dữ liệu</button>
                    </form>
                </div>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th style="width:1px;display:none;"></th>
                                <th>Time</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Object</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($histories)) : foreach($histories as $key => $val) : ?>
                                <tr>
                                    <td style="display:none"><?php echo $val->id;?></td>
                                    <td><?php echo date('H:i:s d/m/Y',$val->time);?></td>
                                    <td><?php echo ucfirst($users[$val->user_id]->name);?></td>
                                    <td><?php 
                                    $_actions_array=array(
                                        'Login' => 'đăng nhập',
                                        'Logout' => 'đăng xuất',
                                        'Added' => 'thêm mới',
                                        'Updated' => 'sửa',
                                        'Deleted' => 'xóa',
                                        'Published' => 'xuất bản',
                                        'UnPublished' => 'hạ bài',
                                        'update_profile' => 'Sửa thông tin cá nhân',
                                        'update_user' => 'Sửa thông tin user',
                                        'return_news' => 'Trả bài',
                                    );
                                    echo $_actions_array[$val->action]; ?></td>
                                    <td><?php 
                                    if($val->item_table=='news') 
                                    {
                                        $_news = $news[$val->item_id];  echo '<a href="'.base_url('news/edit/'.$_news->id).'">'.$_news->title.'</a>';
                                    }
                                    else echo $val->item_table . ' - ' . $val->item_id;
                                    ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any actions!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>