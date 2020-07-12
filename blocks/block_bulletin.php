<?php
/*******************************************************************
* $Id: block_bulletin.php,v 1.0 10/09/2006 00:20 BitC3R0 Exp $     *
* ------------------------------------------------------------     *
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
* ------------------------------------------------------------     *
* block_bulletin.php:                                              *
* Bloque para mostrar opciones del boletín                         *
* ------------------------------------------------------------     *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 10/09/2006 12:20:21 a.m.                            *
*******************************************************************/

function block_rmb_bulletin($options){
	
	$block = array();
	$block['msg'] = _RMB_SUSCRIBEMSG;
	$block['formurl'] = XOOPS_URL.'/modules/rmbulletin/suscribe.php';
	$block['lang_submit'] = _RMB_SUSCRIBE;
	$block['lang_yourmail'] = _RMB_YOUREMAIL;
	$block['lang_archive'] = _RMB_ARCHIVE;
	return $block;
	
}

?>
