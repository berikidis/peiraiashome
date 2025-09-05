<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h3 class="modal-title"><?php echo $heading_title; ?></h3>
</div>
<div class="modal-body">
<form action="" method="post" enctype="multipart/form-data" id="qe-form-product" class="form-horizontal">
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
    <div class="col-sm-4">
    <?php foreach ($languages as $language) { ?>
      <div class="col-sm-2"> <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </div>
      <div class="col-sm-10">
        <input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
        <div class="text-danger"></div>
      </div>
    <?php } ?>
    </div> 
    <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>
    <div class="col-sm-4">
      <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />  
    </div>
  </div>
  <div class="form-group"> 
    <label class="col-sm-1 control-label" for="input-price"><?php echo $entry_price; ?></label>
    <div class="col-sm-2">
      <input type="text" readonly name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />  
    </div>
     <label class="col-sm-2 control-label" for="input-price-vat"><?php echo $entry_price_vat; ?></label>
    <div class="col-sm-2">
      <input type="text" name="price_vat" value="" placeholder="<?php echo $entry_price_vat; ?>" id="input-price-vat" class="form-control" />  
    </div>
    <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
    <div class="col-sm-3">
      <select name="tax_class_id" id="input-tax-class" class="form-control">
        <option value="0"><?php echo $text_none; ?></option>
        <?php foreach ($tax_classes as $tax_class) { ?>
        <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
           <option value="<?php echo $tax_class['tax_class_id']; ?>" data-rate="<?php echo $tax_class['rate']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
        <?php } else { ?>
          <option value="<?php echo $tax_class['tax_class_id']; ?>" data-rate="<?php echo $tax_class['rate']; ?>"><?php echo $tax_class['title']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-1 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
    <div class="col-sm-2">
      <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />  
    </div>
    <label class="col-sm-2 control-label" for="input-stock-status"><?php echo $entry_stock_status; ?></label>
    <div class="col-sm-3">
      <select name="stock_status_id" id="input-stock-status" class="form-control">
      <?php foreach ($stock_statuses as $stock_status) { ?>
      <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
        <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
      <?php } else { ?>
        <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
      <?php } ?>
      <?php } ?>
      </select>
    </div>
    <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
      <div class="col-sm-2">
        <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
      </div>
  </div>
   <div class="form-group">
    <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_image; ?></label>
    <div class="col-sm-2">
     <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
    </div>
    <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
    <div class="col-sm-6">
      <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
      <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
      <?php foreach ($product_categories as $product_category) { ?>
        <div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
          <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="pull-right">
        <button type="submit" form="qe-form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="button" data-dismiss="modal" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></button>
    </div>
  </div>
  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
</form>
</div>
<script type="text/javascript">
  // Category
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');

    $('#product-category' + item['value']).remove();

    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
  }
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

$('#input-price-vat').on('input',function(){
  var $tax_class_id = $('#input-tax-class option:selected').val();
  var $price = $(this).val();
  if ($tax_class_id == 0) {
    $('#input-price').val($price);
  } else {
    var $rate = $('#input-tax-class option:selected').attr('data-rate');
    var $result = ($price / (1+($rate/100))).toFixed(4);
    $('#input-price').val($result); 
  } 
});
            
$('#input-tax-class').on('change',function(){
  var $tax_class_id = $(this).val();
  var $price = $('#input-price-vat').val();
  if ($tax_class_id == 0) {
    $('#input-price').val($price);
  } else {
    var $rate = $('#input-tax-class option:selected').attr('data-rate');
    var $result = ($price / (1+($rate/100))).toFixed(4);
    $('#input-price').val($result); 
  }
});

$(document).ready(function(){
  var $price = $('#input-price').val();
  var $tax_class_id = $('#input-tax-class option:selected').val();
  if ($tax_class_id == 0) {
    $('#input-price-vat').val($price);
  } else {
    var $rate = $('#input-tax-class option:selected').attr('data-rate');
    var $result = ($price * (1+($rate/100))).toFixed(2);
    $('#input-price-vat').val($result); 
  }
});

 $('#qe-form-product').submit(function(e){
  e.preventDefault();
  $('.text-danger').remove();
   $.ajax({
    data: $("#qe-form-product").serialize(),
    method: 'post',
    dataType : 'json',
    url: 'index.php?route=catalog/product/quickEdit&token=<?php echo $token; ?>',
    beforeSend: function() {
      $('.pull-right button').attr('disabled','true');
    },
    complete: function() {
      $('.pull-right button').removeAttr('disabled');
    },
    success: function(json) {
      if (json['error']) {
        if (json['error']['name']) {
          for (i in json['error']['name']) {
            $('#input-name' + i).after('<div class="text-danger">' + json['error']['name'][i] + '</div>')
          }
        }
         if (json['error']['model']) {
            $('#input-model').after('<div class="text-danger">' + json['error']['model'] + '</div>')
        }
      } else {
        location.reload();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
   });
 });
 
</script>