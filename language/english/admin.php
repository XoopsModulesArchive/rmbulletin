<?php
// $Id: admin.php,v 0.7 01/12/2006 15:05 BitC3R0 Exp $ 			  //
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

define('_AM_RMB_CURSTATE','Module State');
define('_AM_RMB_BOLSTITLE','Existing Bulletins');
define('_AM_RMB_BULLETINS','Bulletins');
define('_AM_RMB_NEWBULL','New Bulletin');
define('_AM_RMB_USERSSUB','Users');
define('_AM_RMB_PLUGINS','Plugins');
define('_AM_RMB_SENDED','Sent');
define('_AM_RMB_EMAILCONFIG','SMTP Servers');
define('_AM_RMB_MOREPLUGS','More Plugins');
define('_AM_RMB_MORETPLS','More Templates');
define('_AM_RMB_ABOUTMOD','RMSOFT Bulletin');
define('_AM_RMB_DBERROR', 'The next errors happened trying this action:');
define('_AM_RMB_DBOK','Database updated successfully');
define('_AM_RMBS_ERRSESS','Session ID expired');

define('_AM_RMB_CONTENT','Content');
define('_AM_RMB_EDIT','Edit Bulletin');
define('_AM_RMB_SECTIONS','Sections');
define('_AM_RMB_PREVIEW','Preview');
/**
 * Boletines
 */
switch (RMBULLETIN_LOCATION){
	case 'index':
		// ESTADO DEL MÓDULO
		define('_AM_RMB_BOLSCOUNT','%s Bulletins');
		define('_AM_RMB_SEEDETAILS','See Details');
		define('_AM_RMB_SENTCOUNT','%s Sent');
		define('_AM_RMB_USERSCOUNT','%s Users');
		define('_AM_RMB_EMAILCOUNT','%s Emails');
		define('_AM_RMB_PLUGSCOUNT','%s Plugins');
		define('_AM_RMB_INFO','Information');
		define('_AM_RMAD_VISIT','Visit');
		define('_AM_RMB_HELUPS','Help us to carry on developing free modules');
		define('_AM_RMB_RUNNING','You are running <strong>%s</strong> <strong>%s</strong>');
		
		define('_AM_RMB_CONFIGUSE','Use and Configuration');
		define('_AM_RMB_NEWTITLE','New Bulletin');
		define('_AM_RMB_EDITTITLE','Editing "%s"');
		define('_AM_RMB_TITLE','Title');
		define('_AM_RMB_CREATED','Created');
		define('_AM_RMB_DELETAFTER','Delete');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMB_FTITLE','Title:');
		define('_AM_RMB_FINTRO','Introduction:');
		define('_AM_RMB_PUBLISHDATE','Publication Date:');
		define('_AM_RMB_DAY','Day');
		define('_AM_RMB_MONTH','Month');
		define('_AM_RMB_YEAR','Year');
		define('_AM_RMB_HOUR','Hour');
		define('_AM_RMB_MINUTE','Minute');
		define('_AM_RMB_SECOND','Second');
		define('_AM_RMB_NOTITLE','You must provide a title for this bulletin');
		define('_AM_RMB_ERRONSAVE','An error happened saving the bulletin data:<br /><br />');
		define('_AM_RMB_ERRONDELETE','An error happended trying to delete this bulletin:<br /><br />');
		define('_AM_RMB_DELCONFIRM','Wo you really want to delete "%s"?');
		define('_AM_RMB_PLUGIN','Plugin');
		define('_AM_RMB_SELECTPLUGIN','Select a Plugin...');
		define('_AM_RMB_LOADPLUGIN','Load Plugin');
		define('_AM_RMB_ARCHIVAR','Save after send');
		define('_AM_RMB_DELAFTER','Delete this bulletin on a specified date');
		define('_AM_RMB_DELDATE','Elimination Date');
		define('_AM_RMB_DELDATE_DESC','Only if previous checkbox has been marked');
		define('_AM_RMB_TEMPLATE','Template');
		define('_AM_RMB_SEND','Send');
		
		// Secciones
		define('_AM_RMB_TITLESEC','%s Section');
		define('_AM_RMB_ORDER','Order');
		define('_AM_RMB_NEWSECTION','New Section');
		define('_AM_RMB_EDITSECTION','Edit Section');
		define('_AM_RMB_SECTIONEXISTS','This section already exists');
		define('_AM_RMB_NOTITLESEC','You must provide a title for this section');
		define('_AM_RMB_DELCONFSEC','Do you really want to delete this section?');
	
		// ERRORES
		define('_AM_RMB_BOLNOSPECIFY','You must to specify a bulletin to edit');
		define('_AM_RMB_NOSECTION','The specified section is not valid');
		define('_AM_RMB_SECTIONNOEXISTS','The specified section does not exists');
		define('_AM_RMB_NOTINSTALLED','The module "%s" is not installed yet');
		
		break;
	
	case 'bulletins':
	
		define('_AM_RMB_CONTENTTITLE','Bulletin Content');
		define('_AM_RMB_CONTPREVIEW','Preview');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMB_MODULE','Plugin');
		define('_AM_RMB_NEWCONTENTTITLE','Create Content');
		define('_AM_RMB_EDITCONTENTTITLE','Edit Content');
		define('_AM_RMB_SELECTSECTION','Select a bulletin section');
		define('_AM_RMB_SECTION','Section');
		define('_AM_RMB_SENDBOL','Send "%s"');
		define('_AM_RMB_LOTES','Send Now!');
		define('_AM_RMB_AUTO','Send Automatically');
		define('_AM_RMB_EMAILSTO','This bulletins will send to next users');
		define('_AM_RMB_MARKNO','Mark the checkbox correponding to users that you do not wish to send this bulletin');
		define('_AM_RMB_ALREADYSEND','This bulletin has been sent already previously');
		define('_AM_RMB_SENDOK','This bulletins has been sent successfully');
		define('_AM_RMB_SENDINGNOW','The sending is in progress');
		define('_AM_RMB_DEPENDS','Depending of the users number this action may take several minutes.');
		define('_AM_RMB_YOUCANCEL','You can cancel this process in any moment by clicking the "CANCEL" button');
		define('_AM_RMB_RESTING','<strong>%s</strong> users left');
		
		define('_AM_RMB_UNSUSCRIBE','If you do not wish to receive this bulletin, click in this link');
		define('_AM_RMB_BOLSENDED','Bulletin sent successfully');
		
		// Errores
		define('_AM_RMB_ERRPLUGNAME','The specified plugin does not exists');
		
		break;
	
	case 'sended':
	
		define('_AM_RMB_TITLE','Title');
		define('_AM_RMB_CREATED','Created');
		define('_AM_RMB_PUBLISH','Publication');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMB_VIEW','See');
		define('_AM_RMB_ASNOTSEND','Mark as "Not Sent"');
		define('_AM_RMB_DELCONFIRM','Do you really want to delete "%s"?');
		
		# ERRORES
		define('_AM_RMB_NOTVALID','The especified bulletin is not valid');
		define('_AM_RMB_NOTEXISTS','The specified bulletin does not exists');
		
		break;
		
	case 'plugins':
		
		define('_AM_RMB_INSTALLED','Installed Plugins');
		define('_AM_RMB_NOINSTALLED','Not Installed Plugins');
		define('_AM_RMB_NAME','Name');
		define('_AM_RMB_AUTHOR','Author');
		define('_AM_RMB_VERSION','Version');
		define('_AM_RMB_MODULE','Module');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMG_INSTALL','Install Plugin');
		define('_AM_RMB_PLUGINSTALLED','Installing "%s".');
		define('_AM_RMB_INSERTED','Plugin Data Saved');
		define('_AM_RMB_CONFIGINSERT','Option <strong style="color: #FF9900">%s</strong> inserted');
		define('_AM_RMB_CONFIGUPDATED','Option <strong style="color: #FF9900">%s</strong> updated');
		define('_AM_RMB_OPTINSERT','Option <strong>%s</strong> inserted');
		define('_AM_RMB_CONFIGDEL','Options <strong>%s</strong> deleted');
		define('_AM_RMB_CONFIRMDEL','do you really want to delete this plugin?');
		define('_AM_RMB_BACKPLUGS','Back to Plugin');
		define('_AM_RMB_MOREPLUGINS','Custom plugins for RMSOFT Bulletin');
		
		define('_AM_RMB_STARTUPD','Updating Plugin');
		define('_AM_RMB_CONFIRMUPD','Do you really want to update this plugin?');
		define('_AM_RMB_UPDATE','Update');
		define('_AM_RMB_UPDATEOK','Update Finish!');
		define('_AM_RMB_PLUGVALUESOK','Plugin data updated');
		
		// Configuración
		define('_AM_RMB_TITLEFCONFIG','Configure Plugin');
		define('_AM_RMB_CONFIGSAVED','Configuration Saved');
		
		// Errores
		define('_AM_RMB_ERRDIR','¡The plugins dir does not exists!<br />Please fiz this problem.');
		define('_AM_RMB_ERRPLUGNAME','The specified plugin does not found');
		define('_RM_RMB_ERRCONFIG','An error happened while inserting <strong>%s</strong>');
		define('_AM_RMB_ERRUPDPLUG','An error happened while updating this plugin');
		
		// Desinstlación
		define('_AM_RMB_UNINSTALLSTART','Uninstalling Plugin');
		define('_AM_RMB_UNINSTALLOK','Plugin deleted successfully');
		define('_AM_RMB_CONFIGSDEL','Configuration Options Deleted');
		define('_AM_RMB_INSTALLSR','Running Installation Script');
		define('_AM_RMB_INSTALLSF','Installation Script Finished!');
		define('_AM_RMB_UPDATESR','Update Script Running');
		define('_AM_RMB_UPDATESF','Update Script Finished!');
		define('_AM_RMB_UNINSTALLSR','Uninstallation Script Running');
		define('_AM_RMB_UNINSTALLSF','Uninstallation Script Finished!');
	
		break;
	
	case 'users':
	
		define('_AM_RMB_TABLETITLE','Suscribed Users');
		define('_AM_RMB_USER','Users');
		define('_AM_RMB_EMAIL','Address');
		define('_AM_RMB_REGISTER','Registered');
		define('_AM_RMB_DATE','Date');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMB_MSGADDX','This action will suscribe all XOOPS registered users.');
		define('_AM_RMB_CONFIRMCONTINUE','Continue?');
		define('_AM_RMB_ADDXOOPSU','Add XOOPS Users');
		define('_AM_RMB_ADDUSER','Subscribe User');
		define('_AM_RMB_FMAIL','Email');
		define('_AM_RMB_XUSER','XOOPS User');
		define('_AM_RMB_NONE','Not is XOOPS User');
		define('_RM_RMB_DELETEMSG','This action will delete the address "<strong>%s</strong>" from the database!');
		define('_AM_RMB_REGTOTAL','Registered Users: <strong>%s</strong>');
		define('_AM_RMB_PAGE','Page: ');
		define('_AM_RMB_SHOWING','Showing users <strong>%s</strong> to <strong>%s</strong>');
		define('_AM_RMB_SEARCH','Search:');
		
		break;
		
	case 'email':
	
		define('_AM_RMB_TBLTITLE','Email Accounts');
		define('_AM_RMB_SERVER','SMTP Server');
		define('_AM_RMB_ACCOUNT','User');
		define('_AM_RMB_LIMIT','Max Send Limit');
		define('_AM_RMB_OPTIONS','Options');
		define('_AM_RMB_FORMTITLE','Email Accounts');
		define('_AM_RMB_LOGINU','Username');
		define('_AM_RMB_PASSWORD','Password');
		define('_AM_RMB_FROMMAIL','FROM value email');
		define('_AM_RMB_FROMMAIL_DESC','Some servers only allow relaying when this value is equal to the account email address.');
		
		define('_RM_RMB_DELETEMSG','This acction will delete the address "<strong>%s</strong>" from de database!');
		define('_AM_RMB_CONFIRMCONTINUE','Continue?');
		define('_AM_RMB_NOMULTIMAIL','The option to send trough several mails account is disabled.');
		
		// ERRORES
		define('_AM_RMB_ERRSMTP','You must to specify a SMTP server for this account');
		define('_AM_RMB_ERRUSER','You must provide a username');
		define('_AM_RMB_ERRPASS','You must provide a password');
	
	case 'about':
		
		define('_AM_RMB_DESC','Module that allows to send and management informative bulletins.');
		define('_AM_RMB_DESCBIG','RMSOFT Bulletin te permite manejar suscripciones de usuarios, enviar boletines en formato HTML mediante distintos servidores SMTP o utilizando el motor de emails interno de XOOPS.');
		define('_AM_RMB_DOWNMORE','More free modules at <a href="http://www.xoopsmexico.net">XOOPS México</a>!');
		
}

?>