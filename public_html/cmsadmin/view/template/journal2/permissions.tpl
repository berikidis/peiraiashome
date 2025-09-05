<?php echo $header; ?>
<?php if (isset($column_left)): ?>
<?php echo $column_left; ?>
<?php endif; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    	<div class="pull-right">
        	<a onclick="save_permissions()" title="<?php echo $button_save; ?>" class="btn btn-default save"><?php echo $button_save; ?></a>
    	</div>
      	<h1>Theme Administrator Permissions</h1>
    </div>
  </div>
  <div class="container-fluid">
  	<div class="message"></div>
    <div class="panel panel-default">
    	<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i>Menu</h3></div>
      	 <div class="panel-body">
			<div class="form-group">
			    <input type="checkbox" <?php echo (array_key_exists("menus/primary",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="menus/primary" value="Top Menu" data-on="Top Menu" data-off="Top Menu" data-onstyle="success" data-offstyle="danger">
			    <input type="checkbox" <?php echo (array_key_exists("menus/secondary",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="menus/secondary" value="Secondary Menu" data-on="Secondary Menu" data-off="Secondary Menu" data-onstyle="success" data-offstyle="danger">
			    <input type="checkbox" <?php echo (array_key_exists("menus/main",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="menus/main" value="Main Menu" data-on="Main Menu" data-off="Main Menu" data-onstyle="success" data-offstyle="danger">
			</div>
		</div>
		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i>Footer</h3></div>
      	 <div class="panel-body">
			    <div class="form-group">
			        <input type="checkbox" <?php echo (array_key_exists("footer/menu",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="footer/menu" value="Footer Menu" data-on="Footer Menu" data-off="Footer Menu" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("footer/copyright",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="footer/copyright" value="Copyright" data-on="Copyright" data-off="Copyright" data-onstyle="success" data-offstyle="danger">
			    </div>

		</div>
		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i>Blog</h3></div>
      	 <div class="panel-body">
			    <div class="form-group">
			        <input type="checkbox" <?php echo (array_key_exists("blog/settings",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="blog/settings" value="Ρυθμίσεις Blog" data-on="General" data-off="General" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("blog/posts",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="blog/posts" value="Άρθρα" data-on="Posts" data-off="Posts" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("blog/categories",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="blog/categories" value="Κατηγορίες Άρθρων" data-on="Categories" data-off="Categories" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("blog/comments",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="blog/comments" value="Σχόλια Άρθρων" data-on="Comments" data-off="Comments" data-onstyle="success" data-offstyle="danger">
			    </div>

		</div>
		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i>Modules</h3></div>
      	 <div class="panel-body">
			    <div class="form-group">
			        <input type="checkbox" <?php echo (array_key_exists("module/slider/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/slider/all" value="Slider" data-on="Slider" data-off="Slider" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/static_banners/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/static_banners/all" value="Banners" data-on="Banners" data-off="Banners" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/carousel/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/carousel/all" value="Carousel" data-on="Carousel" data-off="Carousel" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/custom_sections/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/custom_sections/all" value="Custom Sections" data-on="Custom Sections" data-off="Custom Sections" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/cms_blocks/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/cms_blocks/all" value="Cms Blocks" data-on="Cms Blocks" data-off="Cms Blocks" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/super_filter/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/super_filter/all" value="Φίλτρα" data-on="Super Filter" data-off="Super Filter" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/side_category/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/side_category/all" value="Side Category" data-on="Side Category" data-off="Side Category" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/side_column_menu/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/side_column_menu/all" value="Flyout Menu" data-on="Flyout Menu" data-off="Flyout Menu" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/side_products/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/side_products/all" value="Side Products" data-on="Side Products" data-off="Side Products" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/header_notice/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/header_notice/all" value="Header Notice" data-on="Header Notice" data-off="Header Notice" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/text_rotator/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/text_rotator/all" value="Text Rotator" data-on="Text Rotator" data-off="Text Rotator" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/headline_rotator/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/headline_rotator/all" value="Headline Rotator" data-on="Headline Rotator" data-off="Headline Rotator" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/photo_gallery/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/photo_gallery/all" value="Photo Gallery" data-on="Photo Gallery" data-off="Photo Gallery" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/side_blocks/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/side_blocks/all" value="Side_Blocks" data-on="Side_Blocks" data-off="Side_Blocks" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/fullscreen_slider/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/fullscreen_slider/all" value="Fullscreen Slider" data-on="Fullscreen Slider" data-off="Fullscreen Slider" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/product_tabs/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/product_tabs/all" value="Product Tabs" data-on="Product Tabs" data-off="Product Tabs" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/advanced_grid/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/advanced_grid/all" value="Advanced Grid" data-on="Advanced Grid" data-off="Advanced Grid" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/newsletter/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/newsletter/all" value="Newsletter" data-on="Newsletter" data-off="Newsletter" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/popup/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/popup/all" value="Popup" data-on="Popup" data-off="Popup" data-onstyle="success" data-offstyle="danger">
			        <input type="checkbox" <?php echo (array_key_exists("module/accordion/all",$results) ? 'checked' : '' ); ?> data-toggle="toggle" name="module/accordion/all" value="Accordion" data-on="Accordion" data-off="Accordion" data-onstyle="success" data-offstyle="danger">

			    </div>

		</div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function save_permissions() {
		$.ajax({
			url: 'index.php?route=module/journal2/editpermissions&token=<?php echo $token; ?>',
			dataType: 'json',
				data:  $('input[type=\'checkbox\']:checked'),
				method: 'post',
				beforeSend: function() {
					$('.save').html('<img src="../image/data/journal2/loader.gif" alt="loader" />');
				},
				complete: function() {
					$('.save').html('<?php echo $button_save; ?>');
				},
				success: function(json) {
					$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json["success"] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');		
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
		});
	}
</script>
<?php echo $footer; ?>