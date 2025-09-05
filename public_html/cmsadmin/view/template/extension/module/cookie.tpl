<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cookie" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cookie" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-fa">Google Analyticts</label>
            <div class="col-sm-10">
              <?php if (isset($stats['ga'])): ?>
                <input type="checkbox" name="cookie_stats[ga]" value="Google" checked>
              <?php else: ?>
                <input type="checkbox" name="cookie_stats[ga]" value="Google">
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-st">Share This</label>
            <div class="col-sm-10">
              <?php if (isset($stats['st'])): ?>
              <input type="checkbox" name="cookie_stats[st]" value="Sharethis" checked>
              <?php else: ?>
              <input type="checkbox" name="cookie_stats[st]" value="Sharethis">
            <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-fp">Facebook Pixel</label>
            <div class="col-sm-10">
              <?php if (isset($stats['fp'])): ?>
              <input type="checkbox" name="cookie_stats[fp]" value="Facebook" checked>
              <?php else: ?>
              <input type="checkbox" name="cookie_stats[fp]" value="Facebook">
            <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-gm">Google Marketing</label>
            <div class="col-sm-10">
             <?php if (isset($marketing['gm'])): ?>
              <input type="checkbox" name="cookie_marketing[gm]" value="Google" checked>
              <?php else: ?>
              <input type="checkbox" name="cookie_marketing[gm]" value="Google">
            <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sa">Skroutz Analyticts</label>
            <div class="col-sm-10">
               <?php if (isset($marketing['sa'])): ?>
              <input type="checkbox" name="cookie_marketing[sa]" value="Skroutz" checked>
              <?php else: ?>
              <input type="checkbox" name="cookie_marketing[sa]" value="Skroutz">
            <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-fm">Facebook Marketing</label>
            <div class="col-sm-10">
              <?php if (isset($marketing['fm'])): ?>
              <input type="checkbox" name="cookie_marketing[fm]" value="Facebook" checked>
              <?php else: ?>
              <input type="checkbox" name="cookie_marketing[fm]" value="Facebook">
            <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label" for="input-cookie">Cookie Small Text</label>
          <div class="col-sm-4">
            <select name="cookie_small_text" id="input-cookie" class="form-control">
              <option value="0">Κανένα</option>
              <?php foreach ($informations as $information) { ?>
              <?php if ($information['information_id'] == $small_text) { ?>
                <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>