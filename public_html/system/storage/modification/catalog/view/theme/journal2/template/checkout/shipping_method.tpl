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
    $(document).on('change', 'input[name="shipping_method"]', function() {
        $.ajax({
            url: 'index.php?route=extension/module/ee_tracking/checkoutoption',
            type: 'post',
            data: { 'step': 4, 'step_option': $(this).data('eet-name'), 'url': window.location.href, 'title': document.title },
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
<?php if ($shipping_methods) { ?>
  <p><?php echo $text_shipping_method; ?></p>
  <?php foreach ($shipping_methods as $shipping_method) { ?>
  <p><strong><?php echo $shipping_method['title']; ?></strong></p>
  <?php if (!$shipping_method['error']) { ?>
  <?php foreach ($shipping_method['quote'] as $quote) { ?>
  <div class="radio">
    <label>
      <?php if ($quote['code'] == $code || !$code) { ?>
      <?php $code = $quote['code']; ?>
      <input type="radio" name="shipping_method" <?php if (isset($ee_checkout) && $ee_checkout) { ?>data-eet-name="<?php echo isset($quote['ee_title']) ? htmlspecialchars($quote['ee_title']) : htmlspecialchars($quote['title']); ?>"<?php } ?> value="<?php echo $quote['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" name="shipping_method" <?php if (isset($ee_checkout) && $ee_checkout) { ?>data-eet-name="<?php echo isset($quote['ee_title']) ? htmlspecialchars($quote['ee_title']) : htmlspecialchars($quote['title']); ?>"<?php } ?> value="<?php echo $quote['code']; ?>" />
      <?php } ?>
      <?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></label>
  </div>
  <?php } ?>
  <?php } else { ?>
  <div class="alert alert-danger warning"><?php echo $shipping_method['error']; ?></div>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  <p><strong><?php echo $text_comments; ?></strong></p>
  <p>
    <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
  </p>
  <div class="buttons">
    <div class="pull-right">
      <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary button" />
    </div>
  </div>
</div>
