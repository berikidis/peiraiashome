<div class="row">
  <div class="col-sm-6">
    <h2><?php echo $text_new_customer; ?></h2>
    <p><?php echo $text_checkout; ?></p>
    <div class="radio">
      <label>
        <?php if ($account == 'register') { ?>
        <input type="radio" name="account" value="register" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="account" value="register" />
        <?php } ?>
        <?php echo $text_register; ?></label>
    </div>
    
    <?php if (isset($ee_tracking) && $ee_tracking && $ee_checkout) { ?>
    <script type="text/javascript"><!--
      $(document).on('change', 'input[name="account"]', function() {
        $.ajax({
          url: 'index.php?route=extension/module/ee_tracking/checkoutoption',
          type: 'post',
          data: { 'step': 1, 'step_option': $(this).val(), 'url': window.location.href, 'title': document.title },
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
    <?php if ($checkout_guest) { ?>
			
    <div class="radio">
      <label>
        <?php if ($account == 'guest') { ?>
        <input type="radio" name="account" value="guest" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="account" value="guest" />
        <?php } ?>
        <?php echo $text_guest; ?></label>
    </div>
    <?php } ?>
    <p><?php echo $text_register_account; ?></p>
    <input type="button" value="<?php echo $button_continue; ?>" id="button-account" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
  <div class="col-sm-6">
    <h2><?php echo $text_returning_customer; ?></h2>
    <p><?php echo $text_i_am_returning_customer; ?></p>
    <div class="form-group">
      <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
      <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
    </div>
    <div class="form-group">
      <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
      <input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
      <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
    <input type="button" value="<?php echo $button_login; ?>" id="button-login" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
