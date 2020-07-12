<?php
/*******************************************************************
* $Id: modinfo.php,v 1.0.2 09/05/2006 14:15 BitC3R0 Exp $          *
* -------------------------------------------------------          *
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
* -------------------------------------------------------          *
* modinfo.php:                                                     *
* Archivo de lenguage para la instalación/Configuración            *
* del Sistema                                                      *
* -------------------------------------------------------          *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0.2                                                  *
* @modificado: 09/05/2006 02:15:03 p.m.                            *
*******************************************************************/

// INFORMACIÓN DEL MÓDULO
define('_MI_RMNL_MODNAME','RMSOFT Bulletin 1.0');
define('_MI_RMNL_MODDESC','M&oacute;dulo para el env&iacute;o y publicaci&oacute;n de bolet&iacute;nes peri&oacute;dicos');

// Menu del Administrador
define('_AM_RMNL_MENU0','Estado del Módulo');
define('_AM_RMNL_MENU1','Archivo de Boletines');
define('_AM_RMNL_MENU2','Usuarios');
define('_AM_RMNL_MENU3','Plugins');
define('_AM_RMNL_MENU4','Boletines Enviados');
define('_AM_RMNL_MENU5','Correo Electrónico');
define('_AM_RMNL_MENU6','Acerca de...');

// Opciones de Configuración
define('_MI_RMB_FORMATDATE','Formato de Fecha:');
define('_MI_RMB_FORMATDATE_DESC','Utilice el formato de fecha est&aacute;ndar de PHP. <a href="http://mx2.php.net/manual/es/function.date.php" target="_blank">Vea la documentaci&oacute;n en l&iacute;nea</a>.');
define('_MI_RMB_EDITORTYPE','Editor para utilizar:');
define('_MI_RMB_MULTIMAILS','Utilizar múltiples cuentas de Email');
define('_MI_RMB_MULTIMAILS_DESC','Al activar esta opción se permite al módulo enviar los boletines a través de diferentes cuentas de email.');
define('_MI_RMB_LIMITMAIL','Número de emails por cada cuenta');
define('_MI_RMB_FROM','Email del Remitente');
define('_MI_RMB_FROMNAME','Nombre del Remitente');
define('_MI_RMB_MAXNUMSEND','Número de envíos simúltaneos en el envío por lotes');
define('_MI_RMB_DELETEAFTER','¿Eliminar contenido de la base de datos depués de enviar?');

// Tipo de editores
define("_MI_RMB_FORM_COMPACT","Compacto");
define("_MI_RMB_FORM_DHTML","DHTML");
define("_MI_RMB_FORM_TINY","TinyMCE Editor");
define("_MI_RMB_FORM_HTMLAREA","Editor HtmlArea");
define("_MI_RMB_FORM_FCK","Editor FCK");
define("_MI_RMB_FORM_INDITE","Indite");

// Bloques
define('_MI_BK_BULLETIN','Nuestro Boletín');
?>