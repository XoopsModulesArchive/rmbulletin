<?php
// $Id: modinfo.php,v 0.7 01/12/2006 15:59 BitC3R0 Exp $ 		  //
// -------------------------------------------------------------  //
// RMSOFT Bulletin 1.0                                            //
// Boletín Informativo Avanzado                                   //
// CopyRight © 2006. Red México Soft                              //
// Autor: BitC3R0                                                 //
// http://www.redmexico.com.mx                                    //
// http://www.xoops-mexico.net                                    //
// --------------------------------------------                   //
// This program is free software; you can redistribute it and/or  //
// modify it under the terms of the GNU General Public License as //
// published by the Free Software Foundation; either version 2 of //
// the License, or (at your option) any later version.            //
//                                                                //
// This program is distributed in the hope that it will be useful,//
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the   //
// GNU General Public License for more details.                   //
//                                                                //
// You should have received a copy of the GNU General Public      //
// License along with this program; if not, write to the Free     //
// Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, //
// MA 02111-1307 USA                                              //
// -------------------------------------------------------------  //
// @copyright: © 2006. BitC3R0.                                   //
// @author: BitC3R0                                               //
// @package: RMSOFT Bulletin 1.0                                  //
// @version: 0.7	                                              //

// INFORMACIÓN DEL MÓDULO
define('_MI_RMNL_MODNAME','RMSOFT Bulletin 1.0');
define('_MI_RMNL_MODDESC','Module to send and management informative bulletins');

// Menu del Administrador
define('_AM_RMNL_MENU0','Módule State');
define('_AM_RMNL_MENU1','Bulletins Archive');
define('_AM_RMNL_MENU2','Users');
define('_AM_RMNL_MENU3','Plugins');
define('_AM_RMNL_MENU4','Sent Bulletins');
define('_AM_RMNL_MENU5','SMTP Mail');
define('_AM_RMNL_MENU6','About');

// Opciones de Configuración
define('_MI_RMB_FORMATDATE','Date Format');
define('_MI_RMB_FORMATDATE_DESC','Use the standar PHP format. <a href="http://php.net/manual/es/function.date.php" target="_blank">Online Docs</a>.');
define('_MI_RMB_EDITORTYPE','Editor to Use:');
define('_MI_RMB_MULTIMAILS','Use several SMTP Accounts');
define('_MI_RMB_MULTIMAILS_DESC','Enabling this option the module can send bulletins trough several email accounts. Configure this accounts ay SMTP Mail Section.');
define('_MI_RMB_LIMITMAIL','Número de emails por cada cuenta');
define('_MI_RMB_FROM','Sender Email');
define('_MI_RMB_FROMNAME','Sender Name');
define('_MI_RMB_MAXNUMSEND','Max number of simultaneus sends');
define('_MI_RMB_DELETEAFTER','Delete the Bulletin database content after send?');

// Tipo de editores
define("_MI_RMB_FORM_COMPACT","Compact");
define("_MI_RMB_FORM_DHTML","DHTML");
define("_MI_RMB_FORM_TINY","TinyMCE Editor");
define("_MI_RMB_FORM_HTMLAREA","HTMLArea Editor");
define("_MI_RMB_FORM_FCK","FCK Editor");
define("_MI_RMB_FORM_INDITE","Indite");

// Bloques
define('_MI_BK_BULLETIN','Our Bulletin');
?>