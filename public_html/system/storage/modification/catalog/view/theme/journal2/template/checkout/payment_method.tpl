<div class="checkout-content">
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  
<?php if (isset($ee_tracking) && $ee_tracking && $ee_checkout) { ?>
<script type="text/javascript"><!--
    var ee_data = JSON.parse('<?php echo $ee_data; ?>');
    ee_data['url'] = window.location.href;
    ee_data['title'] = document.title;
    $.ajax({
        url: 'index.php?route=extension/module/ee_tracking/checkout',
        type: 'post',
        data: ee_data,
        dataType: 'json',
        success: function(json) {
            if (json) {
                console.log(json);
            }
        },
    <?php if ($ee_checkout_log) { ?>
        error: function(xhr, exc, error) {
            $.post('index.php?route=extension/module/ee_tracking/checkoutlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
                console.log(logs);
            });
        }
    <?php } ?>
    });
    $(document).on('change', 'input[name="payment_method"]', function() {
        $.ajax({
            url: 'index.php?route=extension/module/ee_tracking/checkoutoption',
            type: 'post',
            data: { 'step': 5, 'step_option': $(this).data('eet-name'), 'url': window.location.href, 'title': document.title },
            dataType: 'json',
            success: function(json) {
                if (json) {
                    console.log(json);
                }
            },
        <?php if ($ee_checkout_log) { ?>
            error: function(xhr, exc, error) {
                $.post('index.php?route=extension/module/ee_tracking/checkoutlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
                    console.log(logs);
                });
            }
        <?php } ?>
    });
    });
    //--></script>
<?php } ?>
<?php if ($payment_methods) { ?>
  <p><?php echo $text_payment_method; ?></p>
  <?php foreach ($payment_methods as $payment_method) { ?>
  <div class="radio">
    <label>
      <?php if ($payment_method['code'] == $code || !$code) { ?>
      <?php $code = $payment_method['code']; ?>
      <input type="radio" name="payment_method" <?php if (isset($ee_checkout) && $ee_checkout) { ?>data-eet-name="<?php echo isset($payment_method['ee_title']) ? htmlspecialchars($payment_method['ee_title']) : htmlspecialchars($payment_method['title']); ?>"<?php } ?> value="<?php echo $payment_method['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" name="payment_method" <?php if (isset($ee_checkout) && $ee_checkout) { ?>data-eet-name="<?php echo isset($payment_method['ee_title']) ? htmlspecialchars($payment_method['ee_title']) : htmlspecialchars($payment_method['title']); ?>"<?php } ?> value="<?php echo $payment_method['code']; ?>" />
      <?php } ?>
      <?php echo $payment_method['title']; ?>
      <?php if (isset($payment_method['terms']) && $payment_method['terms']) { ?>
      (<?php echo $payment_method['terms']; ?>)
      <?php } ?>
    </label>
  </div>
  <?php } ?>
  <?php } ?>
  <p><strong><?php echo $text_comments; ?></strong></p>
  <p>
    <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
  </p>

     <div class="cart-module">
      <div class="cart-heading"><?php echo $coupon_heading_title; ?></div>
      <div class="cart-content">
      <label class="col-sm-2 control-label" for="input-coupon"><?php echo $entry_coupon; ?></label>
      <div class="col-sm-5">
      <input type="text" name="coupon" value="<?php echo $coupon; ?>" placeholder="<?php echo $entry_coupon; ?>" id="input-coupon" class="form-control" />
      <div class="pull-right">
      <input type="button" value="<?php echo $button_coupon; ?>" id="button-coupon" data-loading-text="<?php echo $text_loading; ?>"  class="btn btn-primary" />
      </div>
      </div>
      <div id="notifcation"></div>
    </div>
    </div>
<script>
$('#button-coupon').on('click', function() {
  $.ajax({
    type: 'POST',
    url: 'index.php?route=checkout/payment_method/validateCoupon',
     data: $('input[name="coupon"]'),
    dataType: 'json',   
    beforeSend: function() {
      $('.coupon-alert').remove();
      $('#button-coupon').attr('disabled', true);
    },
    complete: function() {
      $('#button-coupon').attr('disabled', false);
    },    
    success: function(json) {
      $('.coupon-alert').remove();
     
      if (json['error']) {
        $('.cart-module').before('<div class="coupon-alert alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }
      
      if (json['success']) {
        
         $('.cart-module').before('<div class="coupon-alert alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          
        setTimeout(function () {
          $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
        }, 100);

        $('#cart > ul').load('index.php?route=common/cart/info ul li');
      }
    }
  });
});
</script>
      
  <?php if ($text_agree) { ?>
  <div class="buttons">
    <div class="pull-right"><?php echo $text_agree; ?>
      <?php if ($agree) { ?>
      <input type="checkbox" name="agree" value="1" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="agree" value="1" />
      <?php } ?>
      &nbsp;
      <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary button" />
    </div>
  </div>
  <?php } else { ?>
  <div class="buttons">
    <div class="pull-right">
      <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary button" />
    </div>
  </div>
  <?php } ?>
</div>