<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $category_mgr_heading_title; ?></h1>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $category_mgr_heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <div id="left-pane-toolbar" style="height: 40px; width: 100%; padding-right: 6px;">
                            <button id="btnCategoryEdit" onclick="onCategoryEdit(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_edit; ?>"><i class="fa fa-pencil"></i></button>
                            <button id="btnCategoryAdd" onclick="onCategoryAdd(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_add; ?>"><i class="fa fa-plus"></i></button>
                            <button id="btnCategoryDelete" onclick="onCategoryDelete(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_delete; ?>"><i class="fa fa-trash-o"></i></button>
                            <button onclick="onCollapseTree(); return false;" type="button" style="float: right;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_collapse; ?>"><i class="fa fa-angle-double-up"></i></button>
                            <button onclick="onExpandTree(); return false;" type="button" style="float: right; margin-right: 6px;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_expand; ?>"><i class="fa fa-angle-double-down"></i></button>
                        </div>
                        <div id="jstree"></div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
const MIN_W = 640;
const MIN_H = 480

$(function () {
    window.j = $.noConflict(true);

    window.j('#jstree')
            .jstree({
                'core' : {
                    'check_callback' : function(operation, node, node_parent, node_position, more) {
                        if (operation === 'move_node') {
                            return false;
                        }
                    },
                    'multiple' : false,
                    'data' : {
                        'url' : 'index.php?route=catalog/category_mgr_lite/tree&token=<?php echo $token; ?>',
                        'data' : function (node) {
                            return { 'id' : node.id, 'operation' : 'get_node' };
                        }
                    }},
                'plugins' : ['wholerow']
            }
    )
            .on('refresh.jstree', function () {
                window.j('#jstree').jstree("rename_node", "0", "<?php echo $text_category; ?>");
                if (window.open_node) {
                    window.open_node = false;
                    var selectedNode = window.j('#jstree').jstree(true).get_selected(false);
                    if (selectedNode.length == 1)
                        window.j('#jstree').jstree("open_node", selectedNode);
                }
            })
            .on('ready.jstree', function () {
                window.j('#jstree').jstree("open_node", "0");
                window.j('#jstree').jstree("rename_node", "0", "<?php echo $text_category; ?>");
                window.j('#jstree').jstree("select_node", "0");
            })
            .on("changed.jstree", function (e, data) {

                var obj = null;
                var root = true;
                if (data.node !== undefined) {
                    obj = data.node.data;
                    root = data.node.id == "0";
                }
                checkUIState(obj, data.selected.length, root);
            })
    ;

    var selectedNode = window.j('#jstree').jstree(true).get_selected(false);
    checkUIState(null, selectedNode.length, true);

});

$(window).resize(function () {
    window.j('#products-table').bootstrapTable('resetView');
});


function rowStyle(row, index) {
    if (row.status == "0")
        return {
            classes: 'active'
        };
    return {
        classes: ''
    };
}

function closeCategoryDlg(ok) {
    window.j('#dialog').dialog('close');
    if (ok) {
        window.open_node = true;
        window.j('#jstree').jstree("refresh");
    }
}


function onExpandTree() {
    window.j('#jstree').jstree("open_all");
}

function onCollapseTree() {
    window.j('#jstree').jstree("close_all");
}

function onCategoryEdit() {
    var selectedNode= window.j('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1) {
        doCategoryEdit(selectedNode);
    }
}

function onCategoryAdd() {
    doLaunchModalController('index.php?route=catalog/category/add&token=<?php echo $token; ?>', 0, '');
}

function onCategoryDelete() {
    var selectedNode= window.j('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1 && selectedNode != 0) {
        confirm('Are you sure?') ? doCategoryDelete(selectedNode) : false;
    }
}


function setButtonState(selector, state) {
    if (state) {
        window.j(selector).removeClass('disabled').addClass('active');
    }
    else {
        window.j(selector).removeClass('active').addClass('disabled');
    }
}
function checkUIState(data, selectedCount, root) {
    if (root) {
        setButtonState('#btnCategoryEdit', false);
        setButtonState('#btnCategoryDelete', false);
        return;
    }
    var status = 0;
    if (data != null)
        status = parseInt(data.status);
    setButtonState('#btnCategoryEdit', selectedCount == 1);
    setButtonState('#btnCategoryDelete', selectedCount == 1);
}

function htmlDecode(value){
    if (value) {
        return jQuery('<div/>').html(value).text();
    } else {
        return '';
    }
}
function doLaunchModalController(url) {
    var window_w = window.j(window).width();
    var window_h = window.j(window).height();
    var h = Math.max(window_h * 3 / 4, MIN_H) | 0;
    var w = Math.max(window_w * 3 / 4, MIN_W) | 0;

    window.j('#dialog').remove();
    window.j('#content').append('<div id="dialog" style="background:gray; padding:10px;"><iframe id="categoryFormIframe" src="'+url+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="yes" scrolling="auto"></iframe></div>');
    window.j('#dialog').dialog({
        title: '',
        width: w,
        height: h,
        resizable: true,
        modal: true
    });
    window.j(".ui-dialog").css("z-index", "3000");
    window.j('#categoryFormIframe').load(function() {
        var cnt = window.j('#categoryFormIframe').contents();
        var saved = cnt.find('div.alert.alert-success').length;
        if (!saved) {
            cnt.find('.breadcrumb').hide();
            cnt.find('#footer').hide();
            cnt.find('#header').hide();
            cnt.find('#column-left').remove();
            var cancel = cnt.find('a[href*="catalog/category"');
            cancel.removeAttr("href");
            cancel.click(function(){ parent.closeCategoryDlg(0); });
        }
        else {
            parent.closeCategoryDlg(1);
        }

    })
}

function doCategoryEdit(category_id) {
    doLaunchModalController('index.php?route=catalog/category/edit&category_id='+category_id+'&token=<?php echo $token; ?>', 0, '');
}

function doCategoryDelete(category_id) {
    var this_url = 'index.php?route=catalog/category_mgr_lite/delete&category_id='+category_id+'&token=<?php echo $token; ?>';
    $.get( this_url, function( data ) {
       window.location = 'index.php?route=catalog/category_mgr_lite&token=<?php echo $token; ?>';
    });
}

</script>

<?php echo $footer; ?>