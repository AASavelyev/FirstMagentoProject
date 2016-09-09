jQuery(document).ready(function(){
    jQuery('[name="fastBuyBtn"]').on('click', function(){
        if (!jQuery(this).data('islogged')) {
            jQuery('[name="infoModalWindow"]').modal();
        }
        else {
            jQuery.ajax({
                url: '/oneclick/index/save/',
                type: 'POST',
                data: {
                    product_id: jQuery('[name="fastBuyBtn"]').data('product')
                },
                success: function() {
                    successOrder();
                }
            })
        }
    });

    jQuery('.js-order-form-submit').on('click', function(){
        var form = jQuery('.js-oneClickOrder-from');
        jQuery.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function() {
                successOrder();
            }
        });
        jQuery('[name="infoModalWindow"]').modal('hide');
    });

    function successOrder() {
        jQuery('[name="fastBuyBtn"]').addClass('hide');
        jQuery('.js-success-alert').removeClass('hide');
    }
});
