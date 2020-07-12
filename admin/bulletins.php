<?php
/*******************************************************************
* $Id: bulletins.php,v 1.0.1 18/05/2006 18:25 BitC3R0 Exp $        *
* ---------------------------------------------------------        *
* RMSOFT Bulletin 1.0                                              *
* Boletín Informativo Avanzado                                     *
* CopyRight © 2006. Red México Soft                                *
* Autor: BitC3R0                                                   *
* http://www.redmexico.com.mx                                      *
* http://www.xoops-mexico.net                                      *
* --------------------------------------------                     *
* This program is free software; you can redistribute it and/or    *
* modify it under the terms of the GNU General Public License as   *
* published by the Free Software Foundation; either version 2 of   *
* the License, or (at your option) any later version.              *
*                                                                  *
* This program is distributed in the hope that it will be useful,  *
* but WITHOUT ANY WARRANTY; without even the implied warranty of   *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the     *
* GNU General Public License for more details.                     *
*                                                                  *
* You should have received a copy of the GNU General Public        *
* License along with this program; if not, write to the Free       *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,   *
* MA 02111-1307 USA                                                *
*                                                                  *
* ---------------------------------------------------------        *
* bulletins.php:                                                   *
* Manejo de Boletines                                              *
* ---------------------------------------------------------        *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0.1                                                  *
* @modificado: 18/05/2006 06:25:44 p.m.                            *
*******************************************************************/

define('RMBULLETIN_LOCATION','bulletins');

include 'header.php';

// Mostramos el formulario para creación de contenido
function showForm(){
	global $db;
	
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
	if ($id<=0){ header('location: index.php'); die(); }
	
	xoops_cp_header();
	rmbMakeNav();
	
	$boletin = new RMBulletin($id);
	// Mostramos los datos del boletín
	echo "<div style='padding: 4px; align='left'>
			<a href='index.php?op=edit&amp;id=$id#form'>"._AM_RMB_EDIT."</a> &nbsp; &bull; &nbsp;
			<a href='index.php?op=sections&amp;bol=$id'>"._AM_RMB_SECTIONS."</a> &nbsp; &bull; &nbsp;
			<a href='bulletins.php?op=preview&amp;id=$id' target='_blank'>"._AM_RMB_PREVIEW."</a>
		  </div><table class='outer' cellspacing='1' width='100%'>
			 <tr>
			 	<th colspan='2'>".$boletin->getVar('titulo')."</th>
			 </tr>
			 <tr>
			 	<td class='odd' width='80%' valign='top'>
			 		".$boletin->getVar('introduccion')."
			 	</td>
			 </tr>
		  </table><br />";
	
	// Contenido del Boletín
	$items = $boletin->getItems();
	echo "<table width='100%' cellpadding='0' cellspacing='3' border='0'>
			<tr><td valign='top' align='center'><table cellspacing='2' cellpadding='2' border='0' align='center'><tr>";
			$result = $db->query("SELECT dir FROM ".$db->prefix("rmb_plugins")." ORDER BY 'name'");
			while ($row = $db->fetchArray($result)){
				$pHand = new RMBPluginHandler($row['dir']);
				$plugin =& $pHand->getPlugin();
				echo "<td align='center'><a href='bulletins.php?acc=new&amp;op=content&amp;plug=$row[dir]&amp;id=$id' title='".$plugin->getName()."'><img src='../plugins/$row[dir]/".$plugin->getLogo()."' alt='".$plugin->getName()."' /></a></td>";
			}
	echo "</tr></table></td></tr><tr><td valign='top'>
				<table class='outer' cellspacing='1' width='100%'>
				<tr><th colspan='4'>"._AM_RMB_CONTENTTITLE."</th></tr>
				<tr class='head'><td align='center'>"._AM_RMB_MODULE."</td>
				<td align='center'>"._AM_RMB_CONTPREVIEW."</td>
				<td align='center'>"._AM_RMB_SECTION."</td>
				<td align='center'>"._AM_RMB_OPTIONS."</td>
				</tr>";
	$class = '';
	foreach ($items as $k){
		$class = $class == 'even' ? 'odd' : 'even';
		if (isset($pHand)){
			if ($pHand->getVar('dir')!=$k['plugin']){
				$pHand = new RMBPluginHandler($k['plugin']);
				$plugin = $pHand->getPlugin();
			}
		} else {
			$pHand = new RMBPluginHandler($k['plugin']);
			$plugin = $pHand->getPlugin();
		}
		
		if (!isset($section)){
			$section = new RMBSection($k['section']);
		} else {
			if ($section->getId()!=$k['section']) $section = new RMBSection($k['section']);
		}
		
		echo "<tr class='$class'>
				<td align='center'>".$plugin->getName()."</td>
				<td align='left'>".$plugin->preview($k['params'])."</td>
				<td align='center'>".$section->getTitle()."</td>
				<td align='center' nowrap='nowrap'>
					<a href='?acc=edit&amp;op=content&amp;id=$id&amp;plug=$k[plugin]&amp;item=$k[id_item]'>"._EDIT."</a> -
					<a href='?op=delitem&amp;id=$k[id_item]&amp;bol=$id'>"._DELETE."</a>
				</td>
			  </tr>";
	}
		
	echo "	</table>
			</td></tr></table>";
	
	echo rmbMakeFooter();
	
	xoops_cp_footer();
}

/**
 * Editamos las columnas del boletín
 */
function showColForm(){
	global $xoopsModule;
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$col = isset($_GET['col']) ? $_GET['col'] : '';
	
	if ($id<=0){ redirect_header('index.php', 1, _AM_RMB_BOLNOSPECIFY); die(); }
	if ($col!='left' && $col!='right' && $col!='center' && $col!='foot' && $col!='index'){
		redirect_header('bulletins.php?id='.$id, 1, _AM_RMB_WRONGCOL);
		die();
	}
	
	xoops_cp_header();
	
	// Script
	echo "<script type='text/javascript'>
			function loadPlugin(){
				nombre = document.forms['frm$col'].plugin.options[document.forms['frm$col'].plugin.selectedIndex].value;
				openWithSelfMain('bulletins.php?op=loadplugin&id=' + nombre + '&col=$col','plugins',400,400);
			}
		  </script>";
	
	$boletin = new RMBulletin($id);
	
	$formTitle = ($col=='left') ? _AM_RMB_LEFTCOL : (($col=='right') ? _AM_RMB_RIGHTCOL : (($col=='center') ? _AM_RMB_CENTERCOL : (($col=='foot') ? _AM_RMB_FOOTER : (($col=='index') ? _AM_RMB_INDEXCOL : ''))));
	rmbMakeNav();
	$form = new RMForm($formTitle, 'frm'.$col, 'bulletins.php', 'post');
	// Cargamos los plugins
	
	$select = "<select name='plugin' id='plugin'>
				<option value='' selected='selected'>"._AM_RMB_SELECTPLUGIN."</selected>";
	
	$plugPath = XOOPS_ROOT_PATH.'/modules/rmbulletin/plugins/';
	$dir = @opendir($plugPath);
	while ($obj = readdir($dir)){
		if ($obj == '.' || $obj == '..'){ continue; }
		if (!is_dir($plugPath . $obj)){ continue; }
		if (!file_exists($plugPath . $obj . '/plugin.php')){ continue; }
		
		include_once $plugPath . $obj . '/plugin.php';
		
		$className = "RMB" . $obj;
		$plugin = new $className();
		global $plugLang;
		include_once $plugin->getLangFile();
		
		$select .= "<option value='$obj'>".$plugin->getName()."</option>";
	}
	$select .= "</select> <input type='button' id='sbt' value='"._AM_RMB_LOADPLUGIN."' onclick='javascript:loadPlugin();' />";
	
	$form->addElement(new RMLabel(_AM_RMB_PLUGIN, $select));
	$editor = getEditor('', $col, $boletin->getVar($col), '100%', '600px', '', false);
	$form->addElement(new RMLabel(_AM_RMB_CONTENT, $editor));
	$form->addElement(new RMLabel('',"<input type='submit' id='sbt' value='"._SUBMIT."' class='formButton' />
			<input type='button' id='cancel' value='"._CANCEL."' onclick='history.go(-1);' class='formButton' />"));
	$form->addElement(new RMHidden('op','savecol'));
	$form->addElement(new RMHidden('col', $col));
	$form->addElement(new RMHidden('id', $id));
	$form->display();
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function deleteItem(){
	
	$bol = isset($_GET['bol']) ? $_GET['bol'] : 0;
	
	if ($bol<=0){
		header('location: bulletins.php');
		die();
	}
	
	$boletin = new RMBulletin($bol);
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	if ($id<=0){
		header('location: bulletins.php?id='.$bol);
		die();
	}
	
	if ($boletin->delItem($id)){
		redirect_header('bulletins.php?id='.$bol, 2, _AM_RMB_DBOK);
	} else {
		redirect_header('bulletins.php?id='.$bol, 2, _AM_RMB_DBERROR."<br />".$boletin->errors());
	}
	
	
}

function previewBol(){
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	if ($id<=0){
		header('location: mail.php');
		die();
	}
	
	$boletin = new RMBulletin($id);
	
	echo $boletin->preview();
	
}

function sendBol(){
	global $xoopsConfig;
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	if ($id<=0){
		header('location: index.php?op=show');
		die();
	}
	
	$lotes = isset($_REQUEST['lotes']) ? $_REQUEST['lotes'] : -1;
	
	if ($lotes==1){
		
		sendLotes();
		
	} elseif ($lotes==0){
		// Envío total
	} else {
		
		xoops_cp_header();
		rmbMakeNav();
		
		$boletin = new RMBulletin($id);
		
		if ($boletin->getSended()){
			redirect_header('index.php?op=show', 2, _AM_RMB_ALREADYSEND);
			die();
		}
		
		echo "<table width='80%' align='center' border='0' cellpadding='4'><tr><td>";
		echo "<h2>".sprintf(_AM_RMB_SENDBOL, $boletin->getTitulo())."</h2>";
		if (file_exists(XOOPS_ROOT_PATH."/modules/rmbulletin/admin/tpls/sendinfo_$xoopsConfig[language].html")){
			include_once XOOPS_ROOT_PATH."/modules/rmbulletin/admin/tpls/sendinfo_$xoopsConfig[language].html";
		} else {
			include_once XOOPS_ROOT_PATH."/modules/rmbulletin/admin/tpls/sendinfo_spanish.html";
		}
		
		echo "</td></tr><tr><td align='center'>
				<a href='bulletins.php?op=send&amp;id=$id&amp;lotes=1'><img src='../images/lotes.png' align='absmiddle' /></a>
				<a href='bulletins.php?op=send&amp;id=$id&amp;lotes=1' style='font-size: 18px;'>"._AM_RMB_LOTES."</a>
				</td></tr>";
		echo "</table>";
		echo rmbMakeFooter();
		xoops_cp_footer();
	}
	
}

function sendLotes(){
	
	global $db, $mc;
	
	$id = $_REQUEST['id'];
	
	xoops_cp_header();
	rmbMakeNav();
		
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_users")." ORDER BY alta");
	echo "<form name='frmSend' method='post' action='bulletins.php'>
			<table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='4'>"._AM_RMB_EMAILSTO."</th></tr>
			<tr class='head'><td colspan='4'>"._AM_RMB_MARKNO."</td></tr><tr class='even'>";
	$class = 'even';
	$i = 1;
	while ($row = $db->fetchArray($result)){
		if ($i>4){
			$class = $class == 'even' ? 'odd' : 'even';
			echo "</tr><tr class='$class'>";
			$i = 1;
		} 
		
		echo "<td><label><input type='checkbox' name='mails[]' value='$row[email]' checked='checked' /> $row[email]</label></td>";
		$i++;
	}
	echo "</tr><tr class='foot'><td colspan='4' align='left'><input type='submit' name='sbt' value='"._SUBMIT."' class='formButton' />
		  </td></tr></table>
		  <input type='hidden' name='op' value='sendlote' />
		  <input type='hidden' name='id' value='$id' />
		  </form>";
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function sendLoteNow(){
	global $db, $mc;
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	$sent = array();
	$boletin = new RMBulletin($id);
	if ($mc['multimails']){
		$smtp = $boletin->getEmails();
		$total = count($smtp);
		for($i=0;$i<=$total;$i++){
			$k = array_shift($smtp);
			$mail = new RMBMail($k);	
			
			if ($mail->getUsed()<$mail->getLimit()) break;
			
		}
			
	}
	
	for ($i=0;$i<$mc['maxnum'];$i++){
		
		if (count($mails) == 0) break;
		
		$email = array_shift($mails);
		
		if ($mc['multimails']){
			
			
			if ($mail->getUsed() >= $mail->getLimit()){
				$k = array_shift($smtp);
				$mail->save();
				$mail = new RMBMail($k);
			}
			
			$server = array();
			$server['smtp'] = $mail->getServer();
			$server['user'] = $mail->getUser();
			$server['password'] = $mail->getPass();

			$boletin->send($email, $mail->getFrom()!='' ? $mail->getFrom() : $mc['from'], $mc['fromname'], $server);		
			
			$mail->setUsed($mail->getUsed()+1);
			
		} else {
			
			$boletin->send($email, $mc['from'], $mc['fromname']);
		
		}
		
	}
	
	if ($mc['multimails']){
		$mail->save();
	}
	
	if (count($mails)==0){
		
		if ($mc['delete']) $boletin->deleteContent();
		
		$db->queryF("UPDATE ".$db->prefix("rmb_emails")." SET used='0'");
		redirect_header('index.php?op=show', 2, _AM_RMB_SENDOK);
		die();
	}
	
	xoops_cp_header();
	rmbMakeNav();
	echo "<script type='text/javascript'>
			function Temporizer(){
				setTimeout('submitForm()',3000);
			}
			window.onLoad=Temporizer();
			-->
			function submitForm(){
				document.forms.frmSend.submit();
			}
			</script>";
	if ($boletin->errors()!=''){
		echo "<div class='errorMsg'>".$boletin->errors()."</div><br />";
	}
	echo "<form name='frmSend' method='post' action='bulletins.php'>
			<table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='4'>"._AM_RMB_SENDINGNOW."</th></tr>
			<tr class='head'><td colspan='4'>"._AM_RMB_DEPENDS."</td></tr>
			<tr class='odd'><td colspan='2' align='left'>"._AM_RMB_YOUCANCEL."</td>
			<td colspan='2' align='right'>".sprintf(_AM_RMB_RESTING, count($mails))."</td></tr><tr class='even'>";
	$class = 'even';
	$i = 1;
	foreach ($mails as $k){
		if ($i>4){
			$class = $class == 'even' ? 'odd' : 'even';
			echo "</tr><tr class='$class'>";
			$i = 1;
		} 
		
		echo "<td><label><input type='checkbox' name='mails[]' value='$k' checked='checked' /> $k</label></td>";
		$i++;
	}
	echo "</tr><tr class='foot'><td colspan='4' align='left'><input type='submit' name='sbt' value='"._SUBMIT."' class='formButton' />
		  <input type='button' name='cancel' value='"._CANCEL."' onclick=\"window.location = 'index.php?op=show';\" />
		  </td></tr></table>
		  <input type='hidden' name='op' value='sendlote' />
		  <input type='hidden' name='id' value='$id' />
		  </form>";
	echo rmbMakeFooter();
	xoops_cp_footer();
	
	
}

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'savecol':
		saveColumn();
		break;
	case 'plugin':
	case 'loadplugin':
		showPlugin();
		break;
	case 'editcol':
		showColForm();
		break;
	case 'content':
		include 'content.php';
		break;
	case 'delitem':
		deleteItem();
		break;
	case 'preview':
		previewBol();
		break;
	case 'send':
		sendBol();
		break;
	case 'sendlote':
		sendLoteNow();
		break;
	default:
		showForm();
		break;
}
?>
