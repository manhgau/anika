<html lang="vi" style="" class="">
    <?php $this->load->view('home/block/head'); ?>
    <body>
        <!-- =-=-=-=-=-=-= PRELOADER =-=-=-=-=-=-= -->
        <div class="preloader" style="display: none;"><span class="preloader-gif"></span></div>
        <!-- =-=-=-=-=-=-= HEADER =-=-=-=-=-=-= -->
        <?php $this->load->view('home/block/top-bar'); ?>
        
        <!-- =-=-=-=-=-=-= HEADER Navigation =-=-=-=-=-=-= -->
        <?php $this->load->view('home/block/navigation'); ?>
        <!-- HEADER Navigation End -->

        <?php $this->load->view('home/' . $subView); ?>
        
        <!-- =-=-=-=-=-=-= FOOTER =-=-=-=-=-=-= -->
        <?php $this->load->view('home/block/footer'); ?>

        <?php $this->load->view('home/block/load-js'); ?>

        <?php if ($subJs) $this->load->view('home/' . $subView . '-js'); ?>
        <div style="clear: both;"></div>

        <!-- app dialog -->
        <div id="dialog" title="Thông báo"></div>

        <!-- app modal -->
        <div class="modal fade" id="app-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content rounded-0 border-0"></div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>