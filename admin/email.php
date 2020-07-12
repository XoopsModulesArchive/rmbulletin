<?php
/*******************************************************************
* $Id: email.php,v 1.0 08/09/2006 17:30 BitC3R0 Exp $              *
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
* email.php:                                                       *
* Control de envíos del boletín                                    *
* ---------------------------------------------------              *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 08/09/2006 05:30:13 p.m.                            *
*******************************************************************/

define('RMBULLETIN_LOCATION','email');
include 'header.php';
include_once XOOPS_ROOT_PATH.'/modules/rmbulletin/class/mail.class.php';

function showEmails(){
	global $db, $mc;
	
	xoops_cp_header();
	rmbMakeNav();
	
	echo "<table width='100%' class='outer' cellspacing='1' cellpadding='0'>
			<tr><th colspan='4'>"._AM_RMB_TBLTITLE."</th></tr>
			<tr align='center' class='head'>
			<td>"._AM_RMB_SERVER."</td>
			<td>"._AM_RMB_ACCOUNT."</td>
			<td>"._AM_RMB_LIMIT."</td>
			<td>"._AM_RMB_OPTIONS."</td>
			</tr>";
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_emails"));
	while ($row=$db->fetchArray($result)){
		echo "<tr class='even'><td align='left'>$row[smtp]</td>
				<td align='center'>$row[user]</td>
				<td align='center'>$row[limit]</td>
				<td align='center'>
				<a href='?op=del&amp;id=$row[id_mail]'>"._DELETE."</a>
				</td></tr>";
	}				
	echo "</table><br />";
	
	$form = new RMForm(_AM_RMB_FORMTITLE,'frmNew','email.php');
	if (!$mc['multimails']) $form->addElement(new RMLabel('', "<strong style='color: #FF0000;'>"._AM_RMB_NOMULTIMAIL."</strong>"));
	$form->addElement(new RMText(_AM_RMB_SERVER,'smtp'), true);
	$form->addElement(new RMText(_AM_RMB_LOGINU,'user',30), true);
	$form->addElement(new RMText(_AM_RMB_PASSWORD, 'password',30,150,'',true),true);
	$ele = new RMText(_AM_RMB_FROMMAIL, 'from',50,200,'');
	$ele->setDescription(_AM_RMB_FROMMAIL_DESC);
	$form->addElement($ele);
	$form->addElement(new RMText(_AM_RMB_LIMIT, 'limit',10,4,'100'),true,'Num');
	$form->addElement(new RMHidden('op','save'));
	$form->addElement(new RMButton('sbt',_SUBMIT));
	$form->display();
	
	echo rmbMakeFooter();
	xoops_cp_footer();
	
}

function saveMail(){
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($smtp==''){ redirect_header('email.php', 2, _AM_RMB_ERRSMTP); die(); }
	if ($user==''){ redirect_header('email.php', 2, _AM_RMB_ERRUSER); die(); }
	if ($password==''){ redirect_header('email.php', 2, _AM_RMB_ERRPASS); die(); }
	if ($limit<=0) $limit = 100;
	
	$mail = new RMBMail();
	$mail->setServer($smtp);
	$mail->setUser($user);
	$mail->setPass($password);
	$mail->setLimit($limit);
	$mail->setFrom($from);
	if ($mail->save()){
		redirect_header('email.php', 1, _AM_RMB_DBOK);
	} else {
		redirect_header('email.php', 1, _AM_RMB_DBERROR."<br />".$mail->errors());
	}	
	
}

function deleteMail(){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$mail = new RMBMail($id);
		
	if ($ok){
	
		if (!$GLOBALS['xoopsSecurity']->validateToken()){
			redirect_header('email.php', 2, _AM_RMBS_ERRSESS);
			die();
		}
		
		if (!$mail->delete()){
			redirect_header('email.php', 2, _AM_RMB_DBERROR . "<br>" . $user->errors());
			die();
		} else {
			redirect_header('email.php', 1, _AM_RMB_DBOK);
			die();
		}
	
	} else {
		xoops_cp_header();
		rmbMakeNav();
		echo "<div align='center'>
				<div style='border: 1px solid #CCCCCC; background: #F5F5F5; width: 400px; padding: 20px; tex-align: center;'>
					".sprintf(_RM_RMB_DELETEMSG, $mail->getUser())."<br /><br />
					<strong>"._AM_RMB_CONFIRMCONTINUE."</strong><br /><br />
					<form name='frmDel' method='post' action='email.php'>
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
	case 'save':
		saveMail();
		break;
	case 'del':
		deleteMail();
		break;
	default:
		showEmails();
		break;
}
	
?>