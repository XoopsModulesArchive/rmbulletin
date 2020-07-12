<?php
/*******************************************************************
* $Id: suscribe.php,v 1.0 10/09/2006 00:44 BitC3R0 Exp $           *
* ------------------------------------------------------           *
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
* ------------------------------------------------------           *
* suscribe.php:                                                    *
* Archivo para manejar suscripciones al boletín                    *
* ------------------------------------------------------           *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 10/09/2006 12:44:39 a.m.                            *
*******************************************************************/

include 'header.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if ($email==''){
	header('location: '.XOOPS_URL);
	die();
}

if (!checkEmail($email)){
	redirect_header(XOOPS_URL.'/modules/rmbulletin', 2, _RMB_ERRSUSCRIBE);
	die();
}

$user = new RMBUser($email);

if (!$user->isNew()){
	redirect_header(XOOPS_URL, 1, _RMB_EMAILEXIST);
	die();
}

$user->setEmail($email);
if ($xoopsUser!=''){
	$user->setXUser($xoopsUser->getVar('uid'));
	$user->setRegister(1);
} else {
	$user->setRegister(0);
}

if ($user->save()){
	redirect_header(XOOPS_URL, 1, _RMB_SUSCRIBEOK);
	die();
} else {
	redirect_header(XOOPS_URL, 2, _RMB_ERRSUSCRIBE);
	die();
}

?>