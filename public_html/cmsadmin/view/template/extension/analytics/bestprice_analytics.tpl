<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-bestprice-analytics" data-toggle="tooltip" title="
					<?php echo $button_save; ?>" class="btn btn-primary">
					<i class="fa fa-save"></i>
				</button>
				<a href="
					<?php echo $cancel; ?>" data-toggle="tooltip" title="
					<?php echo $button_cancel; ?>" class="btn btn-default">
					<i class="fa fa-reply"></i>
				</a>
			</div>
			<h1>
				<?php echo $heading_title; ?>
			</h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li>
					<a href="
						<?php echo $breadcrumb['href']; ?>">
						<?php echo $breadcrumb['text']; ?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger">
			<i class="fa fa-exclamation-circle"></i>
			<?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-pencil"></i>
					<?php echo $text_edit; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="
					<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bestprice-analytics" class="form-horizontal">
					
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-product-badge" data-toggle="tab"><?php echo $tab_product_badge; ?></a></li>
						<li><a href="#tab-update" data-toggle="tab"><?php echo $tab_update; ?></a></li>
					  </ul>
					  <div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-code">
									<?php echo $entry_code; ?>
								</label>
								<div class="col-sm-10">
									<input type="text" name="bestprice_analytics_code" value="<?php echo $bestprice_analytics_code; ?>" id="input-code" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-feed-id">
									<?php echo $entry_feed_id; ?>
								</label>
								<div class="col-sm-10">
									<select name="bestprice_analytics_feed_id" id="input-feed-id" class="form-control">
										<option value="product_id" 
											<?php echo ($bestprice_analytics_feed_id == 'product_id')? 'selected':''; ?>>Product ID
										</option>
										<option value="model" 
											<?php echo ($bestprice_analytics_feed_id == 'model')? 'selected':''; ?>>MODEL
										</option>
										<option value="sku" 
											<?php echo ($bestprice_analytics_feed_id == 'sku')? 'selected':''; ?>>SKU
										</option>
										<option value="upc" 
											<?php echo ($bestprice_analytics_feed_id == 'upc')? 'selected':''; ?>>UPC
										</option>
										<option value="ean" 
											<?php echo ($bestprice_analytics_feed_id == 'ean')? 'selected':''; ?>>EAN
										</option>
										<option value="isbn" 
											<?php echo ($bestprice_analytics_feed_id == 'isbn')? 'selected':''; ?>>ISBN
										</option>
										<option value="mpn" 
											<?php echo ($bestprice_analytics_feed_id == 'mpn')? 'selected':''; ?>>MPN
										</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tax-class">
									<?php echo $entry_tax_class; ?>
								</label>
								<div class="col-sm-10">
									<select name="bestprice_analytics_tax_class_id" id="input-tax-class" class="form-control">
										<option value="0">
											<?php echo $text_none; ?>
										</option>
										<?php foreach ($tax_classes as $tax_class) { ?>
										<?php if ($tax_class['tax_class_id'] == $bestprice_analytics_tax_class_id) { ?>
										<option value="
											<?php echo $tax_class['tax_class_id']; ?>" selected="selected">
											<?php echo $tax_class['title']; ?>
										</option>
										<?php } else { ?>
										<option value="
											<?php echo $tax_class['tax_class_id']; ?>">
											<?php echo $tax_class['title']; ?>
										</option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status">
									<?php echo $entry_status; ?>
								</label>
								<div class="col-sm-10">
									<select name="bestprice_analytics_status" id="input-status" class="form-control">
										<?php if ($bestprice_analytics_status) { ?>
										<option value="1" selected="selected">
											<?php echo $text_enabled; ?>
										</option>
										<option value="0">
											<?php echo $text_disabled; ?>
										</option>
										<?php } else { ?>
										<option value="1">
											<?php echo $text_enabled; ?>
										</option>
										<option value="0" selected="selected">
											<?php echo $text_disabled; ?>
										</option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab-product-badge">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-product-badge-status">
									<?php echo $entry_product_badge_status; ?>
								</label>
								<div class="col-sm-10">
									<select name="bestprice_analytics_product_badge_status" id="input-product-badge-status" class="form-control">
										<?php if ($bestprice_analytics_product_badge_status) { ?>
										<option value="1" selected="selected">
											<?php echo $text_enabled; ?>
										</option>
										<option value="0">
											<?php echo $text_disabled; ?>
										</option>
										<?php } else { ?>
										<option value="1">
											<?php echo $text_enabled; ?>
										</option>
										<option value="0" selected="selected">
											<?php echo $text_disabled; ?>
										</option>
										<?php } ?>
									</select>
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-bestprice_analytics_product_badge_mid">
									<?php echo $entry_product_badge_mid; ?>
								</label>
								<div class="col-sm-10">
									<input type="text" name="bestprice_analytics_product_badge_mid" value="<?php echo $bestprice_analytics_product_badge_mid; ?>" id="input-bestprice_analytics_product_badge_mid" class="form-control" />
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab-update">
							<div class="form-group">
								<label class="col-sm-2 control-label"  style="padding-top: 0;">
									<?php echo $text_update; ?>
								</label>
								<div class="col-sm-10">

									<?php if ($update_error) { ?>
										<span style="color: red;"><?php echo $text_update_error; ?><span>
									<?php } else { ?>
										<?php if ($up_to_date) { ?>
											<span style="color: green;"><?php echo $text_updated; ?></span>
										<?php } else { ?>
											<span style="color: red;"><?php echo $text_update_available; ?>
												<?php echo $version; ?></span>
										<?php } ?>
									<?php } ?>

								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" style="padding-top: 0;">
									<?php echo $text_extension_version; ?>
								</label>
								<div class="col-sm-10">
									<?php echo $curr_version; ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" style="padding-top: 0;">
									<?php echo $text_download; ?>
								</label>
								<div class="col-sm-10">
									<a href="<?php echo $download_link; ?>">
										<?php echo $text_download_now; ?></a>
								</div>
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?> 