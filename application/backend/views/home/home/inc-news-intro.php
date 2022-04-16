<ul class="list-group bg-white text-left" style="margin-bottom:0">
    <li class="list-group-item"><?php echo lang('point_number') ?>: <strong class="text-danger text-xl"><?php echo number_format($news->point) ?></strong></li>
    <li class="list-group-item">Dịch vụ: <?php echo implode(', ', $news->service_type_name); ?></li>
    <li class="list-group-item">
        Loại nhà: <?php echo $news->type_name; ?><?php if ($news->bedroom_number) echo '; ', lang('bedroom_number'), ': ', $news->bedroom_number; ?><?php if ($news->floor_number) echo '; ', lang('floor_number'), ': ', $news->floor_number; ?><?php if ($news->acreage) echo '; ', lang('acreage'), ': ', $news->acreage; ?>
    </li>
    <li class="list-group-item">Địa chỉ: <?php echo $news->address; ?></li>
    <li class="list-group-item">Số điện thoại chủ nhà: <?php echo hidePhone($news->owner_phone) ?></li>
    <li class="list-group-item">Link bài viết: <a href="<?php echo $news->url ?>" target="_blank" class="text-primary">Xem chi tiết &raquo;</a></li>
    <li class="text-center list-group-item"><button class="btn btn-danger" onclick="clickNews('<?php echo $news->code ?>')">Lấy SĐT</button></li>
</ul>