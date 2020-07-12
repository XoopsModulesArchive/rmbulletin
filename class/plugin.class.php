<?php
/*******************************************************************
* $Id: plugin.class.php,v 1.0.2 26/05/2006 13:53 BitC3R0 Exp $     *
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
*                                                                  *
* ------------------------------------------------------------     *
* plugin.class.php:                                                *
* Clase para el manejo de plugins                                  *
* ------------------------------------------------------------     *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0.2                                                  *
* @modificado: 26/05/2006 01:53:24 p.m.                            *
*******************************************************************/

abstract class RMBPlugin extends RMObject
{
	protected $db = null;
	protected $_template = '';
	protected $tpl = null;
	protected $_dir = '';
	protected $_lang = array();
	protected $_configs = array();
	protected $_configs_file = array();
	
	/**
	 * Función para activar todos los valores
	 * básicos del plugin
	 */
	protected function activate(){
		$this->db = Database::getInstance();
		// Ruta absoluta del plugin		
		$this->initVar('path', XOOPS_ROOT_PATH.'/modules/rmbulletin/plugins/'.$this->_dir. '/');
		// Cargamos el archivo de configuración
		require ($this->getVar('path').'config.php');
		
		if (isset($plugin_config)) $this->_configs_file = $plugin_config;
		foreach ($plugin_info as $k => $v){
			$this->initVar($k, $v);
		}
		// Cargamos el archivo de lenguage
		include $this->getLangFile();
		$this->_lang = $plugLang;
		
		// Cargamos las configuraciones del Módulo
		$this->loadConfig();
	}
	/**
	 * Función para cargar el archivo de lenguage
	 */
	public function getLangFile(){
		global $xoopsConfig;
		
		if (file_exists(RMB_PATH . 'plugins/'.$this->_dir.'/lang_'.$xoopsConfig['language'].'.php')){
			return RMB_PATH . 'plugins/'.$this->_dir.'/lang_'.$xoopsConfig['language'].'.php';
		} else {
			return RMB_PATH . 'plugins/'.$this->_dir.'/lang_spanish.php';
		}
	}
	/**
	 * Funciones obligatorias
	 */
	public function getName(){
		return $this->getString($this->getVar('name'));
	}
	
	public function getDescription(){
		return $this->getString($this->getVar('desc'));
	}
	
	public function getModule(){
		return $this->getString($this->getVar('module'));
	}
	
	public function getLogo(){
		return $this->getVar('logo');
	}
	
	public function getAuthor(){
		return $this->getString($this->getVar('author'));
	}
	
	public function getAuthorURL(){
		return $this->getString($this->getVar('url'));
	}
	
	public function getPath(){
		return $this->getVar('path');
	}
	
	public function getURL(){
		return str_replace(XOOPS_ROOT_PATH,XOOPS_URL,$this->getVar('path'));
	}
	
	public function getHelp(){
		return $this->getString($this->getVar('help'));
	}
	
	public function getVersion(){
		return $this->getVar('version');
	}
	
	public function getDir(){
		return $this->getVar('dir');
	}
	
	public function getMain(){
		return $this->getVar('main');
	}
	/**
	 * Obtenemos una cadena desde el archivo
	 * de lenguage
	 */
	public function getString($string){
		if (isset($this->_lang[$string])){
			return $this->_lang[$string];
		} else {
			return $string;
		}
	}
	
	/**
	 * Comprueba que el modulo este instalado
	 */
	public function moduleInstalled(){
		$result = $this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("modules")." WHERE dirname='".$this->getModule()."'");
		list($num) = $this->db->fetchRow($result);
		if ($num==1){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Función para obtener las opciones de ocnfiguración
	 * del pluegin
	 */
	/**
	 * Obtenemos los valores de configuraci&oacute;n
	 */
	protected function loadConfig(){
	
		$sql = "SELECT * FROM ".$this->db->prefix("rmb_configs")." WHERE plugin='".$this->getDir()."'";
		$result = $this->db->query($sql);
		$ret = array();
		while ($row=$this->db->fetchArray($result)){
			$this->_configs[$row['name']]['type'] = $row['valuetype'];
			$this->_configs[$row['name']]['value'] = $row['conf_value'];
			$this->_configs[$row['name']]['id'] = $row['id_cnf'];
			$this->_configs[$row['name']]['fieldtype'] = $row['fieldtype'];
			$this->_configs[$row['name']]['caption'] = $row['caption'];
			// Obtenemos las opciones (Si existen)
			$sql = "SELECT * FROM ".$this->db->prefix("rmb_configoptions")." WHERE id_conf='$row[id_cnf]'";
			$ropts = $this->db->query($sql);
			while ($ro = $this->db->fetchArray($ropts)){
				$ret = array();
				$ret['id'] = $ro['id_opt'];
				$ret['caption'] = $ro['caption'];
				$ret['value'] = $ro['value'];
				$this->_configs[$row['name']]['options'][] = $ret;
			}
		}
		
	}
	/**
	 * Obtenemos un elemento de configuración
	 */
	public function getConfig($name, $format=0){
		
		$myts = MyTextSanitizer::getInstance();
		
		if (isset($this->_configs[$name])){
			if (!isset($this->_configs[$name])){ return; }
			switch ($this->_configs[$name]['fieldtype']){
				case 'zone_multi':
					$ret = explode('|', $this->_configs[$name]['value']);
					break;
				default:
					$ret = $this->_configs[$name]['value'];
					break;
			}
			
			switch ($this->_configs[$name]['type']){
				case 'int':
					if (is_array($ret)){
						foreach ($ret as $k => $v){
							$ret[$k] = intval($ret[$k]);
						}
					} else {
						$ret = intval($ret);
					}
					return $ret;
				case 'text':
					if (is_array($ret)){
						foreach ($ret as $k => $v){
							$ret[$k] = $format ? $myts->makeTareaData4Show(strval($ret[$k])) : strval($ret[$k]);
						}
					} else {
						$ret = $format ? $myts->makeTareaData4Show(strval($ret)) : strval($ret);
					}
					return $ret;
				case 'float':
					if (is_array($ret)){
						foreach ($ret as $k => $v){
							$ret[$k] = floatval($ret[$k]);
						}
					} else {
						$ret = floatval($ret);
					}					
					return $ret;
			}
		}
	}
	/**
	 * Obtenemos todas la configuraciones en un array
	 */
	public function getConfigs(){
		return $this->_configs;
	}
	/**
	 * Obtenemos las opciones de un canfiguración
	 * @param string $name Nombre de la configuración
	 */
	public function getConfigOptions($name){
		if (!isset($this->_configs[$name])) return;
		
		return $this->_configs[$name]['options'];
	}
	/**
	 * Devuelve las configuraciones del archivo
	 */
	public function getConfigFile(){
		return $this->_configs_file;
	}
	/**
	 * Establecemos un valor de configuraci&oacute;n
	 */
	function setConfig($name, $value){
		if (!isset($this->_configs[$name])){ return 0; }
		switch ($this->_configs[$name]['type']){
			case 'int':
				//if (!is_int($value)){ echo $name."=".$value."<br>"; return 0; }
				$value = $value;
				break;
			case 'text':
				$value = (string) $value;
				break;
			case 'float':
				//if (!is_float($value)){ return 0; }
				$value = (float) $value;
				break;
		}
		$sql = "UPDATE ".$this->db->prefix("rmb_configs")." SET `conf_value`='$value' WHERE id_cnf='".$this->_configs[$name]['id']."'";
		$this->db->query($sql);
		if ($this->db->error()!=''){ return 0; } else { return 1; }		
		
		
	}
	/**
	 * Funciones que los plugins deben incluir
	 */
	abstract function newContent(RMForm &$form);
	abstract function saveData();
	abstract function preview($item);
	abstract function editContent(RMForm $form, $item);
	abstract function editData();
	abstract function deleteItem($params);
	abstract function getData($item);
}


/**
 * Manejador de PLugins
 */
class RMBPluginHandler extends RMObject
{

	private $_path = '';
	private $_plugin = '';
	private $_configs = array();
	/**
	 * Carga los datos de un plugin
	 */
	public function __construct($dir){
		
		$this->db = Database::getInstance();
		
		if ($dir=='') return false;

		if (substr($dir, strlen($dir) - 1, 1)!='/'){
			$dir.= '/';
		}
		$this->_path = XOOPS_ROOT_PATH . '/modules/rmbulletin/plugins/'.$dir;
		// Cargamos el archivo de información
		global $plugin_info;
		include $this->_path . 'config.php';
		
		foreach ($plugin_info as $k => $v){
			$this->initVar($k, $v);
		}
		$this->initVar('dir', substr($dir, 0, strlen($dir) - 1));
		
		// Cargamos la clase del plugin
		include_once $this->_path . 'plugin.php';
		
		$class = $this->getVar('main');
		$this->_plugin = new $class();
		
		return true;
		
	}
	
	/**
	 * Comprueba si el plugin esta instalado
	 */
	public function installed(){
		
		$result = $this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("rmb_plugins")." WHERE `dir`='".$this->getVar('dir')."'");
		list($num) = $this->db->fetchRow($result);
		if ($num<=0){
			return false;
		} else {
			return true;
		}
		
	}
	/**
	 * Devuelve el objeto plugin
	 */
	public function getPlugin(){
		return $this->_plugin;
	}
	/**
	 *  Instala del PLugin actual
	 */
	public function install(){
	
		$plugin =& $this->getPlugin();
		
		$sql = "INSERT INTO ".$this->db->prefix("rmb_plugins")." (`name`,`dir`,`active`) VALUES
				('".$plugin->getName()."','".$this->getVar('dir')."','1')";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
			die();
		}

		$this->logger(_AM_RMB_INSERTED, 'font-size: 12px;');
		
		include $this->_path . 'config.php';

		if (isset($plugin_config)){
		
			foreach ($plugin_config as $k){
				$sql = "INSERT INTO ".$this->db->prefix("rmb_configs")." (`name`,`caption`,`desc`,`plugin`,`conf_value`,`valuetype`,`fieldtype`)
						VALUES ('$k[name]','$k[caption]','$k[desc]','".$this->getVar('dir')."','$k[default]','$k[valuetype]','$k[type]')";
				$this->db->queryF($sql);
				if ($this->db->error()!=''){
					$this->logger(sprintf(_RM_RMB_ERRCONFIG, $k['name'])."<br />".$this->db->error(), 'color: #FF0000; font-size: 11px;');
				} else {
					$this->logger(sprintf(_AM_RMB_CONFIGINSERT, $k['name']), 'color: #0099FF; font-size: 11px;');
				}
				
				if (!is_array($k['options'])) continue;
				$idconfig = $this->db->getInsertId();
				foreach ($k['options'] as $opt => $value){
					$this->db->queryF("INSERT INTO ".$this->db->prefix("rmb_configoptions")." (`id_conf`,`caption`,`value`) VALUES
							('$idconfig', '$opt', '$value')");
					if ($this->db->error()!=''){
						$this->logger(sprintf(_RM_RMB_ERRCONFIG, $opt) . "<br />". $this->db->error(), 'color: #FF0000; text-indent: 12px;');
					} else {
						$this->logger(sprintf(_AM_RMB_OPTINSERT, $opt), 'text-indent: 12px; color: #666666');
					}
				}
				
			}
		
		}
		
		if ($this->getVar('install_file')!=''){
			$this->logger('<div style="padding-left: 15px;">');
			$this->logger('<span style="color: #FF3300;">'._AM_RMB_INSTALLSR.'</span>...<br />');
			include_once $this->_path . $this->getVar('install_file');
			$this->logger('<br /><span style="color: #FF3300;">'._AM_RMB_INSTALLSF.'</span>');
			$this->logger('</div>');
		}
		
		return $this->getLogger(true);
		
	}
	
	/** 
	 * Desinstalación del Módulo
	 */
	public function uninstall(){
		
		$plugin =& $this->getPlugin();
		
		$this->logger("<strong>"._AM_RMB_UNINSTALLSTART."</strong>");
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_plugins")." WHERE dir='".$this->getVar('dir')."'");
		
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		}
		
		$this->logger(_AM_RMB_CONFIGSDEL);
		
		if ($this->getVar('uninstall_file')!=''){
			$this->logger('<div style="padding-left: 15px;">');
			$this->logger('<span style="color: #FF3300;">'._AM_RMB_UNINSTALLSR.'...</span><br />');
			include_once $this->_path . $this->getVar('uninstall_file');
			$this->logger('<br /><span style="color: #FF3300;">'._AM_RMB_UNINSTALLSF.'...</span>');
			$this->logger('</div>');
		}
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_configs")." WHERE plugin='".$this->getVar('dir')."'");
		while ($row = $this->db->fetchArray($result)){
			$this->logger(sprintf(_AM_RMB_CONFIGDEL, $row['name']), 'color: #006600');
			$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_configoptions")." WHERE id_conf='$row[id_cnf]'");
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_configs")." WHERE plugin='".$this->getVar('dir')."'");
		
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		}
		
		$this->logger("<strong>"._AM_RMB_UNINSTALLOK."</strong>");
		
		return true;
		
	}
	
	public function update(){
		if (!$this->installed()) return false;
		
		$plugin =& $this->getPlugin();
		
		$this->logger(_AM_RMB_STARTUPD, 'font-weight: bold;');
		$this->logger(" ",'');
		
		# Actualizamos los datos del plugin
		$sql = "UPDATE ".$this->db->prefix("rmb_plugins")." SET `name`='".$plugin->getName()."',
				`active`='1' WHERE `dir`='".$plugin->getDir()."'";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->logger(_AM_RMB_ERRUPDPLUG . '<br />'. $this->db->error(), 'color: #FF0000; text-indent: 12px;');
		} else {
			$this->logger(_AM_RMB_PLUGVALUESOK, 'color: #0066FF; text-indent: 12px;');
		}
		
		$configs =& $plugin->getConfigs();
		
		foreach ($configs as $k => $v){
			$this->logger(sprintf(_AM_RMB_CONFIGDEL, $k), 'color: #666666; text-indent: 20px;');
			$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_configoptions")." WHERE id_conf='$v[id]'");
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_configs")." WHERE plugin='".$plugin->getDir()."'"); 
		
		foreach ($plugin->getConfigFile() as $v){
			if (isset($configs[$v['name']])){
				$v['default'] = $configs[$v['name']]['value'];
				$okmsg = 1;
			}
			
			$sql = "INSERT INTO ".$this->db->prefix("rmb_configs")." (`name`,`caption`,`desc`,`plugin`,`conf_value`,`fieldtype`,`valuetype`)
					VALUES ('$v[name]','$v[caption]','$v[desc]','".$plugin->getDir()."','$v[default]','$v[type]','$v[valuetype]')";
			if (!$this->db->queryF($sql)){
				$this->logger(sprintf(_RM_RMB_ERRCONFIG, $v['name']) . "<br />" . $this->db->error(),"text-indent: 12px; color: #FF0000;");
			} else {
				$this->logger(sprintf(_AM_RMB_CONFIGUPDATED, $v['name']), "font-size: 10px; text-indent: 12px; color: #0099FF;");
			}
			
			if (!is_array($v['options'])) continue;
			$idconfig = $this->db->getInsertId();
			foreach ($v['options'] as $opt => $value){
				$this->db->queryF("INSERT INTO ".$this->db->prefix("rmb_configoptions")." (`id_conf`,`caption`,`value`) VALUES
						('$idconfig', '$opt', '$value')");
				if ($this->db->error()!=''){
					$this->logger(sprintf(_RM_RMB_ERRCONFIG, $opt) . "<br />". $this->db->error(), 'color: #FF0000; text-indent: 20px;');
				} else {
					$this->logger(sprintf(_AM_RMB_OPTINSERT, $opt), 'text-indent: 20px; color: #666666');
				}
			}
			
		}
		
		if ($this->getVar('update_file')!=''){
			$this->logger('<div style="padding-left: 15px;">');
			$this->logger('<span style="color: #FF3300;">'._AM_RMB_UPDATESR.'</span>...<br />');
			include_once $this->_path . $this->getVar('install_file');
			$this->logger('<br /><span style="color: #FF3300;">'._AM_RMB_UPDATESF.'</span>');
			$this->logger('</div>');
		}
		
		$this->logger('');
		$this->logger(_AM_RMB_UPDATEOK, 'font-weight: bold;');
		
		return true;
	}
	
}
?>

