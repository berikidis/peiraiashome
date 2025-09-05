<div class="cookie-info">
	<span ><?php echo $text_cookie; ?></span>
	<a class="button" data-toggle="modal" data-target="#cookieModal"><?php echo $button_settings; ?></a>
	<a class="button" onclick="acceptCookie()"><?php echo $button_accept; ?></a>
</div>
<div id="cookieModal" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
		    <div class="box-heading"><?php echo $heading_title; ?></div>
		  </div>
		  <div class="modal-body">
		   	<div id="tabs" class="vtabs">
		   		<a class="active" href="#tab-cookie-1"><?php echo $text_about_cookies; ?></a>
		   		<a href="#tab-cookie-2"><?php echo $text_our_cookies; ?></a>
		   		<?php if ($stats): ?>
		   			<a href="#tab-cookie-3"><?php echo $text_stats_cookies; ?></a>
		   		<?php endif; ?>
		   		<?php if($marketing): ?>
		   			<a href="#tab-cookie-4"><?php echo $text_marketing_cookies; ?></a>
		   		<?php endif; ?>
		   		<a href="#tab-cookie-5"><?php echo $text_disable_cookies; ?></a>
		   	</div>
		   	<div id="tab-cookie-1" class="vtabs-content active">
		   		<?php echo $description; ?>
		   	</div>
		   	<div id="tab-cookie-2" class="vtabs-content">
		   		<table>
		   			<tr>
		   				<th><?php echo $column_name; ?></th>
		   				<th><?php echo $column_description; ?></th>
		   				<th><?php echo $column_type; ?></th>
		   				<th><?php echo $column_admin; ?></th>
		   			</tr>
		   			<?php foreach ($cookies as $key => $cookie) { ?>
		   			<tr>
		   				<td><?php echo $key; ?></td>
		   				<td><?php echo $cd[$key]; ?></td>
		   				<td><?php echo $text_type_one; ?></td>
		   				<td><?php echo $text_admin_we; ?></td>
		   			</tr>
		   			<?php } ?>
		   		</table>
		   	</div>
		   	<?php if($stats): ?>
		   	<div id="tab-cookie-3" class="vtabs-content">
		   		<table>
		   			<tr>
		   				<th><?php echo $column_description; ?></th>
		   				<th><?php echo $column_type; ?></th>
		   				<th><?php echo $column_admin; ?></th>
		   			</tr>
		   				<?php foreach ($stats as $key => $stat) { ?>
		   			<tr>
		   				<td><?php echo $cd[$key]; ?></td>
		   				<td><?php echo $text_type_three; ?></td>
		   				<td><?php echo $stat; ?></td>
		   			</tr>
		   				<?php } ?>
		   		</table>
		   	</div>
		   <?php endif; ?>
		   <?php if($marketing): ?>
		   	<div id="tab-cookie-4" class="vtabs-content">
		   		<table>
		   			<tr>
		   				<th><?php echo $column_description; ?></th>
		   				<th><?php echo $column_type; ?></th>
		   				<th><?php echo $column_admin; ?></th>
		   			</tr>
		   				<?php foreach ($marketing as $key => $mark) { ?>
		   			<tr>
		   				<td><?php echo $cd[$key]; ?></td>
		   				<td><?php echo $text_type_three; ?></td>
		   				<td><?php echo $mark; ?></td>
		   			</tr>
		   				<?php } ?>
		   		</table>
		   	</div>
		   	<?php endif; ?>
		   	<div id="tab-cookie-5" class="vtabs-content active">
		   		<?php echo $text_disable; ?>
		   	</div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $button_close; ?></button>
		  </div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('#tabs a').tabs();
$(document).ready(function(){
	if (navigator.cookieEnabled) {
	$('.cookie-info').fadeIn('slow');
	}
});

function acceptCookie() {
	$.ajax({
		url: 'index.php?route=extension/module/cookie/acceptCookie',
		success: function() {
			$('.cookie-info').fadeOut('slow');
		}
	});
}
</script>

