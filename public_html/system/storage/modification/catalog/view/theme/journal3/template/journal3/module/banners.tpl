<?php $context = get_defined_vars(); ?>
<?php if (!function_exists('renderBanner')):
  function renderBanner($j3, $context) {

      $ee_tracking = isset($context['ee_tracking']['ee_tracking']) ? $context['ee_tracking']['ee_tracking'] : false;
      $ee_promotion = isset($context['ee_tracking']['ee_promotion']) ? $context['ee_tracking']['ee_promotion'] : false;
      $ee_data = isset($context['ee_tracking']['ee_data']) ? $context['ee_tracking']['ee_data'] : false;

      if ($ee_tracking && $ee_promotion) { ?>
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
                  <?php if ($context['ee_tracking']['ee_promotion_log']) { ?>
                      error: function(xhr, exc, error) {
                          $.post('index.php?route=extension/module/ee_tracking/promotionlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
                              console.log(logs);
                          });
                      }
                  <?php } ?>
              });
              }, <?php echo $context['ee_tracking']['ee_ga_callback'] ? $context['ee_tracking']['ee_ga_callback'] : 0; ?>, <?php echo $context['ee_tracking']['ee_generate_cid'] ? $context['ee_tracking']['ee_generate_cid'] : 0; ?>);
          });
          //--></script>
<?php  }
        
    foreach ($context['items'] as $item): ?>
      <div class="<?php echo $j3->classes($item['classes']); ?>">
        <a <?php if ($item['link']['href']): ?>href="<?php echo $item['link']['href']; ?>" <?php if (isset($ee_tracking) && $ee_tracking && $ee_promotion) { ?>onclick="ee_promotion.click('jbanner-<?php echo isset($item['id']) ? $item['id'] : 0; ?>', '<?php echo isset($item['ee_position']) ? $item['ee_position'] : 0; ?>')"<?php } ?><?php endif; ?> <?php echo $j3->linkAttrs($item['link']); ?>>
          <?php if ($j3->settings->get('performanceLazyLoadImagesStatus') && $context['lazyLoad']): ?>
            <img src="<?php echo $context['dummy_image']; ?>" data-src="<?php echo $item['image']; ?>" <?php if (isset($item['image2x']) && $item['image2x']): ?>data-srcset="<?php echo $item['image']; ?> 1x, <?php echo $item['image2x']; ?> 2x" <?php endif; ?> alt="<?php echo $item['alt']; ?>" width="<?php echo $context['imageDimensions']['width']; ?>" height="<?php echo $context['imageDimensions']['height']; ?>" class="lazyload"/>
          <?php else: ?>
            <img src="<?php echo $item['image']; ?>" <?php if (isset($item['image2x']) && $item['image2x']): ?>srcset="<?php echo $item['image']; ?> 1x, <?php echo $item['image2x']; ?> 2x" <?php endif; ?> alt="<?php echo $item['alt']; ?>" width="<?php echo $context['imageDimensions']['width']; ?>" height="<?php echo $context['imageDimensions']['height']; ?>"/>
          <?php endif; ?>
          <?php if ($item['title']): ?>
          <div class="banner-text banner-caption"><span><?php echo $item['title']; ?></span></div>
          <?php endif; ?>
          <?php if ($item['title2']): ?>
          <div class="banner-text banner-caption-2"><span><?php echo $item['title2']; ?></span></div>
          <?php endif; ?>
        </a>
      <?php if ($item['title3']): ?>
      <div class="banner-caption-3"><span><?php echo $item['title3']; ?></span></div>
      <?php endif; ?>
    </div>
    <?php endforeach;
  }
endif; ?>

<div id="<?php echo $id; ?>" class="<?php echo $j3->classes($classes); ?>">
  <?php if ($title): ?>
    <h3 class="title module-title"><?php echo $title; ?></h3>
  <?php endif; ?>
  <div class="module-body">
    <?php /* grid */ ?>
    <?php if (!$carousel): ?>
      <?php renderBanner($j3, $context); ?>
    <?php endif; ?>
    <?php /* grid + carousel */ ?>
    <?php if ($carousel): ?>
      <div class="swiper" data-items-per-row='<?php echo json_encode($itemsPerRow, JSON_FORCE_OBJECT); ?>' data-options='<?php echo json_encode($carouselOptions, JSON_FORCE_OBJECT); ?>'>
        <div class="swiper-container" <?php if ($j3->isRTL()): ?>dir="rtl"<?php endif; ?>>
          <div class="swiper-wrapper">
            <?php renderBanner($j3, $context); ?>
          </div>
        </div>
        <div class="swiper-buttons">
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    <?php endif; ?>
  </div>
</div>
