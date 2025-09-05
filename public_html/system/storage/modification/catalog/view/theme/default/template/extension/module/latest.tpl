
<?php if (isset($ee_tracking) && $ee_tracking && $ee_impression) { ?>
<script type="text/javascript"><!--
  $(document).ready(function() {
    setIntervalEE(function() {
      var ee_data = JSON.parse('<?php echo $ee_impression_data; ?>');
      ee_data['url'] = window.location.href;
      ee_data['title'] = document.title;
      $.ajax({
        url: 'index.php?route=extension/module/ee_tracking/listview',
        type: 'post',
        data: ee_data,
        dataType: 'json',
        success: function(json) {
          if (json) {
            console.log(json);
          }
        },
      <?php if ($ee_impression_log) { ?>
        error: function(xhr, exc, error) {
          $.post('index.php?route=extension/module/ee_tracking/listviewlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
            console.log(logs);
          });
        }
      <?php } ?>
    });
    }, <?php echo $ee_ga_callback ? $ee_ga_callback : 0; ?>, <?php echo $ee_generate_cid ? $ee_generate_cid : 0; ?>);
  });
  //--></script>
<?php } ?>
            
<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($products as $product) { ?>
  <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="product-thumb transition">
      <div class="image"><a href="<?php echo $product['href']; ?>" <?php if (isset($ee_tracking) && $ee_tracking && $ee_click) { ?>onclick="ee_product.click('<?php echo $product['product_id']; ?>', '<?php echo isset($product['ee_position']) ? $product['ee_position'] : ''; ?>', '<?php echo isset($ee_type) ? $ee_type : ''; ?>')"<?php } ?>><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <h4><a href="<?php echo $product['href']; ?>" <?php if (isset($ee_tracking) && $ee_tracking && $ee_click) { ?>onclick="ee_product.click('<?php echo $product['product_id']; ?>', '<?php echo isset($product['ee_position']) ? $product['ee_position'] : ''; ?>', '<?php echo isset($ee_type) ? $ee_type : ''; ?>')"<?php } ?>><?php echo $product['name']; ?></a></h4>
        <p><?php echo $product['description']; ?></p>
        <?php if ($product['rating']) { ?>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($product['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
      <div class="button-group">
        <button type="button" <?php if (isset($ee_tracking) && $ee_tracking && $ee_cart) { ?>data-eet-position="<?php echo isset($product['ee_position']) ? $product['ee_position'] : ''; ?>" data-eet-type="<?php echo isset($ee_type) ? $ee_type : ''; ?>"<?php } ?> onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
