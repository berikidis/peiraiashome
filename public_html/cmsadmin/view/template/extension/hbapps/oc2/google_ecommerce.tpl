<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<!--Header Start-->
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" onClick="document.getElementById('form-language').submit();" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
		<a href="https://bit.ly/2zMakXQ" target="_blank" class="btn btn-warning" style="background-color:#f23b3b; border-color:#f23b3b "><i class="fa fa-lock"></i> Buy PRO Version</a>
		<a href="https://www.huntbee.com/documentation/docs/google-analytics-enhanced-ecommerce-tracking-for-opencart" target="_blank" class="btn btn-default"><i class="fa fa-book"></i> Documentation</a>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
 <!--Header End--> 
 
  <div class="container-fluid">
    <!--Start - Error / Success Message if any -->
	<?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<!--End - Error / Success Message if any -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title" style="color: #e60e54;"><i class="fa fa-google"></i> <?php echo $heading_title; ?></h3>
			<?php if ($stores) { ?>
			<div class="pull-right">
			<select id="store">
				<option value="0" <?php echo ($store_id == 0)?'selected':''; ?>>Default Store</option>
				<?php foreach ($stores as $store) { ?>
					<option value="<?php echo $store['store_id']; ?>" <?php echo ($store_id == $store['store_id'])?'selected':''; ?>><?php echo $store['name']; ?></option>
				<?php } ?>
			</select>
			</div>
			<?php } ?>
      </div>
      <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
		  	<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label col-sm-3">Product ID / SKU</label>
					<div class="col-sm-9">
						<select name="ga_ecom_id" class="form-control">
							<option value="product_id" <?php echo ($ga_ecom_id == 'product_id')? 'selected':''; ?>>Product ID</option>
							<option value="sku" <?php echo ($ga_ecom_id == 'sku')? 'selected':''; ?>>SKU</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3">Currency Code (should be same as in your google analytics setup)</label>
					<div class="col-sm-9">
						<select name="ga_ecom_currency" id="input-currency" class="form-control">
						<?php foreach ($currencies as $currency) { ?>
						<?php if ($currency['code'] == $ga_ecom_currency) { ?>
						<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select>
					</div>
				</div>	
				
				 <div class="form-group">
					<label class="col-sm-3 control-label">Enable User/Customer ID Tracking</label>
					<div class="col-sm-3">
						<input type="checkbox" data-toggle="toggle" data-onstyle="success" name="ga_ecom_user_tracking" class="form-control" value="1" disabled="disabled"  />
					</div>
					<div class="col-sm-6">
						<span><a href="https://bit.ly/2zMakXQ" target="_blank" style="color: #f23b3b;">Buy PRO version to unlock these feature</a></span>
					</div>
			   </div>	
			   
			   <div class="form-group">
					<label class="col-sm-3 control-label">Detect user ID from IP</label>
					<div class="col-sm-3">
						<input type="checkbox" data-toggle="toggle" data-onstyle="success" name="ga_ecom_ip_match" class="form-control" value="1" disabled="disabled" />
					</div>
					<div class="col-sm-6">
						<span><a href="https://bit.ly/2zMakXQ" target="_blank" style="color: #f23b3b;">Buy PRO version to unlock these feature</a></span>
					</div>
			   </div>
			   
			   <div class="form-group">
					<label class="col-sm-3 control-label"><span data-toggle="tooltip" title="Customer ID, Payment Method, Shipping Method, Net profit per sale or product, Customer Language, Customer Currency, etc.">Additional Metrics / Dimension Integration</span></label>
					<div class="col-sm-9">
						<a href="https://bit.ly/2LCj3Pk" target="_blank" class="btn btn-default"><i class="fa fa-puzzle-piece"></i> PRO Integration Support</a>
					</div>
			   </div>	
			  </div>
			  
			  <div class="col-sm-6">
				  <a href="https://bit.ly/2LCj3Pk" target="_blank"><img src="https://www.huntbee.com/image/promo/google-analytics-lite-to-pro.jpg" width="100%"></a>
			  </div>	
          </form>
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
 	<img src="../image/catalog/Google-Analytics-logo.png" width="200px"> <br />
    <span class="help"><?php echo $heading_title; ?> - <?php echo $extension_version; ?> &copy; <a href="https://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="https://www.huntbee.com/get-support?utm_source=GA%20Ecommerce%20Plugin&utm_medium=Extension&utm_campaign=Support" target="_blank">SUPPORT</a> | <a href="https://www.huntbee.com/documentation/docs/google-analytics-enhanced-ecommerce-tracking-for-opencart" target="_blank">DOCUMENTATION</a></span></center>
</div><!--Huntbee copyrights end-->
</div>

<style type="text/css">
.pr_error,.pr_info,.pr_infos,.pr_success,.pr_warning{margin:10px 0;padding:12px}.pr_info{color:#00529B;background-color:#BDE5F8}.pr_success{color:#4F8A10;background-color:#DFF2BF}.pr_warning{color:#9F6000;background-color:#FEEFB3}.pr_error{color:#D8000C;background-color:#FFBABA}.pr_error i,.pr_info i,.pr_success i,.pr_warning i{margin:10px 0;vertical-align:middle}
</style>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
$('#store').on('change', function() {
	window.location.href = 'index.php?route=<?php echo $base_route; ?>/google_ecommerce&token=<?php echo $token; ?>&store_id='+$('#store').val();
});
</script>

<?php echo $footer; ?>