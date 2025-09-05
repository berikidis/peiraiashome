<?php echo $header; ?>
<?php if (isset($column_left)): ?>
<?php echo $column_left; ?>
<?php endif; ?>
<?php if (!version_compare(VERSION, '2', '>=')): ?>
<?php if ($success) { ?>
    <div class="success" style="margin-bottom: 0px;"><?php echo $success; ?></div>
    <script>
        setTimeout(function () {
            $('.success').slideUp();
        }, 2000);
    </script>
<?php } ?>
<?php if ($warning) { ?>
<div class="warning" style="margin-bottom: 0px;"><?php echo $warning; ?></div>
<script>
    setTimeout(function () {
        $('.warning').slideUp();
    }, 2000);
</script>
<?php } ?>
<?php endif; ?>
<div id="content" class="journal-content <?php echo version_compare(VERSION, '2', '>=') ? 'oc2' : ''; ?>" data-ng-controller="MainController">
<?php if (version_compare(VERSION, '2', '>=')): ?>
    <?php if ($success) { ?>
    <div class="alert alert-success" style="margin-bottom:0;"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
<?php endif; ?>
<div class="dummy-bg"> </div> 
<nav>
    <div class="sticky">
        <a class="set-menu" href="<?php echo $base_href;?>#/home"><div class="logo">Theme</div></a>
    </div>
    <ul id="nav">
        <li class="divider">Control Panel</li>
        <?php foreach ($results as $key => $value) { ?>
            <li><a href="<?php echo $base_href;?>#/<?php echo $key; ?>"><?php echo $value; ?></a></li>
        <?php } ?>
    </ul>
</nav>

<div class="dummy-module-header"></div>

<div class="journal-loading"><span>Loading...</span></div>
<div class="border-top"> </div>
<div class="journal-body" id="journal-body" data-ng-view>
<div></div>
</div>

<div style="clear: both"></div>

</div>

<script>
    var Journal2Config = $.parseJSON('<?php echo addslashes(json_encode($journal2_config)); ?>');
</script>

<?php if(defined('J2ENV') && J2ENV === 'development'): ?>
<script src="view/journal2/lib/require/require.js?<?php echo JOURNAL_VERSION; ?>" data-main="view/journal2/js/main.js?<?php echo JOURNAL_VERSION; ?>"></script>
<?php else: ?>
<script src="view/journal2/lib/require/require.js?<?php echo JOURNAL_VERSION; ?>"></script>
<script src="view/journal2/journal.js?<?php echo JOURNAL_VERSION; ?>"></script>
<?php endif; ?>

<?php if (version_compare(VERSION, '2', '>=')): ?>
<script>$('html').addClass('oc2');</script>
<?php endif; ?>

<?php if (version_compare(VERSION, '3', '>=')): ?>
<script>$('html').addClass('oc3');</script>
<?php endif; ?>

<script type="text/javascript">
        $(document).ready(function(){
        $('#nav').css({'height':$(window).height(), 'background-color':'#4a4c58'});
    });

</script>

<?php echo $footer; ?>

