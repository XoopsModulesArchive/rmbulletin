<?php
/*******************************************************************
* $Id: menu.php,v 1.0.2 09/05/2006 14:14 BitC3R0 Exp $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* menu.php:                                                        *
* Archivo de menu para la sección administrativa                   *
* ----------------------------------------------------             *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0.2                                                  *
* @modificado: 09/05/2006 02:14:12 p.m.                            *
*******************************************************************/

$adminmenu[0]['title'] = _AM_RMNL_MENU0;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[0]['icon'] = 'images/home.png';
$adminmenu[1]['title'] = _AM_RMNL_MENU1;
$adminmenu[1]['link'] = "admin/index.php?op=show";
$adminmenu[1]['icon'] = 'images/boletines.png';
$adminmenu[2]['title'] = _AM_RMNL_MENU2;
$adminmenu[2]['link'] = "admin/users.php";
$adminmenu[2]['icon'] = 'images/users.png';
$adminmenu[3]['title'] = _AM_RMNL_MENU3;
$adminmenu[3]['link'] = "admin/plugins.php";
$adminmenu[3]['icon'] = 'images/plugins.png';
$adminmenu[4]['title'] = _AM_RMNL_MENU4;
$adminmenu[4]['link'] = "admin/sended.php";
$adminmenu[4]['icon'] = 'images/sent.png';
$adminmenu[5]['title'] = _AM_RMNL_MENU5;
$adminmenu[5]['link'] = "admin/email.php";
$adminmenu[5]['icon'] = 'images/emails.png';
$adminmenu[6]['title'] = _AM_RMNL_MENU6;
$adminmenu[6]['link'] = "admin/about.php";
$adminmenu[6]['icon'] = 'images/logosmall.png';

?>

