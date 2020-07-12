<?php
/*******************************************************************
* $Id: unsucribe.php,v 1.0 09/09/2006 23:06 BitC3R0 Exp $          *
* -------------------------------------------------------          *
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
* -------------------------------------------------------          *
* unsucribe.php:                                                   *
* Archivo para permitir a los usuarios cancelar su                 *
* suscripción al Boletín                                           *
* -------------------------------------------------------          *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 09/09/2006 11:06:11 p.m.                            *
*******************************************************************/

include 'header.php';


$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

if ($op=='sendmail'){
	
	if (!$GLOBALS['xoopsSecurity']->validateToken()){
		redirect_header('unsuscribe.php', 2, _RMB_ERRSESS);
		die();
	}
	
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	
	if ($email==''){
		redirect_header('unsuscribe.php', 2, _RMB_ERRMAIL);
		die();
	}
	
	$user = new RMBUser($email);
	if ($user->isNew()){
		redirect_header('unsuscribe.php', 2, _RMB_NOEXISTMAIL);
		die();
	}
	
	$user->setCode(md5(time().$user->getEmail()));
	!$user->save();
	
	$xoopsMailer =& getMailer();
	$xoopsMailer->useMail();
	$xoopsMailer->setTemplate("unsuscribe.tpl");
	$xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/'.$xoopsConfig['language'].'/mailtpl');
	$xoopsMailer->assign('SITENAME', $xoopsConfig['sitename']);
	$xoopsMailer->assign('URL', XOOPS_URL.'/modules/rmbulletin/unsuscribe.php?mail='.$email.'&op=complete&id='.$user->getCode());
	$xoopsMailer->assign('ADMIN', $xoopsModuleConfig['fromname']);
	$xoopsMailer->assign('SITEURL', XOOPS_URL);
	$xoopsMailer->setToEmails($email);
	$xoopsMailer->setFromEmail($xoopsModuleConfig['from']);
	$xoopsMailer->setFromName($xoopsModuleConfig['fromname']);
	$xoopsMailer->setSubject(_RMB_SUBJECTUN);
	$xoopsMailer->send();
	
	redirect_header(XOOPS_URL, 2, _RMB_REDIRMSG);
	
} elseif($op=='complete') {
	
	$email = isset($_GET['mail']) ? $_GET['mail'] : '';
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	
	if ($email=='' || $id==''){
		header('location: unsuscribe.php');
		die();
	}
	
	$user = new RMBUser($email);
	if ($user->isNew()){
		redirect_header('unsuscribe.php', 2, _RMB_NOEXISTMAIL);
		die();
	}
	
	if ($id!=$user->getCode()){
		redirect_header('unsuscribe.php', 2, _RMB_ERRID);
		die();
	}
	
	if ($user->delete()){
		redirect_header(XOOPS_URL, 2, _RMB_CANCELLED);
		die();
	 } else {
	 	redirect_header('unsuscribe.php', 2, _RMB_ERROCUR);
		die();
	 }
		
} else {
	
	echo "<strong>"._RMB_UNSUSCRIBE."</strong><br /><br />";
	
	$form = new RMForm(_RMB_FORMTITLE, 'frmUn', 'unsuscribe.php');
	$form->addElement(new RMText(_RMB_FEMAIL,'email'),true,'Email');
	$form->addElement(new RMLabel('','<span style="font-size: 10px;">'._RMB_UNMSG.'</span>'));
	$form->addElement(new RMButton('sbt',_SUBMIT));
	$form->addElement(new RMHidden('op','sendmail'));
	$form->display();
	
}

include XOOPS_ROOT_PATH.'/footer.php';

?>

