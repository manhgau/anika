<script type="text/javascript" src="<?php echo base_url('admin/assets/js/ajaxUpload/offer-image.js'); ?>"></script>
<script type="text/javascript">
    var e_offer_img = $('input.offer_img');
    e_offer_img.each(function() {
        let $this = $(this);
        $this.bind('change', function(){ change_offer_img_preview($this); });
    });
    function change_offer_img_preview(element) {
        let srcList = element.val();
        let preview = element.next();
        preview.empty();
            
        if (srcList!='' && srcList!='null') 
        {
            $.each( srcList.split(','), function(index, item) {
                item = item.replace(/\s/g, '');
                let img = $('<img/>').attr('src', mediaUri+item);
                img.bind('click', function(){removeImg($(this));});
                img.appendTo(preview);
            } );
        }
    }

    var removeImg = function(element){
        let img = (element.attr('src'));
        let removeVal = img.match(/[0-9]{4}\_[0-9]{1,2}\/.*$/i);
        let input = element.parent().parent().find('input');
        let valInput = input.val();
        let arrInput = valInput.split(',');
        let result = arrInput.filter(function(elem){
               return elem != removeVal; 
            });
        input.val(result.join()).trigger('change');
    }

    $('.offer-img-preview > img').on('click', 
        function(e){
            e.preventDefault();
            removeImg($(this));
        }
    );
</script>