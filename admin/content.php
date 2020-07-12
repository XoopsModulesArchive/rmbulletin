<?php

function addContent(){
	global $plug, $idbol;
	
	$pHand = new RMBPluginHandler($plug);
	if (!$pHand->installed()){
		redirect_header('bulletins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();
	}
	
	xoops_cp_header();
	rmbMakeNav();
	
	$boletin = new RMBulletin($idbol);
	$form = new RMForm(_AM_RMB_NEWCONTENTTITLE, 'frmContent', 'bulletins.php');
	$plugin = $pHand->getPlugin();
	$plugin->newContent($form);
	
	$form->addElement(new RMHidden('op','content'));
	$form->addElement(new RMHidden('acc','savecontent'));
	$form->addElement(new RMHidden('plug',$plug));
	$form->addElement(new RMHidden('id',$idbol));
	
	$sections = $boletin->getSections();
	$ele = new RMSelect(_AM_RMB_SELECTSECTION, 'section');
	foreach ($sections as $k){
		$ele->addOption($k['id_sec'], $k['titulo'], 0);
	}
	$form->addElement($ele);
	$form->addElement(new RMButton('sbt',_SUBMIT));
	
	$form->display();
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function saveContent(){
	global $plug, $idbol;
	
	$pHand = new RMBPluginHandler($plug);
	if (!$pHand->installed()){
		redirect_header('bulletins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();
	}
	
	$boletin = new RMBulletin($idbol);
	$plugin = $pHand->getPlugin();
	
	if (!$GLOBALS['xoopsSecurity']->validateToken()){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMBS_ERRSESS);
		die();
	}
	
	$items = $plugin->saveData();
	
	if (!$items){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMB_DBERROR . "<br />" . $plugin->errors());
		die();
	}
	
	$section = isset($_POST['section']) ? $_POST['section'] : 0;
	
	foreach ($items as $k){
		$boletin->addItem($k,$plug,$section);
	}
	
	if ($boletin->errors()!=''){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMB_DBERROR . "<br>" . $boletin->errors());	
	} else {
		redirect_header('bulletins.php?id='.$idbol, 1, _AM_RMB_DBOK);	
	}

}

function editContent(){
	global $plug, $idbol;
	
	$pHand = new RMBPluginHandler($plug);
	if (!$pHand->installed()){
		redirect_header('bulletins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();
	}
	
	$iditem = isset($_REQUEST['item']) ? $_REQUEST['item'] : 0;
	if ($iditem<=0){
		header('location: bulletins.php?id='.$idbol);
		die();
	}
	xoops_cp_header();
	rmbMakeNav();
	
	$boletin = new RMBulletin($idbol);
	$form = new RMForm(_AM_RMB_EDITCONTENTTITLE, 'frmContent', 'bulletins.php');
	
	$plugin = $pHand->getPlugin();
	$item = $boletin->getItem($iditem);
	$plugin->editContent($form,$item['params']);
	
	$form->addElement(new RMHidden('op','content'));
	$form->addElement(new RMHidden('acc','saveedited'));
	$form->addElement(new RMHidden('plug',$plug));
	$form->addElement(new RMHidden('id',$idbol));
	$form->addElement(new RMHidden('item',$iditem));
	
	$sections = $boletin->getSections();
	$ele = new RMSelect(_AM_RMB_SELECTSECTION, 'section');
	foreach ($sections as $k){
		$ele->addOption($k['id_sec'], $k['titulo'], $item['section']==$k['id_sec'] ? 1 : 0);
	}
	$form->addElement($ele);
	$form->addElement(new RMButton('sbt',_SUBMIT));
	$form->display();
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function saveEdited(){
	global $plug, $idbol;
	
	$pHand = new RMBPluginHandler($plug);
	if (!$pHand->installed()){
		redirect_header('bulletins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();
	}
	
	$boletin = new RMBulletin($idbol);
	$plugin = $pHand->getPlugin();
	
	if (!$GLOBALS['xoopsSecurity']->validateToken()){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMBS_ERRSESS);
		die();
	}
	
	$data = $plugin->editData();
	
	if (!$data){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMB_DBERROR . "<br>" . $plugin->errors());	
		die();
	}
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if (!$boletin->editItem($item,$data,$section,$plug)){
		redirect_header('bulletins.php?id='.$idbol, 2, _AM_RMB_DBERROR . "<br>" . $boletin->errors());	
	} else {
		redirect_header('bulletins.php?id='.$idbol, 1, _AM_RMB_DBOK);	
	}
}

$acc = isset($_REQUEST['acc']) ? $_REQUEST['acc'] : '';
$plug = isset($_REQUEST['plug']) ? $_REQUEST['plug'] : '';
$idbol = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

switch ($acc){
	case 'savecontent':
		saveContent();
		break;
	case 'edit':
		editContent();
		break;
	case 'saveedited':
		saveEdited();
		break;
	default:
		addContent();
		break;
}

?>