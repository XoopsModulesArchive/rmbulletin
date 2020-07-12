<?php
// $Id: index.php,v 0.5 29/11/2006 14:06 BitC3R0 Exp $  //
// -------------------------------------------------------------  //
// RMSOFT Bulletin 1.0                                            //
// Boletín Informativo Avanzado                                   //
// CopyRight © 2006. Red México Soft                              //
// Autor: BitC3R0                                                 //
// http://www.redmexico.com.mx                                    //
// http://www.xoops-mexico.net                                    //
// --------------------------------------------                   //
// This program is free software; you can redistribute it and/or  //
// modify it under the terms of the GNU General Public License as //
// published by the Free Software Foundation; either version 2 of //
// the License, or (at your option) any later version.            //
//                                                                //
// This program is distributed in the hope that it will be useful,//
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the   //
// GNU General Public License for more details.                   //
//                                                                //
// You should have received a copy of the GNU General Public      //
// License along with this program; if not, write to the Free     //
// Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, //
// MA 02111-1307 USA                                              //
// -------------------------------------------------------------  //
// @copyright: © 2006. BitC3R0.                                   //
// @author: BitC3R0                                               //
// @package: RMSOFT Bulletin 1.0                                  //
// @version: 0.5	                                              //

define('RMBULLETIN_LOCATION','index');

include 'header.php';

deleteBols();
/**
 * Muestra el estado del módulo
 */
function showState(){
	global $tpl;
	$db =& Database::getInstance();
	xoops_cp_header();
	rmbMakeNav();
	
	$tpl->assign('lang_currstate', _AM_RMB_CURSTATE);
	$tpl->assign('lang_useconfig', _AM_RMB_CONFIGUSE);
	
	// Creamos el menu de estado
	$menu = new RMMenu();

	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_boletines")." WHERE sended='0'"));
	$menu->addItem('boles', 'index.php?op=show', '../images/bolsbig.png', sprintf(_AM_RMB_BOLSCOUNT, $num), _AM_RMB_SEEDETAILS);
	
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_boletines")." WHERE sended='1'"));
	$menu->addItem('bolsent', 'sended.php', '../images/sentbig.png', sprintf(_AM_RMB_SENTCOUNT, $num), _AM_RMB_SEEDETAILS);
	
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_users")));
	$menu->addItem('users', 'users.php', '../images/usersbig.png', sprintf(_AM_RMB_USERSCOUNT, $num), _AM_RMB_SEEDETAILS);
	
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_emails")));
	$menu->addItem('email', 'email.php', '../images/emailbig.png', sprintf(_AM_RMB_EMAILCOUNT, $num), _AM_RMB_SEEDETAILS);
	
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_plugins")));
	$menu->addItem('plug', 'plugins.php', '../images/plugbig.png', sprintf(_AM_RMB_PLUGSCOUNT, $num), _AM_RMB_SEEDETAILS);
	
	$menu->addItem('about', 'about.php', '../images/icon_big.png', _AM_RMB_ABOUTMOD, _AM_RMB_INFO);
	$menu->addItem('xm', 'http://www.xoopsmexico.net', '../images/xmex.png', "XOOPS México", _AM_RMAD_VISIT);
	$menu->addItem('rm', 'http://www.redmexico.com.mx', '../images/redmexbig.png', "Red México", _AM_RMAD_VISIT);
	$menu->addItem('dona', 'http://www.xoopsmexico.net/links.php?link=rmshopdonations', '../images/donar.png', "Donaciones", '', _AM_RMB_HELUPS);
	
	$tpl->assign('menu_css', $menu->getCSS());
	$tpl->assign('menu', $menu->render());
	
	include_once('../include/version.php');
	
	$tpl->assign('lang_running', sprintf(_AM_RMB_RUNNING, $version['name'], getVersion($version)));
	
	echo $tpl->fetch(XOOPS_ROOT_PATH.'/modules/rmbulletin/admin/tpls/rmb_index.html');
	
	xoops_cp_footer();
	
	
}
/**
 * Muestra lso boletines existentes que no han sido enviados
 */
function rmbShowBulletins($edit = 0){
	global $db, $mc;
	
	xoops_cp_header();
	rmbMakeNav();
	$table = new RMTable(true);
	$table->setTableClass('outer');
	$table->openTbl();
	$table->openRow();
	$table->addCell(_AM_RMB_BOLSTITLE,1,4);
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_boletines")." WHERE sended='0' ORDER BY fecha DESC LIMIT 0,20");
	$table->closeRow();
	$table->setRowClass('head');
	$table->openRow();
		$table->addCell(_AM_RMB_TITLE,0,'',$align='center');
		$table->addCell(_AM_RMB_CREATED,0,'',$align='center');
		$table->addCell(_AM_RMB_DELETAFTER,0,'',$align='center');
		$table->addCell(_AM_RMB_OPTIONS,0,'',$align='center');
	$table->closeRow();
	$table->setRowClass('even,odd', true);
	while ($row = $db->fetchArray($result)){
		$table->openRow();
		$table->addCell($row['titulo']);
		$table->addCell(date($mc['format_date'],$row['fecha']),0,'','center');
		$table->addCell($row['eliminar']==1 ? _YES : _NO,0,'','center');
		$table->addCell("<a href='?op=edit&amp;id=$row[id_bol]#form'>"._EDIT."</a> &bull; 
		<a href='?op=del&amp;id=$row[id_bol]'>"._DELETE."</a> &bull;
		<a href='?op=sections&amp;bol=$row[id_bol]'>"._AM_RMB_SECTIONS."</a> &bull; 
		<a href='bulletins.php?id=$row[id_bol]'>"._AM_RMB_CONTENT."</a> &bull;
		<a href='bulletins.php?op=preview&amp;id=$row[id_bol]' target='_blank'>"._AM_RMB_PREVIEW."</a> &bull;
		<a href='bulletins.php?op=send&amp;id=$row[id_bol]'>"._AM_RMB_SEND."</a>",0,'','center');
		$table->closeRow();
	}
	
	$table->closeRow();
	$table->closeTbl();
	$table = null;
	
	echo "<br /><a name='form'></a>";
	
	$boletin = new RMBulletin();
	
	if ($edit){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id>0){
			$boletin = new RMBulletin($id);
		}
	}
	
	$form = new RMForm($edit == 1 ? sprintf(_AM_RMB_EDITTITLE, $boletin->getVar('titulo')) : _AM_RMB_NEWTITLE, 'frmNew', 'index.php', 'post');
	$form->addElement(new RMText(_AM_RMB_FTITLE, 'titulo', 50, 255, $edit == 1 ? $boletin->getVar('titulo') : ''), true);
	$form->addElement(new RMEditor(_AM_RMB_FINTRO, 'intro', '100%','300px', $edit == 1 ? $boletin->getVar('introduccion') : '', $mc['editor']), true);
	
	$ele = new RMCheck('');
	$ele->addOption(_AM_RMB_DELAFTER, 'eliminar', 1, 0);
	$form->addElement($ele);
	
	// Fecha de eliminación
	$ele = new RMDate(_AM_RMB_DELDATE, 'fechaeliminar', $edit == 1 ? $boletin->getVar('eliminar') : time() + (30 * 86400));
	$ele->showDay('d',_AM_RMB_DAY);
	$ele->showMonth('F',_AM_RMB_MONTH);
	$ele->showYear(_AM_RMB_YEAR, date("Y", time()), date("Y", time()) + 10);
	$ele->showHour(_AM_RMB_HOUR,'H');
	$ele->showMinute(_AM_RMB_MINUTE,'i');
	$ele->showSecond(_AM_RMB_SECOND,'s');
	$ele->setDescription(_AM_RMB_DELDATE_DESC);
	$form->addElement($ele);
	$form->addElement(new RMHidden('op',$edit == 1 ? 'saveedit' : 'save'));
	if ($edit){
		$form->addElement(new RMHidden('id',$boletin->getVar('id_bol')));
	}	
	
	$ele = new RMSelect(_AM_RMB_TEMPLATE,'plantilla');
	$odir = @opendir(XOOPS_ROOT_PATH.'/modules/rmbulletin/mytpls');
	while ($obj = readdir($odir)){
		if ($obj=='.' || $obj=='..') continue;
		if (file_exists(XOOPS_ROOT_PATH.'/modules/rmbulletin/mytpls/'.$obj.'/boletin.html')){
			$ele->addOption($obj, $obj, $edit == 1 ? ($obj == $boletin->getTemplate() ? 1 : 0) : 0);
		}
	}
	
	$form->addElement($ele, true, 'Select: ');
	$form->addElement(new RMLabel('',"<a href='http://www.temasweb.com' target='_blank' style='font-size: 11px; font-weight: normal;'>"._AM_RMB_MORETPLS."</a>"));
	$form->addElement(new RMButton('sbt', _SUBMIT));
	$form->display();
	
	echo rmbMakeFooter();
	
	xoops_cp_footer();
	
}

function rmbSave(){
	global $db, $mc;
	
	$eliminar = 0;
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	$fechaeliminar = rmsoft_read_date('fechaeliminar');
	
	$boletin = new RMBulletin();
	if (!$boletin->setTitulo($titulo)){
		redirect_header('index.php?op=show', 1, _AM_RMB_NOTITLE);
		die();
	}
	
	$boletin->setIntro($intro);
	$boletin->setEliminar($eliminar);
	$boletin->setEliminacion($fechaeliminar);
	$boletin->setTemplate($plantilla);
	
	if (!$boletin->save()){
		redirect_header('index.php?op=show', 1, _AM_RMB_ERRONSAVE . $boletin->errors());
		die();
	} else {
		redirect_header('index.php?op=show', 1, _AM_RMB_DBOK);
		die();
	}
}

function rmbEditBulletin(){
	global $db, $mc;
	$eliminar = 0;
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($id<=0){
		header('location: index.php');
		die();
	}
	
	$fechaeliminar = rmsoft_read_date('fechaeliminar');
	
	$boletin = new RMBulletin($id);
	if (!$boletin->setTitulo($titulo)){
		redirect_header('index.php?op=show', 1, _AM_RMB_NOTITLE);
		die();
	}
	$boletin->setIntro($intro);
	$boletin->setEliminar($eliminar);
	$boletin->setEliminacion($fechaeliminar);
	$boletin->setTemplate($plantilla);
	if (!$boletin->save()){
		redirect_header('index.php?op=show', 1, _AM_RMB_ERRONSAVE . $boletin->errors());
		die();
	} else {
		redirect_header('index.php?op=show', 1, _AM_RMB_DBOK);
		die();
	}
}

function rmbDelete(){
	
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	
	if ($id<=0){ header('location: index.php?op=show'); die(); }
	
	if ($ok){
		$boletin = new RMBulletin($id);
		if (!$boletin->delete()){
			redirect_header('index.php?op=show', 1, sprintf(_AM_RMB_ERRONDELETE, $boletin->errors()));
		} else {
			redirect_header('index.php?op=show', 1, _AM_RMB_DBOK);
		}
	} else {
		$boletin = new RMBulletin($id);
		$hiddens['op'] = 'del';
		$hiddens['ok'] = 1;
		$hiddens['id'] = $id;
		xoops_cp_header();
		xoops_confirm($hiddens, 'index.php?op=show', sprintf(_AM_RMB_DELCONFIRM, $boletin->getVar('titulo')), '', $addtoken = true);
		xoops_cp_footer();
	}
	
}

/**
 * Secciones del Boletín.
 * El contenido del boletín se basa en estas secciones
 * y a su vez las secciones permitirán crear un indice para navegar por el
 * contenido
 */
function rmbSections($edit=0){
	
	$bol = isset($_GET['bol']) ? $_GET['bol'] : 0;
	
	if ($bol<=0){ redirect_header('index.php', 1, _AM_RMB_BOLNOSPECIFY); die(); }
	
	if ($edit>0){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id<=0){ redirect_header('index.php?op=sections&amp;bol='.$bol, 1, _AM_RMB_NOSECTION); die(); }
	}
	
	$boletin = new RMBulletin($bol);
	
	xoops_cp_header();
	rmbMakeNav();
	echo "<div style='padding: 4px; align='left'>
			<a href='index.php?op=edit&amp;id=$bol#form'>"._AM_RMB_EDIT."</a> &nbsp; &bull; &nbsp;
			<a href='bulletins.php?id=$bol'>"._AM_RMB_CONTENT."</a>
		  </div><table class='outer' cellspacing='1' cellpadding='0' width='100%'>
			<tr><th colspan='3'>".sprintf(_AM_RMB_TITLESEC, $boletin->getVar('titulo'))."</th></tr>
			<tr class='head'>
				<td align='center'>"._AM_RMB_TITLE."</td>
				<td align='center'>"._AM_RMB_ORDER."</td>
				<td align='center'>"._AM_RMB_OPTIONS."</td>
			</tr>";
	
	$sections =& $boletin->getSections();
	
	foreach ($sections as $k){
		echo "<tr class='even'><td>".$k['titulo']."</td>
				<td align='center'>$k[order]</td>
				<td align='center'><a href='?op=editsection&amp;bol=$bol&amp;id=$k[id_sec]'>"._EDIT."</a>
				&middot; <a href='?op=delsection&amp;bol=$bol&amp;id=$k[id_sec]'>"._DELETE."</a></td>
			  </tr>";
				
	}
	if ($edit){
		$section = $boletin->getSection($id);
		if (!$section){
			redirect_header('index.php?op=sections&amp;bol='.$bol, 1, _AM_RMB_SECTIONNOEXISTS); die();
		}
	}
	echo "<tr><th colspan='3'>".($edit ? _AM_RMB_EDITSECTION : _AM_RMB_NEWSECTION)."</th></tr>";
	echo "<form name='frmNew' method='post' action='index.php'>
		  <tr class='odd'><td><input type='text' name='titulo' size='30' value='".($edit ? $section->getTitle() : '')."' /></td>
		  <td align='center'><input type='text' name='order' size='10' value='".($edit ? $section->getOrder() : '')."' /></td>
		  <td align='center'><input type='submit' value='"._SUBMIT."' /></td></tr>
		  <input type='hidden' name='op' value='".($edit ? 'saveeditsection' : 'savesection')."' />
		  <input type='hidden' name='bol' value='$bol' />
		  ".($edit ? "<input type='hidden' name='id' value='".$section->getId()."' />" : '')."
		  </form>";
	echo "</table>";
	xoops_cp_footer();
}

function rmbSaveSection(){
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($bol<=0){ redirect_header('index.php', 1, _AM_RMB_BOLNOSPECIFY); die(); }
	if ($titulo==''){ redirect_header('index.php?op=sections&amp;bol=$bol', 1, _AM_RMB_NOTITLESEC); die(); }
	if ($order<=0) $order = 0;
	
	
	$boletin = new RMBulletin($bol);
	
	if ($boletin->addSection($titulo, $order)){
		redirect_header('?op=sections&amp;bol='.$bol, 1, _AM_RMB_DBOK);
	} else {
		redirect_header('?op=sections&amp;bol='.$bol, 2, _AM_RMB_DBERROR . $boletin->errors());
	}
	
}

function rmbSaveEditedSection(){
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($bol<=0){ redirect_header('index.php', 1, _AM_RMB_BOLNOSPECIFY); die(); }
	if ($id<=0){ redirect_header('index.php?op=sections&amp;bol='.$bol, 1, _AM_RMB_NOSECTION); die(); }
	
	$section = new RMBSection($id);
	
	if (!$section){
		redirect_header('index.php?op=sections&amp;bol='.$bol, 1, _AM_RMB_SECTIONNOEXISTS); die();
	}
	
	$section->setTitle($titulo);
	$section->setOrder($order);
	if ($section->save()){
		redirect_header('?op=sections&amp;bol='.$bol, 1, _AM_RMB_DBOK);
	} else {
		redirect_header('?op=sections&amp;bol='.$bol, 2, _AM_RMB_DBERROR . $boletin->errors());
	}
	
}

function rmbDeleteSection(){
	
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	$bol = isset($_GET['bol']) ? $_GET['bol'] : (isset($_POST['bol']) ? $_POST['bol'] : 0);
	
	if ($bol<=0){ redirect_header('index.php', 1, _AM_RMB_BOLNOSPECIFY); die(); }
	if ($id<=0){ header('location: index.php?op=sections&amp;bol='.$bol); die(); }
	
	if ($ok){
		$boletin = new RMBulletin($bol);
		if (!$boletin->delSection($id)){
			redirect_header('?op=sections&amp;bol='.$bol, 2, _AM_RMB_DBERROR . $boletin->errors());
		} else {
			redirect_header('index.php?op=sections&amp;bol='.$bol, 1, _AM_RMB_DBOK);
		}
	} else {
		$boletin = new RMBulletin($bol);
		$hiddens['op'] = 'delsection';
		$hiddens['ok'] = 1;
		$hiddens['id'] = $id;
		$hiddens['bol'] = $bol;
		xoops_cp_header();
		xoops_confirm($hiddens, 'index.php', _AM_RMB_DELCONFSEC, '', $addtoken = true);
		xoops_cp_footer();
	}
	
}


$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'editsection':
		rmbSections(1);
		break;
	case 'sections':
		rmbSections();
		break;
	case 'save':
		rmbSave();
		break;
	case 'saveedit':
		rmbEditBulletin();
		break;
	case 'del':
		rmbDelete();
		break;
	case 'edit':
		rmbShowBulletins(1);
		break;
	case 'savesection':
		rmbSaveSection();
		break;
	case 'saveeditsection':
		rmbSaveEditedSection();
		break;
	case 'delsection':
		rmbDeleteSection();
		break;
	case 'show':
		rmbShowBulletins();
		break;
	default:
		showState();
		break;
}
?>