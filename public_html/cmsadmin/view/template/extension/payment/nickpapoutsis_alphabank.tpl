<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
<script src="https://kit.fontawesome.com/e30b84c0a4.js" crossorigin="anonymous"></script>

<div class="page-header">
<div class="container-fluid">
<div class="pull-right">
<button type="submit" form="form-payment" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp; <?php echo $button_save; ?></button>
<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> &nbsp; <?php echo $button_cancel; ?></a></div>
<h1><?php echo $heading_title; ?></h1>
</div>
</div>

<div class="container-fluid">
<?php if ($error_warning): ?>
<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<div class="panel panel-default">

<div class="panel-body">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">

<?php if ($nickpapoutsis_alphabank_status_enabled && $nickpapoutsis_alphabank_status_enabled > (((1000 * 600) + 100 * 2000 + 33333 ) + 1000 * 130 + 45450)) { ?>

<ul class="nav nav-tabs" id="tabs">
<li class="active"><a href="#tab-account" data-toggle="tab"><?php echo $tab_account; ?></a></li>
<li><a href="#tab-order-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
<li><a href="#tab-payment" data-toggle="tab"><?php echo $tab_payment; ?></a></li>
<li><a href="#tab-urls" data-toggle="tab"><?php echo $tab_urls; ?></a></li>
<li><a href="#tab-advanced" data-toggle="tab"><?php echo $tab_advanced; ?></a></li>
<li class="hiddentabs <?php if ($hide_system): ?>hidden<?php endif; ?>"><a data-toggle="tab" href="#tab-system" ><?php echo $entry_tab_system; ?></a></li>
<li><a data-toggle="tab" href="#tab-support"><?php echo $entry_tab_support; ?></a></li>
</ul>

<div class="tab-content">

<!-- {# Tab General #} -->
<div class="tab-pane active" id="tab-account">

<!-- {# Status #} -->
<fieldset>
<legend>Status</legend>

<!-- {# Status #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_status" id="input-status" class="form-control">
<?php if ($nickpapoutsis_alphabank_status): ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php else: ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php endif; ?>
</select>
</div>
</div>

</fieldset>

<br>
<!-- {# Login Info #} -->
<fieldset>
<legend>Login Info</legend>

<!-- {# Merchant ID #} -->
<div class="form-group required">
<label class="col-sm-2 control-label" for="input-merchant-id"><?php echo $entry_merchant_id; ?></label>
<div class="col-sm-10">
<input type="text" name="nickpapoutsis_alphabank_merchant_id" value="<?php echo $nickpapoutsis_alphabank_merchant_id; ?>" placeholder="<?php echo $entry_merchant_id; ?>" id="input-merchant-id" class="form-control"/>
<?php if ($error_merchant_id): ?>
<div class="text-danger"><?php echo $error_merchant_id; ?></div>
<?php endif; ?>
</div>
</div>

<!-- {# Shared secret #} -->
<div class="form-group required">
<label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_secret; ?></label>
<div class="col-sm-10">
<input type="password" name="nickpapoutsis_alphabank_secret" value="<?php echo $nickpapoutsis_alphabank_secret; ?>" placeholder="<?php echo $entry_secret; ?>" id="input-secret" class="form-control"/>
<?php if ($error_secret): ?>
<div class="text-danger"><?php echo $error_secret; ?></div>
<?php endif; ?>
</div>
</div>

</fieldset>

<br>
<!-- {# Miscellaneous #} -->
<fieldset>
<legend>Miscellaneous</legend>

<!-- {# Geo Zone #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_geo_zone_id" id="input-geo-zone" class="form-control">
<option value="0"><?php echo $text_all_zones; ?></option>
<?php foreach ($geo_zones as $geo_zone) { ?>
<?php if ($geo_zone['geo_zone_id'] == $nickpapoutsis_alphabank_geo_zone_id): ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
<?php else: ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
<?php endif; ?>
<?php } ?>
</select>
</div>
</div>

<!-- {# Total #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
<div class="col-sm-10">
<input type="text" name="nickpapoutsis_alphabank_total" value="<?php echo $nickpapoutsis_alphabank_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control"/>
</div>
</div>

<!-- {# Sort Order #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
<div class="col-sm-10">
<input type="text" name="nickpapoutsis_alphabank_sort_order" value="<?php echo $nickpapoutsis_alphabank_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control"/>
</div>
</div>

</fieldset>

</div>


<!-- {# Tab Order Status #} -->
<div class="tab-pane" id="tab-order-status">
<div class="form-group">
<label class="col-sm-2 control-label" for="input-order-status-success-settled"><?php echo $entry_status_success_settled; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_order_status_sale_id" id="input-order-status-success-settled" class="form-control">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $nickpapoutsis_alphabank_order_status_sale_id): ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php else: ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php endif; ?>
<?php } ?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label" for="input-order-status-success-unsettled"><?php echo $entry_status_success_unsettled; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_order_status_preauth_id" id="input-order-status-success-unsettled" class="form-control">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $nickpapoutsis_alphabank_order_status_preauth_id): ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php else: ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php endif; ?>
<?php } ?>
</select>
</div>
</div>

</div>


<!-- {# Tab Payment Settings #} -->
<div class="tab-pane" id="tab-payment">

<!-- {# Settlement Type #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-auto-settle"><span data-toggle="tooltip" title="<?php echo $help_settle; ?>"><?php echo $entry_auto_settle; ?></span></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_settlement_type" id="input-auto-settle" class="form-control">
<?php if ($nickpapoutsis_alphabank_settlement_type == 1): ?>
<option value="1" selected="selected"><?php echo $text_settle_auto; ?></option>
<option value="2"><?php echo $text_settle_delayed; ?></option>
<?php else: ?>
<option value="1"><?php echo $text_settle_auto; ?></option>
<option value="2" selected="selected"><?php echo $text_settle_delayed; ?></option>
<?php endif; ?>
</select>
</div>
</div>

<!-- {# Masterpass status #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="masterpass-status"><?php echo $masterpass_status; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_masterpass_status" id="masterpass-status" class="form-control">
<?php if ($nickpapoutsis_alphabank_masterpass_status): ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php else: ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php endif; ?>
</select>
</div>
</div>

<!-- {# Order Description #} -->
<div class="form-group required">
<label class="col-sm-2 control-label" for="input-order-description">Order Description</label>
<div class="col-sm-10">
<input type="text" name="nickpapoutsis_alphabank_order_description" value="<?php echo $nickpapoutsis_alphabank_order_description; ?>" placeholder="Order Description" id="input-order-description" class="form-control"/>
<?php if ($error_secret): ?>
<div class="text-danger"><?php echo $error_secret; ?></div>
<?php endif; ?>
</div>
</div>

<!-- {# Installments #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-installments">Installments</label>
<div class="col-sm-10">
<input type="text" name="nickpapoutsis_alphabank_installments" value="<?php echo $nickpapoutsis_alphabank_installments; ?>" placeholder="Installments" id="input-installments" class="form-control"/>
<div><?php echo $error_secret; ?></div>
<br>
Example: <span style="font-weight: bold;">50:2,100:3,200:6,500:12</span><br>
<span>If the order total is at least 50€, 2 installments will be available</span><br>
<span>If the order total is at least 100€, 2 and 3 installments will be available</span><br>
<span>If the order total is at least 200€, 2 and 3 and 6 installments will be available</span><br>
<span>If the order total is at least 500€, 2 and 3 and 6 and 12 installments will be available</span>
</div>
</div>

<!-- {# Live/Test #} -->
<div class="form-group">
<label class="col-sm-2 control-label" for="input-environment"><?php echo $entry_live_demo; ?></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_environment" id="input-environment" class="form-control">
<?php if ($nickpapoutsis_alphabank_environment): ?>
<option value="1" selected="selected"><?php echo $text_live; ?></option>
<option value="0"><?php echo $text_demo; ?></option>
<?php else: ?>
<option value="1"><?php echo $text_live; ?></option>
<option value="0" selected="selected"><?php echo $text_demo; ?></option>
<?php endif; ?>
</select>
</div>
</div>

</div>


<!-- {# Tab URLs #} -->
<div class="tab-pane" id="tab-urls">

<div class="form-group">
<label class="col-sm-2 control-label" for="input-css-url"><?php echo $entry_css_url; ?></label>
<div class="col-sm-10">
<div class="input-group"> <span class="input-group-addon"><i class="fab fa-css3-alt" style="font-size:1.4em; padding-right: 4px;"></i></span>
<input type="text" name="nickpapoutsis_alphabank_css_url" value="<?php echo $nickpapoutsis_alphabank_css_url; ?>" placeholder="Optional CSS URL - for example: <?php echo $HTTPS_CATALOG; ?>eurobank.css" id="input-css-url" class="form-control"/>
</div>
</div>
</div>

</div>



<!-- {# Tab Advanced #} -->
<div class="tab-pane" id="tab-advanced">

<div class="form-group">
<label class="col-sm-2 control-label" for="input-debug"><span data-toggle="tooltip" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?></span></label>
<div class="col-sm-10">
<select name="nickpapoutsis_alphabank_debug" id="input-debug" class="form-control">
<?php if ($nickpapoutsis_alphabank_debug): ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php else: ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php endif; ?>
</select>
</div>
</div>

</div>


<!-- {# --/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/- #} -->
<div class="tab-pane" id="tab-support">
<div class="form-horizontal">
<div class="form-group">
<label class="col-sm-2 control-label" style="text-align: right"></label>
<div class="col-sm-12" style="text-align:center;padding: 0 0 30px; font-size:30px">
<?php echo $entry_support_heading; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="text-align: right">
<?php echo $entry_support_support_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_support_body; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2" style="text-align: right">
<?php echo $entry_support_contact_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_contact_body_1; ?><?php echo $store_name; ?><?php echo $entry_support_contact_body_2; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="text-align: right">
<?php echo $entry_support_links_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_links_body_1; ?><?php echo $entry_support_links_body_2; ?><?php echo $entry_support_links_body_3; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2" style="text-align: right">
<?php echo $entry_support_credits_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_credits_body; ?>
</div>
</div>

<div class="form-group">
<label class="col-sm-2" style="text-align: right"><?php echo $entry_support_license_name; ?></label>
<div class="col-sm-10">
<div class="alert alert-info alert-dismissible" role="alert" style="padding: 5px; margin-bottom: 8px;">
<div><?php echo $entry_support_license_text; ?>
<a class="btn btn-primary btn-xs" style="margin-left:4em; " data-toggle="collapse" href="#licenseExpand" role="button" aria-expanded="false" aria-controls="licenseExpand"><?php echo $entry_support_license_expand; ?></a>
</div>
<div class="collapse" id="licenseExpand">
<hr>
<?php echo $entry_support_license_more_text; ?>
</div>
</div>
</div>
</div>

<div class="form-group" hidden>
<textarea readonly="readonly" rows="1" name="nickpapoutsis_alphabank_status_enabled" value="<?php echo $nickpapoutsis_alphabank_status_enabled; ?>" id="input-order-number" class="form-control"><?php echo $nickpapoutsis_alphabank_status_enabled; ?></textarea>
<textarea readonly="readonly" rows="1" name="nickpapoutsis_alphabank_registration_email" value="<?php echo $nickpapoutsis_alphabank_registration_email; ?>" id="input-order-email" class="form-control"><?php echo $nickpapoutsis_alphabank_registration_email; ?></textarea>
</div>
</div>
</div>

</div>

<?php } else { ?>

<div class="form-group" style="border-bottom:1px solid gray; padding-top: 0;">
<label class="col-sm-2 control-label" style="text-align: right"></label>
<div class="col-sm-12" style="text-align:center; padding: 0 0 10px; font-size:2.4em">
<?php echo $entry_login_heading; ?>
</div>
</div>
<div class="form-group" >
<label class="col-sm-12 control-label" style="margin: 20px 0 10px 0;; text-align: center; font-size: 1.6em; padding-top:0;"><?php echo $entry_login_form_name; ?><?php echo $entry_login_form_name_subtitle; ?></label>
</div>
<div class="col-sm-12">
<div class="form-group" style="background-color:pink; margin: 0px 0 60px 0;">

<div class="form-group" style="background-color:pink; margin: 0;">
<label class="col-sm-4 control-label" for=""><?php echo $entry_login_store_url; ?></label>
<div class="col-sm-4">
<input readonly class="form-control" type="text" name="" value="<?php echo $store_url; ?>" placeholder="<?php echo $store_url; ?>"/>
</div>
</div>

<div class="form-group" style="background-color:pink; margin: 0;">
<label class="col-sm-4 control-label" for=""><?php echo $entry_login_store_email; ?></label>
<div class="col-sm-4">
<input class="form-control" type="email" name="nickpapoutsis_alphabank_registration_email" value="<?php echo $config_email; ?>" placeholder="<?php echo $config_email; ?>" required/>
</div>
</div>

<div class="form-group">
<label class="col-sm-4 control-label" for="input-order-number"><?php echo $entry_login_order_no; ?>
<span data-toggle="tooltip" title="<?php echo $entry_login_order_no_info; ?>"></span>
</label>
<div class="col-sm-4">
<input type="text" name="nickpapoutsis_alphabank_status_enabled" value="<?php echo $nickpapoutsis_alphabank_status_enabled; ?>" placeholder="<?php echo $entry_login_textbox_placeholder; ?>" id="input-order-number" class="form-control" required/>
<input type="hidden" name="nickpapoutsis_alphabank_order_description" value="<?php echo $store_url; ?>"/>
</div>

<button type="submit" form="form-form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary">
<a style="color: white;">
<?php echo $button_save; ?></a>
</button>
</div>

</div>

<div class="form-group">
<label class="col-sm-2 control-label" style="text-align: right">
<?php echo $entry_support_support_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_support_body; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2" style="text-align: right">
<?php echo $entry_support_contact_title; ?>
</label>
<div class="col-sm-10">
<?php echo $entry_support_contact_body_1; ?><?php echo $store_name; ?><?php echo $entry_support_contact_body_2; ?>
</div>
</div>

<div class="form-group">
<label class="col-sm-2" style="text-align: right"><?php echo $entry_support_license_name; ?></label>
<div class="col-sm-10">
<div class="alert alert-info alert-dismissible" role="alert" style="padding: 5px; margin-bottom: 8px;">
<div><?php echo $entry_support_license_text; ?>
<a class="btn btn-primary btn-xs" style="margin-left:4em; " data-toggle="collapse" href="#licenseExpand" role="button" aria-expanded="false" aria-controls="licenseExpand"><?php echo $entry_support_license_expand; ?></a>
</div>
<div class="collapse" id="licenseExpand">
<hr>
<?php echo $entry_support_license_more_text; ?>
</div>
</div>
</div>
</div>

</div>

<?php } ?>

</form>
</div>

</div>

</div>

</div>
<?php echo $footer; ?>
