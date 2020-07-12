<?php
/*******************************************************************
* $Id: header.php,v 1.0 09/09/2006 23:05 BitC3R0 Exp $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* header.php:                                                      *
* Archivo cargador de clases                                       *
* ----------------------------------------------------             *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 09/09/2006 11:05:40 p.m.                            *
*******************************************************************/

require '../../mainfile.php';

require XOOPS_ROOT_PATH.'/rmcommon/object.class.php';
require XOOPS_ROOT_PATH.'/rmcommon/form.class.php';
require 'class/user.class.php';

if (isset($template)) $xoopsOption['template_main'] = $template;
include '../../header.php';
$db =& Database::getInstance();
$mc =& $xoopsModuleConfig;
$tpl =& $xoopsTpl;
$myts =& MyTextSanitizer::getInstance();



?>