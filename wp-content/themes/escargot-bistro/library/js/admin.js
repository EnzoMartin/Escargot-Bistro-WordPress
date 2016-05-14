jQuery('.custom_upload_image_button').on('click',function() {
    var $this = jQuery(this);
    var formfield = $this.siblings('.custom_upload_image');
    var preview = $this.siblings('.custom_preview_image');

    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    window.send_to_editor = function(html) {
        var imgurl = jQuery(html).attr('src');
        var classes = jQuery(html).attr('class');

        var id = classes.replace(/(.*?)wp-image-/, '');

        formfield.val(id);
        preview.attr('src', imgurl);
        tb_remove();
    };

    return false;
});

jQuery('.custom_clear_image_button').on('click',function() {
    var $parent = jQuery(this).parent();
    var defaultImage = $parent.siblings('.custom_default_image').text();

    $parent.siblings('.custom_upload_image').val('');
    $parent.siblings('.custom_preview_image').attr('src', defaultImage);

    return false;
});

jQuery('#items_is_wine').on('change',function() {
    if(this.checked){
        jQuery('.normal-price').stop().hide();
        jQuery('.wine-price').stop().show();
    } else {
        jQuery('.normal-price').stop().show();
        jQuery('.wine-price').stop().hide();
    }
});