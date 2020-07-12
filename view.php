<?php
/*******************************************************************
* $Id: view.php,v 1.0 10/09/2006 01:20 BitC3R0 Exp $               *
* --------------------------------------------------               *
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
* --------------------------------------------------               *
* view.php:                                                        *
* Archivo para mostrar el contenido de los boletines pasados       *
* --------------------------------------------------               *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 10/09/2006 01:20:03 a.m.                            *
*******************************************************************/

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id<=0){
	header('location: '.XOOPS_URL);
	die();
}

define('XOOPS_ROOT_PATH', str_replace('/view.php', '', $_SERVER['SCRIPT_FILENAME']));

if (!file_exists(XOOPS_ROOT_PATH.'/cache/boletin-'.$id.'.html')){
	header('location: index.php');
	die();
}
	
include 'cache/boletin-'.$id.'.html';

?>