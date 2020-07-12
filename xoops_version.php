<?php
// $Id: xoops_version.php,v 0.1.2 09/05/2006 14:16 BitC3R0 Exp $  //
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
// @version: 0.9	                                              //

$modversion['name'] = _MI_RMNL_MODNAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_RMNL_MODDESC;
$modversion['author'] = "(BitC3R0) http://www.redmexico.com.mx";
$modversion['credits'] = "BitC3R0 - Red México Soft";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "rmbulletin";
$modversion['iconbig'] = 'images/icon_big.png';
$modversion['iconsmall'] = 'images/icon_small.png';

// Administración
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['hasMain'] = 1;

// Archivo SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tablas
$modversion['tables'][0] = "rmb_boletines";
$modversion['tables'][1] = "rmb_configoptions";
$modversion['tables'][2] = "rmb_configs";
$modversion['tables'][3] = "rmb_content";
$modversion['tables'][4] = "rmb_emails";
$modversion['tables'][5] = "rmb_plugins";
$modversion['tables'][6] = "rmb_sections";
$modversion['tables'][7] = "rmb_users";

$modversion['templates'][1]['file'] = 'rmb_archive.html';
$modversion['templates'][1]['description'] = '';

/**
 * Opciones de Configuración
 */
 
// Formato de Fecha
$modversion['config'][1]['name'] = 'format_date';
$modversion['config'][1]['title'] = '_MI_RMB_FORMATDATE';
$modversion['config'][1]['description'] = '_MI_RMB_FORMATDATE_DESC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = "d/m/Y H:i:s";

// Tipo de Editor
$modversion['config'][2]['name'] = 'editor';
$modversion['config'][2]['title'] = '_MI_RMB_EDITORTYPE';
$modversion['config'][2]['description'] = '';
$modversion['config'][2]['formtype'] = 'select';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = "tiny";
$modversion['config'][2]['options'] = array(
											_MI_RMB_FORM_DHTML=>'dhtml',
											_MI_RMB_FORM_COMPACT=>'textarea',
											_MI_RMB_FORM_TINY=>'tiny',
											_MI_RMB_FORM_HTMLAREA=>'htmlarea',
											_MI_RMB_FORM_FCK=>'fckeditor'
											);

// Formato de Fecha
$modversion['config'][3]['name'] = 'multimails';
$modversion['config'][3]['title'] = '_MI_RMB_MULTIMAILS';
$modversion['config'][3]['description'] = '_MI_RMB_MULTIMAILS_DESC';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 1;

// Email rmitente
$modversion['config'][4]['name'] = 'from';
$modversion['config'][4]['title'] = '_MI_RMB_FROM';
$modversion['config'][4]['description'] = '';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = $xoopsConfig['adminmail'];

// Email rmitente
$modversion['config'][5]['name'] = 'fromname';
$modversion['config'][5]['title'] = '_MI_RMB_FROMNAME';
$modversion['config'][5]['description'] = '';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = $xoopsConfig['sitename'];

// Número de emails simultáneos en el envío por lotes
$modversion['config'][6]['name'] = 'maxnum';
$modversion['config'][6]['title'] = '_MI_RMB_MAXNUMSEND';
$modversion['config'][6]['description'] = '';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 10;

// Eliminar de la base de datos después de enviar
$modversion['config'][7]['name'] = 'delete';
$modversion['config'][7]['title'] = '_MI_RMB_DELETEAFTER';
$modversion['config'][7]['description'] = '';
$modversion['config'][7]['formtype'] = 'yesno';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 1;


// Blocks
$modversion['blocks'][1]['file'] = "block_bulletin.php";
$modversion['blocks'][1]['name'] = _MI_BK_BULLETIN;
$modversion['blocks'][1]['description'] = "";
$modversion['blocks'][1]['show_func'] = "block_rmb_bulletin";
$modversion['blocks'][1]['edit_func'] = "";
$modversion['blocks'][1]['template'] = 'bulletin.html';
?>