<?php
/*******************************************************************
* $Id: header.php,v 0.1.1 09/05/2006 14:17 BitC3R0 Exp $           *
* ------------------------------------------------------           *
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
* ------------------------------------------------------           *
* header.php:                                                      *
* Archivo de inclusión de archivos y encabezado de la              *
* Sección Administrativa del Módulo                                *
* ------------------------------------------------------           *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 0.1.1                                                  *
* @modificado: 09/05/2006 02:17:43 p.m.                            *
*******************************************************************/

include '../../../include/cp_header.php';

/**
 * Nos aseguramos que exista el lenguage buscaado
 */
if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/admin.php')) {
	include_once XOOPS_ROOT_PATH. '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
	include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/spanish/admin.php';
}

$db =& Database::getInstance();
$myts =& MyTextSanitizer::getInstance();
$mc =& $xoopsModuleConfig;
define('RMB_PATH',XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/');

include_once XOOPS_ROOT_PATH.'/rmcommon/table.class.php';
include_once XOOPS_ROOT_PATH.'/rmcommon/form.class.php';
include_once XOOPS_ROOT_PATH.'/rmcommon/menu.class.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/bulletin.class.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/plugin.class.php';

/**
 * Si la versión de XOOPS es menor a XOOPS 2.2
 * entonces incluimos el soporte para SMARTY
 */
if (!class_exists('XoopsTpl')){
	include_once XOOPS_ROOT_PATH . '/class/template.php';
}

if (isset($xoopsTpl)){
	$tpl =& $xoopsTpl;
} else {
	$tpl = new XoopsTpl();
}

$tpl->assign('xoops_url', XOOPS_URL);
$tpl->assign('rmb_url', XOOPS_URL . '/modules/rmbulletin');
$tpl->assign('rmb_path', XOOPS_ROOT_PATH . '/modules/rmbulletin');
$tpl->assign('xoops_language', $xoopsConfig['language']);


include_once 'functions.php';
?>