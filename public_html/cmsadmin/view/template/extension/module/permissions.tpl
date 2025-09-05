<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-permissions" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
       <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-permissions" class="form-horizontal">
        <fieldset>
	        <div class="form-group">
	        	<div class="well well-sm" style="height: 150px; overflow: auto;">
	        		<div class="col-sm-6">
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('sku',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[sku]" /> <?php echo $entry_sku; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('isbn',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[isbn]" /> <?php echo $entry_isbn; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('upc',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[upc]" /> <?php echo $entry_upc; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('ean',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[ean]" /> <?php echo $entry_ean; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('jan',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[jan]" /> <?php echo $entry_jan; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('mpn',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[mpn]" /> <?php echo $entry_mpn; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('location',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[location]" /> <?php echo $entry_location; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('length',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[length]" /> <?php echo $entry_dimension; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('length_class_id',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[length_class_id]" /> <?php echo $entry_length_class; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('weight',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[weight]" /> <?php echo $entry_weight; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('weight_class_id',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[weight_class_id]" /> <?php echo $entry_weight_class; ?></label>
		                </div>
		                <div class="checkbox">
		                    <label><input type="checkbox" <?= (array_key_exists('filter',$permissions_product) ? 'checked' : '');  ?> value="1" name="permissions_product[filter]" /> <?php echo $entry_filter; ?></label>
		                </div>
	        		</div>
	            </div>
	        </div>
        </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>