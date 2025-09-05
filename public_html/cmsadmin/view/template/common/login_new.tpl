<?php echo $header; ?>
<div id="content">
  <div class="row">
    <div class="col-sm-6 col-md-7 col-lg-8 hidden-xs icop-info"></div>
      <div class="col-sm-6 col-md-5 col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-lock"></i> <?php echo $text_login; ?></h1>
          </div>
          <div class="panel-body">
            <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <!-- <label for="input-username"><?php echo $entry_username; ?></label> -->
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <!-- <label for="input-password"><?php echo $entry_password; ?></label> -->
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                </div>
                <?php if ($forgotten) { ?>
                <span class="help-block"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></span>
                <?php } ?>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-block" id="btn-login"><i class="fa fa-key"></i> <?php echo $button_login; ?></button>
              </div>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<?php echo $footer; ?>