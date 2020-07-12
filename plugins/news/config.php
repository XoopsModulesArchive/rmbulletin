<?php
// $Id: config.php,v 0.4 29/11/2006 20:40 BitC3R0 Exp $  //
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
// @version: 0.4	                                              //

// Datos generales del plugin
$plugin_info['name'] = 'name';
$plugin_info['desc'] = 'description';
$plugin_info['module'] = 'news';
$plugin_info['author'] = "BitC3R0";
$plugin_info['url'] = "http://www.redmexico.com.mx/modules/rmmf/";
$plugin_info['help'] = "http://www.xoops-mexico.net/modules/rmlib";
$plugin_info['logo'] = "images/logo.png";
$plugin_info['version'] = "1.0";
$plugin_info['dir'] = 'news';
$plugin_info['main'] = 'RMBNews';

// Configuraciones del Módulo
$plugin_config[0]['name'] = 'preview_length';
$plugin_config[0]['caption'] = 'preview_caption';
$plugin_config[0]['desc'] = 'preview_desc';
$plugin_config[0]['type'] = 'text';
$plugin_config[0]['valuetype'] = 'int';
$plugin_config[0]['default'] = 150;

$plugin_config[1]['name'] = 'bol_length';
$plugin_config[1]['caption'] = 'bol_caption';
$plugin_config[1]['desc'] = 'bol_desc';
$plugin_config[1]['type'] = 'text';
$plugin_config[1]['valuetype'] = 'int';
$plugin_config[1]['default'] = 350;

$plugin_config[2]['name'] = 'newsnumber';
$plugin_config[2]['caption'] = 'newsnum_caption';
$plugin_config[2]['desc'] = '';
$plugin_config[2]['type'] = 'text';
$plugin_config[2]['valuetype'] = 'int';
$plugin_config[2]['default'] = 10;

$plugin_config[3]['name'] = 'dateformat';
$plugin_config[3]['caption'] = 'dateformat_caption';
$plugin_config[3]['desc'] = '';
$plugin_config[3]['type'] = 'text';
$plugin_config[3]['valuetype'] = 'text';
$plugin_config[3]['default'] = 'Y/m/d';

?>