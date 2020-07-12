<?php
// $Id: admin.php,v 0.7 01/12/2006 15:05 BitC3R0 Exp $ 			  //
// -------------------------------------------------------------  //
// RMSOFT Bulletin 1.0                                            //
// Bolet�n Informativo Avanzado                                   //
// CopyRight � 2006. Red M�xico Soft                              //
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
// @copyright: � 2006. BitC3R0.                                   //
// @author: BitC3R0                                               //
// @package: RMSOFT Bulletin 1.0                                  //
// @version: 0.7	                                              //

define('_AM_RMB_CURSTATE','Estado del M�dulo');
define('_AM_RMB_BOLSTITLE','Boletines Existentes');
define('_AM_RMB_BULLETINS','Boletines');
define('_AM_RMB_NEWBULL','Nuevo Bolet&iacute;n');
define('_AM_RMB_USERSSUB','Usuarios');
define('_AM_RMB_PLUGINS','Plugins');
define('_AM_RMB_SENDED','Enviados');
define('_AM_RMB_EMAILCONFIG','Servidores SMTP');
define('_AM_RMB_MOREPLUGS','Mas Plugins');
define('_AM_RMB_MORETPLS','Mas Plantillas');
define('_AM_RMB_ABOUTMOD','RMSOFT Bulletin');
define('_AM_RMB_DBERROR', 'Ocurrieron errores al realizar esta operaci�n:');
define('_AM_RMB_DBOK','Base de datos actualizada satisfactoriamente');
define('_AM_RMBS_ERRSESS','Identificador de sesi�n no v�lido');

define('_AM_RMB_CONTENT','Contenido');
define('_AM_RMB_EDIT','Editar Bolet�n');
define('_AM_RMB_SECTIONS','Secciones');
define('_AM_RMB_PREVIEW','Previsualizar');
/**
 * Boletines
 */
switch (RMBULLETIN_LOCATION){
	case 'index':
		// ESTADO DEL M�DULO
		define('_AM_RMB_BOLSCOUNT','%s Boletines');
		define('_AM_RMB_SEEDETAILS','Ver Detalles');
		define('_AM_RMB_SENTCOUNT','%s Enviados');
		define('_AM_RMB_USERSCOUNT','%s Usuarios');
		define('_AM_RMB_EMAILCOUNT','%s Emails');
		define('_AM_RMB_PLUGSCOUNT','%s Plugins');
		define('_AM_RMB_INFO','Informaci�n');
		define('_AM_RMAD_VISIT','Visitar');
		define('_AM_RMB_HELUPS','Ay�danos a seguir creando software libre');
		define('_AM_RMB_RUNNING','Estas ejecutando <strong>%s</strong> <strong>%s</strong>');
		
		define('_AM_RMB_CONFIGUSE','Configuraci�n y Uso');
		define('_AM_RMB_NEWTITLE','Nuevo Bolet&iacute;n Informativo');
		define('_AM_RMB_EDITTITLE','Editar Bolet&iacute;n "%s"');
		define('_AM_RMB_TITLE','T&iacute;tulo');
		define('_AM_RMB_CREATED','Creado');
		define('_AM_RMB_DELETAFTER','Eliminar');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMB_FTITLE','T&iacute;tulo:');
		define('_AM_RMB_FINTRO','Introducci&oacute;n:');
		define('_AM_RMB_PUBLISHDATE','Fecha de Publicaci&oacute;n:');
		define('_AM_RMB_DAY','D&iacute;a');
		define('_AM_RMB_MONTH','Mes');
		define('_AM_RMB_YEAR','A&ntilde;o');
		define('_AM_RMB_HOUR','Hora');
		define('_AM_RMB_MINUTE','Minuto');
		define('_AM_RMB_SECOND','Segundo');
		define('_AM_RMB_NOTITLE','Por favor escribe un titulo para este bolet&iacute;n');
		define('_AM_RMB_ERRONSAVE','Ocurri&oacute; un error al intentar guardar los datos:<br /><br />');
		define('_AM_RMB_ERRONDELETE','Ocurri&oacute; un error al intentar eliminar los datos:<br /><br />');
		define('_AM_RMB_DELCONFIRM','&iquest;Realmente deseas eliminar "%s"?');
		define('_AM_RMB_PLUGIN','Plugin');
		define('_AM_RMB_SELECTPLUGIN','Selecciona un Plugin...');
		define('_AM_RMB_LOADPLUGIN','Cargar Plugin');
		define('_AM_RMB_ARCHIVAR','Archivar despu�s de enviado');
		define('_AM_RMB_DELAFTER','Eliminar este bolet�n en una fecha espec�fica');
		define('_AM_RMB_DELDATE','Fecha de Eliminaci�n');
		define('_AM_RMB_DELDATE_DESC','Solo si se ha activado la casilla anterior');
		define('_AM_RMB_TEMPLATE','Plantilla');
		define('_AM_RMB_SEND','Enviar');
		
		// Secciones
		define('_AM_RMB_TITLESEC','Seccionde de %s');
		define('_AM_RMB_ORDER','Orden');
		define('_AM_RMB_NEWSECTION','Nueva Secci�n');
		define('_AM_RMB_EDITSECTION','Editar Secci�n');
		define('_AM_RMB_SECTIONEXISTS','Ya existe la secci�n especificada');
		define('_AM_RMB_NOTITLESEC','Por favor escribe un t�tulo para la secci�n');
		define('_AM_RMB_DELCONFSEC','�Realmente deseas eliminar esta secci�n?');
	
		// ERRORES
		define('_AM_RMB_BOLNOSPECIFY','No has especificado un bolet&iacute;n para editar');
		define('_AM_RMB_NOSECTION','NO especificaste una secci�n v�lida para editar');
		define('_AM_RMB_SECTIONNOEXISTS','No existe la secci�n especificada');
		define('_AM_RMB_WRONGCOL','La columna especificada es incorrecta');
		define('_AM_RMB_NOTINSTALLED','El m�dulo %s no esta instalado');
		
		break;
	
	case 'bulletins':
	
		define('_AM_RMB_CONTENTTITLE','Contenido del Bolet�n');
		define('_AM_RMB_CONTPREVIEW','Vista Previa');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMB_MODULE','Plugin');
		define('_AM_RMB_NEWCONTENTTITLE','Crear Contenido');
		define('_AM_RMB_EDITCONTENTTITLE','Editar Contenido');
		define('_AM_RMB_SELECTSECTION','Selecciona una secci�n del bolet�n');
		define('_AM_RMB_SECTION','Secci�n');
		define('_AM_RMB_SENDBOL','Enviar "%s"');
		define('_AM_RMB_LOTES','Enviar Ahora');
		define('_AM_RMB_AUTO','Envio Autom�tico');
		define('_AM_RMB_EMAILSTO','Usuarios Suscritos a los que se enviar� el correo');
		define('_AM_RMB_MARKNO','Marca las casillas correspondientes a las direcciones a las que no deseas enviar el bolet�n');
		define('_AM_RMB_ALREADYSEND','El bolet�n especificado ya ha sido enviado anteriormente');
		define('_AM_RMB_SENDOK','Se ha enviado el bolet�n a todos los usuarios');
		define('_AM_RMB_SENDINGNOW','Se esta enviando el bolet�n');
		define('_AM_RMB_DEPENDS','Dependiendo del n�mero de usuarios el env�o puede tomar varios minutos.');
		define('_AM_RMB_YOUCANCEL','Puedes cancelar el proceso en cualquier momento oprimiendo el bot�n "CANCEL"');
		define('_AM_RMB_RESTING','Restan <strong>%s</strong> usuarios');
		
		define('_AM_RMB_UNSUSCRIBE','Si ya no deseas recibir este bolet�n por favor haz click en este enlace');
		define('_AM_RMB_BOLSENDED','Bolet�n enviado satisfactoriamente');
		
		// Errores
		define('_AM_RMB_ERRPLUGNAME','No se encontr� el plugin especificado');
		
		break;
	
	case 'sended':
	
		define('_AM_RMB_TITLE','T&iacute;tulo');
		define('_AM_RMB_CREATED','Creado');
		define('_AM_RMB_PUBLISH','Publicaci&oacute;n');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMB_VIEW','Ver');
		define('_AM_RMB_ASNOTSEND','Marcar como "No Enviado"');
		define('_AM_RMB_DELCONFIRM','&iquest;Realmente deseas eliminar "%s"?');
		
		# ERRORES
		define('_AM_RMB_NOTVALID','El bolet�n especificado no es v�lido');
		define('_AM_RMB_NOTEXISTS','No existe el bolet�n especificado');
		
		break;
		
	case 'plugins':
		
		define('_AM_RMB_INSTALLED','Plugins Instalados');
		define('_AM_RMB_NOINSTALLED','Plugins No Instalados');
		define('_AM_RMB_NAME','Nombre');
		define('_AM_RMB_AUTHOR','Autor');
		define('_AM_RMB_VERSION','Versi�n');
		define('_AM_RMB_MODULE','M�dulo');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMG_INSTALL','Instalar Plugin');
		define('_AM_RMB_PLUGINSTALLED','Instalado "%s".');
		define('_AM_RMB_INSERTED','Datos del Plugin Guardados');
		define('_AM_RMB_CONFIGINSERT','Insertada opci�n de configuraci�n <strong style="color: #FF9900">%s</strong>');
		define('_AM_RMB_CONFIGUPDATED','Actualizada opci�n de configuraci�n <strong style="color: #FF9900">%s</strong>');
		define('_AM_RMB_OPTINSERT','Insertada la opci�n <strong>%s</strong>');
		define('_AM_RMB_CONFIGDEL','Eliminada la opci�n de configuraci�n <strong>%s</strong>');
		define('_AM_RMB_CONFIRMDEL','�Realmente deseas eliminar este plugin?');
		define('_AM_RMB_BACKPLUGS','Volver a los Plugins');
		define('_AM_RMB_MOREPLUGINS','Plugins Personalizados para RMSOFT Bulletin');
		
		define('_AM_RMB_STARTUPD','Iniciando actualizaci�n del Plugin');
		define('_AM_RMB_CONFIRMUPD','�Realmente deseas actualizar este plugin?');
		define('_AM_RMB_UPDATE','Actualizar');
		define('_AM_RMB_UPDATEOK','Actualizaci�n completada');
		define('_AM_RMB_PLUGVALUESOK','Datos del plugin actualizados');
		
		// Configuraci�n
		define('_AM_RMB_TITLEFCONFIG','Configurar Plugin');
		define('_AM_RMB_CONFIGSAVED','Se ha guardado la nueva configuraci�n');
		
		// Errores
		define('_AM_RMB_ERRDIR','�No existe el directorio de plugins!<br />Por favor corrige este problema.');
		define('_AM_RMB_ERRPLUGNAME','No se encontr� el plugin especificado');
		define('_RM_RMB_ERRCONFIG','Ocurri� un error al insertar la opci�n <strong>%s</strong>');
		define('_AM_RMB_ERRUPDPLUG','Ocurri� un error al actualizar los datos del plugin');
		
		// Desinstlaci�n
		define('_AM_RMB_UNINSTALLSTART','Iniciando la desinstalaci�n del plugin');
		define('_AM_RMB_UNINSTALLOK','Plugin eliminado correctamente');
		define('_AM_RMB_CONFIGSDEL','Opciones de configuraci�n eliminadas');
		define('_AM_RMB_INSTALLSR','Ejecutando script de instalaci�n');
		define('_AM_RMB_INSTALLSF','Finalizado script de instalaci�n');
		define('_AM_RMB_UPDATESR','Ejecutando script de actualizaci�n');
		define('_AM_RMB_UPDATESF','Finalizado script de actualizaci�n');
		define('_AM_RMB_UNINSTALLSR','Ejecutando script de desinstalaci�n');
		define('_AM_RMB_UNINSTALLSF','Finalizado script de desinstalaci�n');
	
		break;
	
	case 'users':
	
		define('_AM_RMB_TABLETITLE','Usuarios Inscritos al Bolet�n');
		define('_AM_RMB_USER','Usuario');
		define('_AM_RMB_EMAIL','Direcci�n');
		define('_AM_RMB_REGISTER','Registrado');
		define('_AM_RMB_DATE','Fecha');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMB_MSGADDX','Esta acci�n suscribir� a todos los usuarios registrados en XOOPS que acepten correo electr�nico');
		define('_AM_RMB_CONFIRMCONTINUE','�Deseas Continuar?');
		define('_AM_RMB_ADDXOOPSU','Agregar Usuarios XOOPS');
		define('_AM_RMB_ADDUSER','Suscribir Usuario');
		define('_AM_RMB_FMAIL','Correo Electr�nico');
		define('_AM_RMB_XUSER','Usuario XOOPS');
		define('_AM_RMB_NONE','No es usuario XOOPS');
		define('_RM_RMB_DELETEMSG','�Esta acci�n eliminar� la direcci�n "<strong>%s</strong>" de la base de datos!');
		define('_AM_RMB_REGTOTAL','Usuarios Registrados: <strong>%s</strong>');
		define('_AM_RMB_PAGE','P�gina: ');
		define('_AM_RMB_SHOWING','Mostrando usuarios <strong>%s</strong> a <strong>%s</strong>');
		define('_AM_RMB_SEARCH','Buscar:');
		
		break;
		
	case 'email':
	
		define('_AM_RMB_TBLTITLE','Cuentas de Email');
		define('_AM_RMB_SERVER','Servidor SMTP');
		define('_AM_RMB_ACCOUNT','Usuario');
		define('_AM_RMB_LIMIT','Limite de Envios');
		define('_AM_RMB_OPTIONS','Opciones');
		define('_AM_RMB_FORMTITLE','Cuentas de Email');
		define('_AM_RMB_LOGINU','Nombre de Usuario');
		define('_AM_RMB_PASSWORD','Contrase�a');
		define('_AM_RMB_FROMMAIL','Email para el valor FROM');
		define('_AM_RMB_FROMMAIL_DESC','Algunos servidores solo permiten en el campo FROM la misma deirecci�n de la cuenta de usuario.');
		
		define('_RM_RMB_DELETEMSG','�Esta acci�n eliminar� la direcci�n "<strong>%s</strong>" de la base de datos!');
		define('_AM_RMB_CONFIRMCONTINUE','�Deseas Continuar?');
		define('_AM_RMB_NOMULTIMAIL','La opci�n para enviar a trav�s de m�tliples cuentas de email esta desactivada.');
		
		// ERRORES
		define('_AM_RMB_ERRSMTP','No especificaste el servidor SMTP para esta cuenta');
		define('_AM_RMB_ERRUSER','No especificaste el usuario para esta cuenta');
		define('_AM_RMB_ERRPASS','No especificaste la contrase�a para esta cuenta');
	
	case 'about':
		
		define('_AM_RMB_DESC','M�dulo para el manejo y env�o de boletines en formato HTML.');
		define('_AM_RMB_DESCBIG','RMSOFT Bulletin te permite manejar suscripciones de usuarios, enviar boletines en formato HTML mediante distintos servidores SMTP o utilizando el motor de emails interno de XOOPS.');
		define('_AM_RMB_DOWNMORE','Descarga mas m�dulos gratis desde <a href="http://www.xoopsmexico.net">XOOPS M�xico</a>');
		
}

?>