<?php
/*******************************************************************
* $Id: users.php,v 1.0 08/09/2006 10:47 BitC3R0 Exp $              *
* ---------------------------------------------------              *
* RMSOFT Bulletin 1.0                                              *
* Módulo para el manejo y publicación de boletínes                 *
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
* ---------------------------------------------------              *
* users.php:                                                       *
* Control de Usuarios suscritos al plugin.                         *
* ---------------------------------------------------              *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0                                                    *
* @modificado: 08/09/2006 10:47:26 a.m.                            *
*******************************************************************/

define('RMBULLETIN_LOCATION','users');

include 'header.php';
include_once XOOPS_ROOT_PATH.'/modules/rmbulletin/class/user.class.php';

function showUsers(){
	global $db, $mc;
	
	xoops_cp_header();
	rmbMakeNav();
	
	$sk = isset($_REQUEST['sk']) ? $_REQUEST['sk'] : '';
	if ($sk!=''){
		$search = " WHERE email LIKE '%$sk%'";
	}
	
	$limit = 30;
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 0;
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_users").$search);
	
	list($num) = $db->fetchRow($result);
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if ($num % $limit > 0) $tpages++;
	$pactual = $pag + 1;

	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	echo "<div class='outer'>
			<div class='head' align='center'>
				<a href='?op=addxoops'>"._AM_RMB_ADDXOOPSU."</a> <strong>&middot;</strong>
				<a href='?op=new'>"._AM_RMB_ADDUSER."</a></div>
		  </div><br />";
	
	echo "<table width='100%' cellspacing='2' cellpadding='4' border='0'>
			<tr>
			 	<td align='left'>".sprintf(_AM_RMB_REGTOTAL, $rtotal)." &nbsp; 
				".sprintf(_AM_RMB_SHOWING, $start + 1, ($start + $limit <= $rtotal) ? $start + $limit : $rtotal)."</td>
				<td align='center'><form name='frmSrh' method='get' action='users.php' style='margin: 0px; padding: 0;'>
				"._AM_RMB_SEARCH." <input type='text' name='sk' size='20' value='$sk' />
				<input type='submit' value='"._SEARCH."' class='formButton' /></form></td>
				<td align='right'><form name='frmGo' method='get' action='users.php'>"._AM_RMB_PAGE."
				<select name='pag'>";
				for($i=1;$i<=$tpages;$i++){
					echo "<option value='$i'".($i==$pactual ? ' selected="selected"' : '').">$i</option>";
				}
	echo "      </select> <input type='submit' value='"._GO."' /><input type='hidden' name='sk' value='$sk' /></form></td>
			</tr>
		  </table>";
	
	echo "<table class='outer' cellspacing='1' cellpadding='0' width='100%'>
			<tr><th colspan='5'>"._AM_RMB_TABLETITLE."</th></tr>
			<tr align='center' class='head'>
			<td width='50'>&nbsp;</td>
			<td>"._AM_RMB_EMAIL."</td>
			<td>"._AM_RMB_REGISTER."</td>
			<td>"._AM_RMB_DATE."</td>
			<td>"._AM_RMB_OPTIONS."</td>
			</tr>";
			
	$result = $db->query("SELECT id_user FROM ".$db->prefix("rmb_users")." $search ORDER BY alta LIMIT $start,$limit");
	$class = '';
	$i = 0;
	while ($row=$db->fetchArray($result)){
		$user = new RMBUser($row['id_user']);
		$class = $class == 'even' ? 'odd' : 'even';
		$i++;
		echo "<tr class='$class'>
				<td align='right'>".($i + $start).".</td>
				<td align='center'>".$user->getVar('email')."</td>
				<td align='center'>".($user->getVar('registered')==1 ? _YES : _NO)."</td>
				<td align='center'>".date($mc['format_date'],$user->getVar('alta'))."</td>
				<td align='center'><a href='?op=del&amp;id=$row[id_user]'>"._DELETE."</a></td>
			  </tr>";
	}
	
	echo "</table>";
	
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function addXoops(){
	global $db;
	
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	
	if ($ok){
	
		if (!$GLOBALS['xoopsSecurity']->validateToken()){
			redirect_header('users.php', 2, _AM_RMBS_ERRSESS);
			die();
		}
	
		$result = $db->query("SELECT uid, email FROM ".$db->prefix("users")." WHERE user_mailok='1'");
		while ($row=$db->fetchArray($result)){
			list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmb_users")." WHERE uid='$row[uid]' AND registered='1'"));
			if ($num>0) continue;
			$db->queryF("INSERT INTO ".$db->prefix("rmb_users")." (`uid`,`alta`,`registered`,`email`)
					VALUES ('$row[uid]','".time()."','1','$row[email]')");
		}
		redirect_header('users.php', 1, _AM_RMB_DBOK);
	
	} else {
		
		xoops_cp_header();
		rmbMakeNav();
		echo "<div align='center'>
				<div style='border: 1px solid #CCCCCC; background: #F5F5F5; width: 400px; padding: 20px; tex-align: center;'>
					"._AM_RMB_MSGADDX."<br /><br />
					<strong>"._AM_RMB_CONFIRMCONTINUE."</strong><br /><br />
					<form name='frmDel' method='post' action='users.php'>
						<input type='submit' class='formButton' value='"._SUBMIT."' />
						<input type='submit' class='formButton' value='"._CANCEL."' onclick='history.go(-1);' />
						<input type='hidden' name='op' value='addxoops' />
						<input type='hidden' name='ok' value='1' />";
						echo $GLOBALS['xoopsSecurity']->getTokenHTML();
		echo	   "</form>
				</div>
			  </div>";
		echo rmbMakeFooter();
		xoops_cp_footer();
		
	}
	
}

function newForm(){
	global $db;
	
	xoops_cp_header();
	rmbMakeNav();
	
	$form = new RMForm(_AM_RMB_ADDUSER, 'frmNew', 'users.php');
	$form->addElement(new RMText(_AM_RMB_FMAIL,'email',50,255), true, 'Email');
	$ele = new RMSelect(_AM_RMB_XUSER,'uid');
		$ele->addOption(0,_AM_RMB_NONE,1);
		$result = $db->query("SELECT uid,uname FROM ".$db->prefix("users")." ORDER BY uname");
		while ($row = $db->fetchArray($result)){
			$ele->addOption($row['uid'],$row['uname']);
		}
	$form->addElement($ele,false);
	$form->addElement(new RMButton('sbt',_SUBMIT));
	$form->addElement(new RMHidden('op','saveuser'));
	$form->display();
	
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}


function saveUser(){
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if (!$GLOBALS['xoopsSecurity']->validateToken()){
		redirect_header('users.php', 2, _AM_RMBS_ERRSESS);
		die();
	}
	
	$user = new RMBUser();
	$user->setEmail($email);
	if ($uid>0){
		$user->setRegister(1);
		$user->setXUser($uid);
	} else {
		$user->setRegister(0);
	}
	
	if (!$user->save()){
		redirect_header('users.php', 2, _AM_RMB_DBERROR . "<br>" . $user->errors());
		die();
	} else {
		redirect_header('users.php', 1, _AM_RMB_DBOK);
		die();
	}
	
}

function deleteUser(){
	
	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$user = new RMBUser($id);
	
	if ($ok){
	
		if (!$GLOBALS['xoopsSecurity']->validateToken()){
			redirect_header('users.php', 2, _AM_RMBS_ERRSESS);
			die();
		}
		
		if (!$user->delete()){
			redirect_header('users.php', 2, _AM_RMB_DBERROR . "<br>" . $user->errors());
			die();
		} else {
			redirect_header('users.php', 1, _AM_RMB_DBOK);
			die();
		}
	
	} else {
		xoops_cp_header();
		rmbMakeNav();
		echo "<div align='center'>
				<div style='border: 1px solid #CCCCCC; background: #F5F5F5; width: 400px; padding: 20px; tex-align: center;'>
					".sprintf(_RM_RMB_DELETEMSG, $user->getVar('email'))."<br /><br />
					<strong>"._AM_RMB_CONFIRMCONTINUE."</strong><br /><br />
					<form name='frmDel' method='post' action='users.php'>
						<input type='submit' class='formButton' value='"._SUBMIT."' />
						<input type='hidden' name='op' value='del' />
						<input type='hidden' name='id' value='$id' />
						<input type='hidden' name='ok' value='1' />";
						echo $GLOBALS['xoopsSecurity']->getTokenHTML();
		echo	   "</form>
				</div>
			  </div>";
		echo rmbMakeFooter();
		xoops_cp_footer();
	}
	
	
}


$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

switch ($op){
	case 'del':
		deleteUser();
		break;
	case 'new':
		newForm();
		break;
	case 'addxoops':
		addXoops();
		break;
	case 'saveuser':
		saveUser();
		break;
	default:
		showUsers();
		break;
}

?>