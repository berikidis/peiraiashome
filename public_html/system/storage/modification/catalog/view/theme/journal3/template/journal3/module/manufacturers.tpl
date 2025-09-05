<?php $context = get_defined_vars(); ?>
<?php if (!function_exists('renderManufacturers')):
  function renderManufacturers($j3, $item, $context) {
    $context['manufacturers'] = $item['manufacturers'];

    $ee_tracking = isset($item['ee_tracking']['ee_tracking']) ? $item['ee_tracking']['ee_tracking'] : false;
    $ee_promotion = isset($item['ee_tracking']['ee_promotion']) ? $item['ee_tracking']['ee_promotion'] : false;
    $ee_data = isset($item['ee_tracking']['ee_data']) ? $item['ee_tracking']['ee_data'] : false;

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
            <?php if ($item['ee_tracking']['ee_promotion_log']) { ?>
                error: function(xhr, exc, error) {
                    $.post('index.php?route=extension/module/ee_tracking/promotionlog', { 'error': error + ' (exc: ' + exc + ' status: ' + xhr.statusText + ')', 'url': window.location.href }, function( logs ) {
                        console.log(logs);
                    });
                }
            <?php } ?>
        });
        }, <?php echo $item['ee_tracking']['ee_ga_callback'] ? $item['ee_tracking']['ee_ga_callback'] : 0; ?>, <?php echo $item['ee_tracking']['ee_generate_cid'] ? $item['ee_tracking']['ee_generate_cid'] : 0; ?>);
    });
    //--></script>
<?php }
        
    if ($context['carousel']): ?>
      <div class="swiper" data-items-per-row='<?php echo json_encode($context['itemsPerRow'], JSON_FORCE_OBJECT); ?>' data-options='<?php echo json_encode($context['carouselOptions'], JSON_FORCE_OBJECT); ?>'>
        <div class="swiper-container" <?php if ($j3->isRTL()): ?>dir="rtl"<?php endif; ?>>
          <div class="swiper-wrapper manufacturer-grid">
            <?php extract($context);
            include $j3->incl('journal3/manufacturer_grid.tpl'); ?>
          </div>
        </div>
        <div class="swiper-buttons">
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    <?php else: ?>
      <div class="manufacturer-grid">
        <?php extract($context);
        include $j3->incl('journal3/manufacturer_grid.tpl'); ?>
      </div>
    <?php endif;
  }
endif; ?>
<div class="<?php echo $j3->classes($classes); ?>">
  <div class="module-body">
    <?php /* grid */; ?>
    <?php if ($sectionsDisplay == 'blocks'): ?>
      <?php foreach ($items as $item): ?>
        <div class="<?php echo $j3->classes($item['classes']); ?>">
          <?php if ($item['title']): ?>
            <h3 class="title module-title"><?php echo $item['title']; ?></h3>
          <?php endif; ?>
          <?php renderManufacturers($j3, $item, $context); ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php /* tabs */; ?>
    <?php if ($sectionsDisplay == 'tabs'): ?>
      <ul class="nav nav-tabs">
        <?php $index = 1;
        foreach ($items as $item): ?>
          <li class="<?php echo $j3->classes($item['tab_classes']); ?>">
            <a href="#<?php echo $id; ?>-tab-<?php echo $index++; ?>" data-toggle="tab"><?php echo $item['title']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="tab-content">
        <?php $index = 1;
        foreach ($items as $item): ?>
          <div class="<?php echo $j3->classes($item['classes']); ?>" id="<?php echo $id; ?>-tab-<?php echo $index++; ?>">
            <?php renderManufacturers($j3, $item, $context); ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php /* accordion */; ?>
    <?php if ($sectionsDisplay == 'accordion'): ?>
      <div class="panel-group" id="<?php echo $id; ?>-collapse">
        <?php $index = 0;
        foreach ($items as $item): ?>
          <div class="<?php echo $j3->classes($item['classes']); ?>">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a href="#<?php echo $id; ?>-collapse-<?php echo $index; ?>" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#<?php echo $id; ?>-collapse" aria-expanded="false">
                  <?php echo $item['title']; ?>
                  <i class="fa fa-caret-down"></i>
                </a>
              </h4>
            </div>
            <div class="<?php echo $j3->classes($item['panel_classes']); ?>" id="<?php echo $id; ?>-collapse-<?php echo $index; ?>">
              <div class="panel-body">
                <?php renderManufacturers($j3, $item, $context); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php /* isotope */; ?>
    <?php if ($sectionsDisplay == 'isotope'): ?>
      <ul class="nav nav-tabs">
        <?php $index = 1;
        foreach ($items as $item): ?>
          <li class="<?php echo $j3->classes($item['tab_classes']); ?>">
            <a data-filter=".<?php echo $id; ?>-section-<?php echo $index++; ?>"><?php echo $item['title']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="manufacturer-<?php echo $sectionsDisplay; ?> isotope-grid">
        <?php extract($context);
        include $j3->incl('journal3/manufacturer_grid.tpl'); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
