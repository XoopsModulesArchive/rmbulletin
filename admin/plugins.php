<?php
/*******************************************************************
* $Id: plugins.php,v 1.0 06/09/2006 12:56 BitC3R0 Exp $            *
* -----------------------------------------------------            *
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
* -----------------------------------------------------            *
* plugins.php:                                                     *
* Administración de Plugins                                        *
* -----------------------------------------------------            *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0                                                    *
* @modificado: 06/09/2006 12:56:33 p.m.                            *
*******************************************************************/

define('RMBULLETIN_LOCATION','plugins');

include 'header.php';

function showPlugins(){
	global $db;
	
	$path = XOOPS_ROOT_PATH.'/modules/rmbulletin/plugins/';
	
	if (!is_dir($path)){
		redirect_header('index.php', 0, _AM_RMB_ERRDIR);
		die();
	}
	
	xoops_cp_header();
	rmbMakeNav();
	
	$dir = opendir($path);
	$installed = array();
	$noinstalled = array();
	
	while ($obj = readdir($dir)){
		
		if ($obj=='.' || $obj=='..') continue;
		
		if (!file_exists($path . $obj . '/plugin.php')) continue;
		
		$pHand = new RMBPluginHandler($obj);
		$plugin = $pHand->getPlugin();
		$rtn = array();
		if ($pHand->installed()){
			$rtn['name'] = $plugin->getName();
			$rtn['desc'] = $plugin->getDescription();
			$rtn['module'] = $plugin->getModule();
			$rtn['logo'] = $plugin->getURL() . $plugin->getLogo();
			$rtn['dir'] = $obj;
			$rtn['version'] = $plugin->getVersion();
			$rtn['author'] = $plugin->getAuthor();
			$rtn['url'] = $plugin->getAuthorURL();
			$rtn['help'] = $plugin->getHelp();
			$installed[] = $rtn;
		} else {
			$rtn['name'] = $plugin->getName();
			$rtn['desc'] = $plugin->getDescription();
			$rtn['module'] = $plugin->getModule();
			$rtn['logo'] = $plugin->getURL() . $plugin->getLogo();
			$rtn['dir'] = $obj;
			$rtn['version'] = $plugin->getVersion();
			$rtn['author'] = $plugin->getAuthor();
			$rtn['url'] = $plugin->getAuthorURL();
			$rtn['help'] = $plugin->getHelp();
			$noinstalled[] = $rtn;
		}
		
	}
	
	$pHand = null;
	$plugin = null;
	
	// Enlace para obtener mas plugins
	echo "<img src='../images/redmex.png' alt='Red México Soft' align='absmiddle' /> <a href='http://www.redmexico.com.mx/modules/sections/index.php?op=viewarticle&artid=8' target='_blank'>"._AM_RMB_MOREPLUGINS."</a><br /><br />";
	echo "<table width='100%' class='outer' cellspacing='1' cellpadding='0'>
			<tr><th colspan='6'>"._AM_RMB_INSTALLED."</th></tr>
			<tr class='head' align='center'>
				<td>&nbsp;</td>
				<td>"._AM_RMB_NAME."</td>
				<td>"._AM_RMB_AUTHOR."</td>
				<td>"._AM_RMB_VERSION."</td>
				<td>"._AM_RMB_MODULE."</td>
				<td>"._AM_RMB_OPTIONS."</td>
			</tr>";
	$class = '';
	foreach ($installed as $k){
		$class = $class == 'even' ? 'odd' : 'even';
		echo "<tr class='$class'>
				<td align='center' width='70'><img src='$k[logo]' alt='$k[name]' /></td>
				<td align='left'><strong>$k[name]</strong><br />
				<span style='font-size: 10px;'>$k[desc]</span></td>
				<td align='center'><a href='$k[url]' target='_blank'>$k[author]</a></td>
				<td align='center'>$k[version]</td>
				<td align='center'>$k[module]</td>
				<td align='center'>
				<a href='?op=uninstall&amp;plugin=$k[dir]'><img src='../images/uninstall.png' alt='' /></a>
				<a href='?op=config&amp;plugin=$k[dir]'><img src='../images/config.png' alt='' /></a>
				<a href='?op=refresh&amp;plugin=$k[dir]'><img src='../images/refresh.png' alt='' /></a>
				<a href='$k[help]' target='_blank'><img src='../images/help.png' alt='' /></a>
				<a href='$k[url]' target='_blank'><img src='../images/homeplug.png' alt='' /></a>
				</td>
			  </tr>";
	}
	
	echo "</table><br />";
	
	echo "<table width='100%' class='outer' cellspacing='1' cellpadding='0'>
			<tr><th colspan='6'>"._AM_RMB_NOINSTALLED."</th></tr>
			<tr class='head' align='center'>
				<td>&nbsp;</td>
				<td>"._AM_RMB_NAME."</td>
				<td>"._AM_RMB_AUTHOR."</td>
				<td>"._AM_RMB_VERSION."</td>
				<td>"._AM_RMB_MODULE."</td>
				<td>"._AM_RMB_OPTIONS."</td>
			</tr>";
			
	foreach ($noinstalled as $k){
		$class = $class == 'even' ? 'odd' : 'even';
		echo "<tr class='$class'>
				<td align='center' width='70'><img src='$k[logo]' alt='$k[name]' /></td>
				<td align='left'><strong>$k[name]</strong><br />
				<span style='font-size: 10px;'>$k[desc]</span></td>
				<td align='center'><a href='$k[url]' target='_blank'>$k[author]</a></td>
				<td align='center'>$k[version]</td>
				<td align='center'>$k[module]</td>
				<td align='center'><a href='?op=install&amp;plugin=$k[dir]'><img src='../images/install.png' alt='' /></a>
				<a href='$k[help]' target='_blank'><img src='../images/help.png' alt='' /></a>
				<a href='$k[url]' target='_blank'><img src='../images/homeplug.png' alt='' /></a>
				</td>
			  </tr>";
	}
	
	echo "</table><br />";
	
	echo rmbMakeFooter();
	xoops_cp_footer();
}

function installPlug(){
	
	$name = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
	$ok = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	
	if ($name==''){
		header('location: plugins.php');
		die();
	}
	
	if (!$plugin = new RMBPluginHandler($name)){
		redirect_header('plugins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();	
	}
	
	if ($ok){
		
		$salida =& $plugin->install();
		
		if (!$salida){
			redirect_header('plugins.php', 2, _AM_RMB_DBERROR."<br />".$plugin->errors());
			die();
		}
		
		$plug =& $plugin->getPlugin();
		xoops_cp_header();
		rmbMakeNav();
		
		echo "<div align='center'>
				<div style='text-align: left; width: 400px; padding: 20px; border: 1px solid #CCCCCC; background: #F5F5F5;'>";
		
		echo "<img src='".$plug->getURL().$plug->getLogo()."' /><br /><br />
			<strong style='font-size: 13px;'>Instalando ".$plug->getName()."</strong><br /><br />
			<div style='padding-left: 15px;'>";
		
		echo $salida;
			
		echo "</div><br /><br /><strong style='font-size: 13px;'>".sprintf(_AM_RMB_PLUGINSTALLED, $plug->getName('name'))."</strong><br /><br />
			  <a href='plugins.php'>"._AM_RMB_BACKPLUGS."</a></div>
			  </div>";
		
		xoops_cp_footer();
		
	} else {
		xoops_cp_header();
		rmbMakeNav();
		$plug = $plugin->getPlugin();
		echo "<div align='center'><div style='text-align: center; width: 400px; padding: 20px; border: 1px solid #CCCCCC; background: #F5F5F5;'>
				<strong>"._AM_RMG_INSTALL."</strong><br /><br />
				<img src='".$plug->getURL().$plug->getLogo()."' alt='".$plug->getName()."' /><br /><br />
				".$plug->getDescription()."<br /><br />
				<form name='frmInstall' method='post' action='plugins.php'>
					<input type='submit' value='"._AM_RMG_INSTALL."' class='formButton' />
					<input type='hidden' name='op' value='install' />
					<input type='hidden' name='plugin' value='$name' />
					<input type='hidden' name='ok' value='1' />
				</form>
			  </div></div>";
		
		xoops_cp_footer();
	}
	
	
}

function uninstallPlugin(){
	
	$name = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	
	if ($ok){
		
		$plugin = new RMBPluginHandler($name);
		if (!$plugin->uninstall()){
			redirect_header('plugins.php', 2, _AM_RMB_DBERROR . "<br />" .  $plugin->errors());
			die();	
		}
		
		$plug =& $plugin->getPlugin();
		xoops_cp_header();
		rmbMakeNav();
		
		echo "<div align='center'>
				<div style='text-align: left; width: 400px; padding: 20px; border: 1px solid #CCCCCC; background: #F5F5F5;'>";
		
		echo "<img src='".$plug->getURL().$plug->getLogo()."' /><br /><br />
			<strong style='font-size: 13px;'>".$plug->getName()."</strong><br /><br />
			<div style='padding-left: 15px;'>";
		
		echo $plugin->getLogger();
			
		echo "</div><br /><br /><br /><br />
			  <a href='plugins.php'>"._AM_RMB_BACKPLUGS."</a></div>
			  </div>";
		
		xoops_cp_footer();
		
	} else {
		
		xoops_cp_header();
		$plugin = new RMBPluginHandler($name);
		$plug =& $plugin->getPlugin();
		rmbMakeNav();
		echo "<div align='center'>
				<div style='border: 1px solid #CCCCCC; background: #F5F5F5; width: 400px; padding: 20px; tex-align: center;'>
					"._AM_RMB_CONFIRMDEL."<br /><br />
					<img src='".$plug->getURL().$plug->getLogo()."' /><br />
					<strong>".$plug->getName()."</strong><br /><br />
					<form name='frmDel' method='post' action='plugins.php'>
						<input type='submit' class='formButton' value='"._DELETE."' />
						<input type='hidden' name='op' value='uninstall' />
						<input type='hidden' name='ok' value='1' />
						<input type='hidden' name='plugin' value='$name' />
					</form>
				</div>
			  </div>";
		echo rmbMakeFooter();
		xoops_cp_footer();
		
	}
	
}

function updatePlugin(){
	
	$name = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	
	if ($ok){
		
		$plugin = new RMBPluginHandler($name);
		if (!$plugin->update()){
			redirect_header('plugins.php', 2, _AM_RMB_DBERROR . "<br />" .  $plugin->errors());
			die();	
		}
		
		$plug =& $plugin->getPlugin();
		xoops_cp_header();
		rmbMakeNav();
		
		echo "<div align='center'>
				<div style='text-align: left; width: 400px; padding: 20px; border: 1px solid #CCCCCC; background: #F5F5F5;'>";
		
		echo "<img src='".$plug->getURL().$plug->getLogo()."' /><br /><br />
			<strong style='font-size: 13px;'>".$plug->getName()."</strong><br /><br />
			<div style='padding-left: 15px;'>";
		
		echo $plugin->getLogger();
			
		echo "</div><br /><br /><br /><br />
			  <a href='plugins.php'>"._AM_RMB_BACKPLUGS."</a></div>
			  </div>";
		
		xoops_cp_footer();
		
	} else {
		
		xoops_cp_header();
		$plugin = new RMBPluginHandler($name);
		$plug =& $plugin->getPlugin();
		rmbMakeNav();
		echo "<div align='center'>
				<div style='border: 1px solid #CCCCCC; background: #F5F5F5; width: 400px; padding: 20px; tex-align: center;'>
					"._AM_RMB_CONFIRMUPD."<br /><br />
					<img src='".$plug->getURL().$plug->getLogo()."' /><br />
					<strong>".$plug->getName()."</strong><br /><br />
					<form name='frmDel' method='post' action='plugins.php'>
						<input type='submit' class='formButton' value='"._AM_RMB_UPDATE."' />
						<input type='hidden' name='op' value='refresh' />
						<input type='hidden' name='ok' value='1' />
						<input type='hidden' name='plugin' value='$name' />
					</form>
				</div>
			  </div>";
		echo rmbMakeFooter();
		xoops_cp_footer();
		
	}
	
}

// Configuramos un plugin
function configPlug(){
	global $db;
	
	$plug = isset($_GET['plugin']) ? $_GET['plugin'] : '';
	
	if ($plug==''){
		header('location: plugins.php');
		die();
	}
	
	xoops_cp_header();
	
	rmbMakeNav();
	
	$pHand = new RMBPluginHandler($plug);
	$plugin = $pHand->getPlugin();
	
	$form = new RMForm(_AM_RMB_TITLEFCONFIG, 'frmConfig', 'plugins.php');
		
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_configs")." WHERE plugin='$plug'");
	while ($row = $db->fetchArray($result)){
		switch ($row['fieldtype']){
			case 'textarea':
				$ele = new RMTextArea($plugin->getString($row['caption']), $row['name'], 5, 45, $row['conf_value']);
				break;
			case 'yesno':
				$ele = new RMYesNo($plugin->getString($row['caption']), $row['name'], $row['conf_value']);
				break;
			case 'radio':
				$ele = new RMRadio($plugin->getString($row['caption']), $row['name'], 1);
				foreach ($plugin->getConfigOptions($row['name']) as $k => $v){
					$ele->addOption($v['caption'], $v['value'], ($plugin->getConfig($row['name'])==$v['conf_value']) ? 1 : 0);
				}
				break;
			case 'select':
				$ele = new RMSelect($plugin->getString($row['caption']), $row['name'], 0);
				foreach ($plugin->getConfigOptions($row['name']) as $k => $v){
					$ele->addOption($v['value'], $plugin->getString($v['caption']), ($v['value']==$row['conf_value']) ? 1 : 0);
				}
				break;
			case 'country_multi':
				$ele = new RMLabel($plugin->getString($row['caption']), rmsh_country_select(1, $row['name'].'[]', explode('|',$row['conf_value'])));
				break;
			case 'zone_multi':
				$ele = new RMLabel($plugin->getString($row['caption']), rmsh_zones_select(1, $row['name'].'[]', explode('|',$row['conf_value'])));
				break;
			default:
				$ele = new RMText($plugin->getString($row['caption']), $row['name'], 50, 255, $row['conf_value']);
				break;
		}
		if ($row['desc']!=''){ $ele->setDescription($plugin->getString($row['desc'])); }
		$form->addElement($ele);
	}
	
	$form->addElement(new RMButton('submit_button', _SUBMIT));
	$form->addElement(new RMHidden('plugin', $plug));
	$form->addElement(new RMHidden('op', 'saveconfig'));
	$form->display();
	
	echo rmbMakeFooter();
	
	xoops_cp_footer();
}

function saveConfig(){
	global $db, $myts, $modulo;
	
	$plug = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	$pHand = new RMBPluginHandler($plug);
	
	if (!$pHand->installed()){
		redirect_header('plugins.php', 1, _AM_RMB_ERRPLUGNAME);
		die();
	}
	
	// Cargamos el plugin para un manejo completo
	$plugin = $pHand->getPlugin();
	$vars = $plugin->getConfigs();
	
	foreach ($_POST as $k => $v){
		if ($k == 'submit_button' || $k == 'plugin' || $k == 'acc'){ continue; }
		if (is_array($v)){
			$save = '';
			foreach ($v as $key){
				$save .= $key.'|';
			}
			$save = substr($save, 0, strlen($save) - 1);
			$plugin->setConfig($k, trim($save));
		} else {
			$plugin->setConfig($k, $myts->makeTareaData4Save($v));
		}
	}
	
	redirect_header('plugins.php', 1, _AM_RMB_CONFIGSAVED);
	die();
}


$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'uninstall':
		uninstallPlugin();
		break;	
	case 'install':
		installPlug();
		break;
	case 'config':
		configPlug();
		break;
	case 'saveconfig':
		saveConfig();
		break;
	case 'refresh':
		updatePlugin();
		break;
	default:
		showPlugins();
		break;
}

?>