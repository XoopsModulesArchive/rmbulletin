<?php
// $Id: configs.php,v 0.1 29/11/2006 20:39 BitC3R0 Exp $  //
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
// @version: 0.1	                                              //

// Datos generales del plugin
$plugin_info['name'] = 'name';
$plugin_info['desc'] = 'description';
$plugin_info['module'] = 'newbb';
$plugin_info['author'] = "BitC3R0";
$plugin_info['url'] = "http://www.redmexico.com.mx/modules/rmmf/";
$plugin_info['help'] = "http://www.xoops-mexico.net/modules/rmlib";
$plugin_info['logo'] = "images/logo.png";
$plugin_info['version'] = "1.0";
$plugin_info['dir'] = 'forums';
$plugin_info['main'] = 'RMBForums';

// Configuraciones del Módulo
$plugin_config[0]['name'] = 'showmode';
$plugin_config[0]['caption'] = 'showmode';
$plugin_config[0]['desc'] = '';
$plugin_config[0]['type'] = 'select';
$plugin_config[0]['valuetype'] = 'int';
$plugin_config[0]['default'] = 1;
$plugin_config[0]['options'] = array('firstrecent'=>0,'mostactive'=>1);

/*// Agrupar temas
$plugin_config[1]['name'] = 'group';
$plugin_config[1]['caption'] = 'group';
$plugin_config[1]['desc'] = 'group_desc';
$plugin_config[1]['type'] = 'yesno';
$plugin_config[1]['valuetype'] = 'int';
$plugin_config[1]['default'] = 1; */

$plugin_config[1]['name'] = 'content';
$plugin_config[1]['caption'] = 'content';
$plugin_config[1]['desc'] = 'content_desc';
$plugin_config[1]['type'] = 'select';
$plugin_config[1]['valuetype'] = 'int';
$plugin_config[1]['default'] = 0;
$plugin_config[1]['options'] = array('nocontent'=>0,'contentold'=>1,'contentnew'=>2);

$plugin_config[2]['name'] = 'limit';
$plugin_config[2]['caption'] = 'limit';
$plugin_config[2]['desc'] = '';
$plugin_config[2]['type'] = 'textbox';
$plugin_config[2]['valuetype'] = 'int';
$plugin_config[2]['default'] = 20;

$plugin_config[3]['name'] = 'date';
$plugin_config[3]['caption'] = 'date';
$plugin_config[3]['desc'] = '';
$plugin_config[3]['type'] = 'textbox';
$plugin_config[3]['valuetype'] = 'text';
$plugin_config[3]['default'] = "d/m/Y - H:i:s";

?>