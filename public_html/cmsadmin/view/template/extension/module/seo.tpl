<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a onclick="createBackup()" data-toggle="tooltip" title="<?php echo $button_backup; ?>" class="btn btn-success"><i class="fa fa-hdd-o" aria-hidden="true"></i></a>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-latest" class="form-horizontal">   
        	<div class="row">
        		<div class="col-sm-3">  
        			<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="input-keyword"><?php echo $entry_keyword; ?></label>
    					</div>
    					<div class="panel-body">
    						<input id="input-keyword" class="form-control" name="keyword" type="text" value="<?php echo $keyword; ?>" />
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="input-seo-url"><?php echo $entry_seo_url; ?></label>
    					</div>
    					<div class="panel-body">
    						<input id="input-seo-url" class="form-control" name="seo_url" type="text" value="<?php echo $seo_url; ?>" />
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<?php echo $entry_fields; ?>
    					</div>
    					<div class="panel-body">
    						<input id="description" name="html_tags[]" type="checkbox" value="description" checked /><label for="description"><?php echo $entry_description; ?></label><br/>
              				<input id="meta_description" name="html_tags[]" type="checkbox" value="meta_description" checked /><label for="meta_description"><?php echo $entry_meta_descripiton; ?></label><br/>
              				<input id="smp_title" name="html_tags[]" type="checkbox" value="smp_title" checked /><label for="smp_title"><?php echo $entry_smp_title; ?></label><br/>
              				<input id="smp_h1_title" name="html_tags[]" type="checkbox" value="smp_h1_title" checked /><label for="smp_h1_title"><?php echo $entry_smp_h1_title; ?></label><br/>
              				<input id="smp_alt_images" name="html_tags[]" type="checkbox" value="smp_alt_images" checked /><label for="smp_alt_images"><?php echo $entry_smp_alt_images; ?></label><br/>
              				<input id="smp_title_images" name="html_tags[]" type="checkbox" value="smp_title_images" checked /><label for="smp_title_images"><?php echo $entry_smp_title_images; ?></label><br/>
              				<input id="tag" name="html_tags[]" type="checkbox" value="tag" checked /><label for="tag"><?php echo $entry_tag; ?></label><br/>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="languages"><?php echo $entry_language; ?></label>
    					</div>
    					<div class="panel-body">
    						<select id="languages" name="language" class="form-control">
                				<?php foreach ($languages as $language) { ?>
                					<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
                				<?php } ?>
              				</select>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label><?php echo $entry_category; ?></label>
    					</div>
    					<div class="panel-body">
    						<select name="category" class="form-control">
                				<?php foreach ($categories as $category) { ?>
                					<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                				<?php } ?>
              				</select>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="input-exclude"><span data-toggle="tooltip"><?php echo $text_exclude_products; ?></span></label>
    					</div>
    					<div class="panel-body">
    						<input type="text" name="product_exclude" value="" id="input-exclude" class="form-control" />
                  			<div id="product-exclude" class="well well-sm" style="height: 150px; overflow: auto;">
                    		<?php foreach ($product_categories as $product_category) { ?>
                    			<div id="product-exclude<?php echo $product_category['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                      				<input type="hidden" name="product_exclude[]" value="<?php echo $product_category['product_id']; ?>" />
                    			</div>
                    		<?php } ?>
                  			</div>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="subs"><?php echo $entry_subcategories; ?></label>
    					</div>
    					<div class="panel-body">
    						<input id="subs" name="subcategory" type="checkbox" data-toggle="tooltip" title="<?php echo $entry_help_subcategories; ?>" value="" /><label for="subs"></label>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-3">
    				<div class="panel panel-default">
    					<div class="panel-heading">
    						<label for="input-seo-url"><?php echo $entry_submit; ?></label>
    					</div>
    					<div class="panel-body">
    						<a class="btn btn-success update-seo" data-toggle="tooltip" title="<?php echo $entry_submit; ?>"><i class="fa fa-save"></i></a>
              				<a class="btn btn-danger delete-seo" data-toggle="tooltip" title="<?php echo $entry_delete; ?>"><i class="fa fa-trash"></i></a>
    					</div>
    				</div>
    			</div>
    		</div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  function createBackup() {
    $('.warning,.success').remove();
    $.ajax({
      dataType: 'json',
      url : 'index.php?route=extension/module/seo/createBackup&token=<?php echo $token; ?>',
      success: function(json) {
        if (json['error']) {
          $('.heading').after('<div class="warning">' + json['error'] + '</div>');
        }
        if (json['success']) {
          $('.heading').after('<div class="success">' + json['success'] + '</div>');
        }
      }

    });
  }

</script>

<script>
  
$(".update-seo").click(function(e) {   

  var data = {};

  if($('input[name="subcategory"]').is(":checked")){
     data['subcategories'] = 1;
  }else{
     data['subcategories'] = 0;
  }


   data['keyword'] = $('input[name="keyword"]').val();

   data['seo_url'] = $('input[name="seo_url"]').val();

   data['category_id'] = $('select[name="category"] option:selected').val();

   data['language_id'] = $('#languages option:selected').val();

  $('input[name="html_tags[]"]').each(function(){
    if($(this).is(':checked')){
      data[$(this).val()] = 1;
    }
  });

    data['products'] = {};
    $('input[name="product_exclude[]"]').each(function(i){    
      data['products'][i] = $(this).val();     
    });
    
    $.ajax({
      type:'post',
      url: 'index.php?route=extension/module/seo/update_seo&token=<?php echo $token; ?>',
      dataType: 'json',
      data: data,
      success: function(json) { 
        alert(json['warning']);
      },
      failure: function(){
        alert(json['error']);
            }
    });
   e.preventDefault();
});



$(".delete-seo").click(function(e) {   

  var data = {};

  if($('input[name="subcategory"]').is(":checked")){
     data['subcategories'] = 1;
  }else{
     data['subcategories'] = 0;
  }


   data['keyword'] = $('input[name="keyword"]').val();

   data['seo_url'] = $('input[name="seo_url"]').val();

   data['category_id'] = $('select[name="category"] option:selected').val();

   data['language_id'] = $('#languages option:selected').val();

  $('input[name="html_tags[]"]').each(function(){
    if($(this).is(':checked')){
      data[$(this).val()] = 1;
    }
  });

    data['products'] = {};
    $('input[name="product_exclude[]"]').each(function(i){   
      data['products'][i] = $(this).val();     
    });

    $.ajax({
      type:'post',
      url: 'index.php?route=extension/module/seo/delete_seo&token=<?php echo $token; ?>',
      dataType: 'json',
      data: data,
      success: function(json) { 
        alert(json['warning']);
      },
      failure: function(){
        alert(json['error']);
            }
    });
    e.preventDefault();
});


// Category
$('input[name=\'product_exclude\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/seo/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product_exclude\']').val('');

		$('#product-exclude' + item['value']).remove();

		$('#product-exclude').append('<div id="product-exclude' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_exclude[]" value="' + item['value'] + '" /></div>');
	}
});

$('#product-exclude').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

</script>


<?php echo $footer; ?>