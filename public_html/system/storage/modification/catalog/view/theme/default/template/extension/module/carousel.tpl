
<?php if (isset($ee_tracking) && $ee_tracking && isset($ee_promotion) && $ee_promotion) { ?>
<script type="text/javascript"><!--
	$(document).ready(function() {
		setIntervalEE(function() {
			var ee_data = JSON.parse('<?php echo $ee_data; ?>');
			ee_data['url'] = window.location.href;
			ee_data['title'] = document.title;
			$.ajax({
				url: 'index.php?route=extension/module/ee_tracking/promotion',
				type: 'post',
				data: ee_data,
				dataType: 'json',
				success: function(json) {
					if (json) {
						console.log(json);
					}
				},
			<?php if ($ee_promotion_log) { ?>
				error: function(xhr, exc, error) {
					$.post('index.php?route=extension/module/ee_tracking/promotionlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
						console.log(logs);
					});
				}
			<?php } ?>
		});
		}, <?php echo $ee_ga_callback ? $ee_ga_callback : 0; ?>, <?php echo $ee_generate_cid ? $ee_generate_cid : 0; ?>);
	});
	//--></script>
<?php } ?>
            
<div id="carousel<?php echo $module; ?>" class="owl-carousel">
  <?php foreach ($banners as $banner) { ?>
  <div class="item text-center">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>" <?php if (isset($ee_tracking) && $ee_tracking && $ee_promotion) { ?>onclick="ee_promotion.click('<?php echo isset($banner['ee_banner_id']) ? $banner['ee_banner_id'] : ''; ?>', '<?php echo isset($banner['ee_position']) ? $banner['ee_position'] : ''; ?>')"<?php } ?>><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});
--></script>