<?php

define('RMBULLETIN_LOCATION','about');

include 'header.php';

xoops_cp_header();
rmbMakeNav();

include_once '../include/version.php';

$tpl->assign('rmb_name', $version['name'] . " " . getVersion($version));
$tpl->assign('rmb_desc', _AM_RMB_DESC);
$tpl->assign('rmb_descbig', _AM_RMB_DESCBIG);
$tpl->assign('more_downs', _AM_RMB_DOWNMORE);

echo $tpl->fetch(XOOPS_ROOT_PATH.'/modules/rmbulletin/admin/tpls/rmb_about.html');

echo rmbMakeFooter();
xoops_cp_footer();

?>