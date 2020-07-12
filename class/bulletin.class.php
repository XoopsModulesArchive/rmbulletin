<?php
/*******************************************************************
* $Id: bulletin.class.php,v 0.1.1 11/05/2006 23:58 BitC3R0 Exp $   *
* --------------------------------------------------------------   *
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
* --------------------------------------------------------------   *
* bulletin.class.php:                                              *
* Clase para el manejo de los boletines.                           *
* --------------------------------------------------------------   *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 0.1.1                                                  *
* @modificado: 11/05/2006 11:58:40 p.m.                            *
*******************************************************************/

require_once XOOPS_ROOT_PATH.'/rmcommon/object.class.php';
require_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/user.class.php';
require_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/mail.class.php';

class RMBulletin extends RMObject
{	

	private $_sections = array();
	private $_tblsecs = '';			// NOmbre de la tabla de secciones
	private $_tblcon = '';			// Nombre de la tabla de contenido
	private $_items = array();		// Items del contenido
	private $_tpl = '';
	private $_contenido = '';

	function __construct($id=null){
		$this->db =& Database::getInstance();
		$this->_tblsecs = $this->db->prefix("rmb_sections");
		$this->_tblcon = $this->db->prefix("rmb_content");
		$this->_dbtable = $this->db->prefix("rmb_boletines");
		$this->_tpl = new XoopsTpl();
		
		if ($id<=0 || !is_numeric($id)){
			$this->setNew();
			$this->initVarsFromTable();
			return;
		}
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_boletines")." WHERE id_bol='$id'");
		
		if ($this->db->getRowsNum($result)<=0){
			$this->setNew();
			$this->addError("Not Found");
			return;
		}
		
		$row = $this->db->fetchArray($result);
		foreach ($row as $k => $v){
			$this->initVar($k, $v);
		}
		
		return true;
	}
	// Titulo del Boletin
	public function setTitulo($value){
		return $this->setVar('titulo', $value);
	}
	
	public function getTitulo(){
		return $this->getVar('titulo');
	}
	
	// Introduccion del boletin
	public function setIntro($value){
		return $this->setVar('introduccion', $value);
	}
	
	public function getIntro(){
		return $this->getVar('introduccion');
	}
	
	// Fecha del Boletin
	public function setFecha($value){
		return $this->setVar('fecha', $value);
	}
	
	public function getFecha(){
		return $this->getVar('fecha');
	}
	
	/**
	 * Establece si se elimina o no un plugin
	 * @param int $value 1 para eliminar, 0 para mantener
	 */
	public function setEliminar($value){
		return $this->setVar('eliminar', $value);
	}
	/**
	 * Permite saber si un boletín esta marcado para ser eliminado
	 */
	public function getEliminar(){
		return $this->getVar('eliminar');
	}
	
	/**
	 * Establece la plantilla del boletín
	 * @param string $value Directorio de la plantilla
	 */
	public function setTemplate($value){
		return $this->setVar('plantilla', $value);
	}
	/**
	 * Devuelve el nombre de la plantilla que utilizará el boletín
	 */
	public function getTemplate(){
		return $this->getVar('plantilla');
	}
	
	/**
	 * Establece la fecha de eliminación del boletín
	 * @param int $value Timestamp Unix
	 */
	public function setEliminacion($value){
		if ($value>time()){
			return $this->setVar('fechaeliminar', $value);
		} else {
			return false;
		}
	}
	/**
	 * Devuelve la fecha en la que se eliminará un boletín
	 */
	public function getEliminacion(){
		return $this->getVar('fechaeliminar');
	}
	
	/**
	 * Marca un boletín como enviado o no enviado
	 * @param int $value 1 enviado, 0 no enviado
	 */
	public function setSended($value=0){
		return $this->setVar('sended',$value);
	}
	/**
	 * Inidica si un boletín ha sido enviado o no
	 */
	public function getSended(){
		return $this->getVar('sended');
	}
	/**
	 * Establece la fecha en la que se envia el boletín
	 * @param int $date Timestamp UNix
	 */
	public function setPubDate($date){
		return $this->setVar('fechaenvio', $date);
	}
	/**
	 * Devuelve la fecha en que se envío un boletin
	 */
	public function getPubDate(){
		return $this->getVar('fechaenvio');
	}
	
	/**
	 * Almacena los valores actuales de un plugin
	 */
	public function save(){

		$myts =& MyTextSanitizer::getInstance();		

		if ($this->isNew()){
			$sql = "INSERT INTO ".$this->db->prefix("rmb_boletines")." (`titulo`,`introduccion`,`fecha`,`eliminar`,`fechaeliminar`,`sended`,`plantilla`)
					VALUES ('".$myts->makeTboxData4Save($this->getTitulo())."','".$myts->makeTareaData4Save($this->getIntro())."','".time()."',
							'".$this->getEliminar()."','".$this->getVar('fechaeliminar')."','0','".$this->getVar('plantilla')."')";
		} else {
			$sql = "UPDATE ".$this->db->prefix("rmb_boletines")." SET `titulo`='".$myts->makeTboxData4Save($this->getTitulo())."',
					`introduccion`='".$myts->makeTareaData4Save($this->getIntro())."',`fecha`='".$this->getVar('fecha')."',
					`eliminar`='".$this->getVar('eliminar')."',`fechaeliminar`='".$this->getVar('fechaeliminar')."', 
					`sended`='".$this->getVar('sended')."',`plantilla`='".$this->getVar('plantilla')."'
					WHERE id_bol='".$this->getVar('id_bol')."'";
		}
		$this->db->queryF($sql);
		if ($this->db->error() != ''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	// Eliminamos el boletín actual
	public function delete(){
		if ($this->getVar('id_bol')<=0){ return; }
		
		if (file_exists(XOOPS_ROOT_PATH.'/modules/rmbulletin/cache/boletin-'.$this->getPubDate() . '.html')){
			unlink(XOOPS_ROOT_PATH.'/modules/rmbulletin/cache/boletin-'.$this->getPubDate() . '.html');
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_boletines")." WHERE id_bol='".$this->getVar('id_bol')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			$rtn = true;
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_sections")." WHERE id_b='".$this->getVar('id_bol')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			$rtn = false;
		} else {
			$rtn = true;
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_content")." WHERE id_bol='".$this->getVar('id_bol')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			$rtn = false;
		} else {
			$rtn = true;
		}
		
		return $rtn;
		
	}
	
	public function deleteContent(){
		if ($this->getVar('id_bol')<=0){ return; }
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_sections")." WHERE id_b='".$this->getVar('id_bol')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			$rtn = false;
		} else {
			$rtn = true;
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_content")." WHERE id_bol='".$this->getVar('id_bol')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			$rtn = false;
		} else {
			$rtn = true;
		}
		
		return $rtn;
	}
	
	// Obtenemos las secciones del boletín
	public function getSections(){
		if (!empty($this->_sections)){
			return $this->_sections;
			break;
		}
		
		$sql = "SELECT * FROM $this->_tblsecs WHERE id_b='".$this->getVar('id_bol')."' ORDER BY `order`";
		$result = $this->db->query($sql);
		while ($row = $this->db->fetchArray($result)){
			$this->_sections[] = $row;
		}
		
		return $this->_sections;
		
	}
	// Guardamos una sección en el boletín
	public function addSection($name,$order){
		$result = $this->db->query("SELECT COUNT(*) FROM $this->_tblsecs WHERE titulo='$name' AND id_b='".$this->getVar('id_bol')."'");
		list($num) = $this->db->fetchRow($result);
		
		if ($num>0){
			$this->addError(_AM_RMB_SECTIONEXISTS);
			return false;
		}
		
		$sql = "INSERT INTO $this->_tblsecs (`titulo`,`id_b`,`order`) VALUES ('$name',
				'".$this->getVar('id_bol')."','$order')";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			$this->_sections = array();
			return true;
		}
		
	}
	
	/**
	 * Obtenemos una sección especifica y la devolvemos como un objeto
	 * @param int $id Identificador de la sección
	 * @return object RMBSection
	 */
	public function getSection($id){
		
		if ($section = new RMBSection($id)){
			return $section;
		} else {
			return false;
		}
		
	}
	
	public function delSection($id){
		
		$this->db->queryF("DELETE FROM $this->_tblsecs WHERE id_sec='$id'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
		
	}
	
	/**
	 * Obtenemos los elementos del contenido
	 * @return array
	 */
	public function getItems(){
		if (!empty($this->_items)) return $this->_items;
		
		$result = $this->db->query("SELECT * FROM $this->_tblcon WHERE id_bol='".$this->getVar('id_bol')."' ORDER BY section");
		
		while ($row = $this->db->fetchArray($result)){
			$this->_items[$row['id_item']] = $row;
		}
		
		return $this->_items;
	}
	
	public function getItem($id){
		if ($id<=0) return false;
		
		if (empty($this->_items)) $this->getItems();
		
		if (!isset($this->_items[$id])) return false;
		
		return $this->_items[$id];
	}
	
	public function editItem($item,$params,$section,$plugin){
		
		if ($params=='') return false;
		if ($plugin=='') return false;
		if ($section<=0) return false;
		if ($item<=0) return false;
		
		$sql = "UPDATE ".$this->db->prefix("rmb_content")." SET `params`='$params',`plugin`='$plugin',
				`id_bol`='".$this->getVar('id_bol')."',`section`='$section' WHERE id_item='$item'";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->error());
			return false;
		} else {
			return true;
		}
		
	}
	
	public function delItem($id){
		
		$item = $this->getItem($id);
		$pHand = new RMBPluginHandler($item['plugin']);
		$plugin =& $pHand->getPlugin();
		
		if (!$plugin->deleteItem($item['params'])){
			$this->addError($this->errors());
			return false;
		}
		
		$sql = "DELETE FROM ".$this->db->prefix("rmb_content")." WHERE id_item='$id'";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Almacenamos un nuevo elemento al contenido del boletín
	 * @param string $params
	 * @param string $plugin Nombre del plugin
	 * @param int $section Id de la sección
	 */
	public function addItem($params,$plugin,$section){
		
		if ($params=='') return false;
		if ($plugin=='') return false;
		if ($section<=0) return false;
		
		$sql = "INSERT INTO ".$this->db->prefix("rmb_content")." (`plugin`,`params`,`id_bol`,`section`) VALUES
				('$plugin','$params','".$this->getVar('id_bol')."','$section')";
		$this->db->queryF($sql);
		$this->_items = array();
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
			
	}
	/**
	 * Obtenemos los identificadores de los emails
	 */
	public function getEmails(){
		
		$result = $this->db->query("SELECT id_mail FROM ".$this->db->prefix("rmb_emails"));
		$rtn = array();
		while ($row = $this->db->fetchArray($result)){
			$rtn[] = $row['id_mail'];
		}
		return $rtn;
	}
	/**
	 * Función para previsualizar un Boletin
	 */
	public function preview(){
		global $xoopsConfig;
		
		$myts =& MyTextSanitizer::getInstance();
		
		$this->getSections();

		foreach ($this->_sections as $k => $v){
			$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_content")." WHERE section='$v[id_sec]' AND id_bol='".$this->getVar('id_bol')."'");
			$items = array();
			while ($row = $this->db->fetchArray($result)){
				
				if (isset($pHand)){
					if ($pHand->getVar('dir')!=$row['plugin']){
						$pHand = new RMBPluginHandler($row['plugin']);
						$plugin = $pHand->getPlugin();
					}
				} else {
					$pHand = new RMBPluginHandler($row['plugin']);
					$plugin = $pHand->getPlugin();
				}	

				$item = $plugin->getData($row['params']);
				$items[] = $item;
			}
			$this->_tpl->append('sections',array('title'=>$v['titulo'],'items'=>$items));
		}
		
		$this->_tpl->assign('sitename', $xoopsConfig['sitename']);
		$this->_tpl->assign('siteslogan', $xoopsConfig['slogan']);
		$this->_tpl->assign('site_url', XOOPS_URL);
		$this->_tpl->assign('theme_url', XOOPS_URL.'/modules/rmbulletin/mytpls/'.$this->getTemplate());
		$this->_tpl->assign('intro', $myts->makeTareaData4Show($this->getIntro()));
		$this->_tpl->assign('unsuscribe',"<a href='".XOOPS_URL."/modules/rmbulletin/unsuscribe.php'>"._AM_RMB_UNSUSCRIBE."</a><br />Powered by <a href='http://www.redmexico.com.mx/modules/rmmf/view.php?id=19'>RMSOFT Bulletin 1.0</a>.");
		$this->_tpl->assign('pagetitle', $this->getTitulo());
		
		return $this->_tpl->fetch(XOOPS_ROOT_PATH.'/modules/rmbulletin/mytpls/'.$this->getTemplate().'/boletin.html');
		
	}
	/**
	 * Enviamos el boletín
	 */
	public function send($email, $from, $fromname, $server=null){
		global $mc;
		
		if ($this->getPubDate()<=0) $this->setPubDate(time());
		
		if ($this->_contenido == '') $this->_contenido = $this->getCache();		
		// Enviamos el archivo a cada uno de los usuarios
		$result = $this->db->query("SELECT id_user FROM ".$this->db->prefix("rmb_users"));
		
		include_once XOOPS_ROOT_PATH.'/rmcommon/mailer.class.php';
		$mailer = new RMMailer();
		$mailer->setFromEmail($from);
		$mailer->setFromName($fromname);
		if ($mc['multimails']){
			$mailer->mailer('smtp');
			$mailer->setSMTP($server['smtp'], $server['user'], $server['password'], true, 30);
		}
		$mailer->setSubject($this->getTitulo());
		$mailer->isHTML(true);	
		$mailer->setToEmails($email);
		
		$mailer->setBody($this->_contenido);
		if (!$mailer->send(true)){
			$this->addError($mailer->getErrors());
		}
		$mailer = null;
		
		$this->db->queryF("UPDATE ".$this->db->prefix("rmb_boletines")." SET sended='1', fechaenvio='".$this->getPubDate()."' WHERE id_bol='".$this->getVar('id_bol')."'");
		$this->setVar('sended', 1);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
		}
		$this->save();
		
		return $this->errors()!='' ? false : true;
		
	}
	/**
	 * Crea el archivo en el cache
	 */
	public function createCache(){
		$dir = XOOPS_ROOT_PATH.'/modules/rmbulletin/cache';
		if (!file_exists($dir . '/boletin-'.$this->getPubDate().'.html')){
			$contenido = $this->preview();
			$fp = fopen($dir . '/boletin-'. $this->getPubDate() . '.html','w');
			fwrite($fp, $contenido);
			fclose($fp);
		}
	}
	/**
	 * Obtiene el contenido del boletin desde el cache
	 */
	public function getCache(){
		$file = XOOPS_ROOT_PATH.'/modules/rmbulletin/cache/boletin-'. $this->getPubDate() . '.html';
		if (!file_exists($file)) $this->createCache();
		
		$fp = fopen($file, 'r');
		$contenido = fread($fp, filesize($file));
		fclose($fp);
		return $contenido;
	}
}

/**
 * Clase para el manejo de secciones
 */
class RMBSection extends RMObject
{
	
	private $_tbl = '';
	
	function __construct($id){
		if ($id<=0){
			return false;
		}
		
		$this->db =& Database::getInstance();
		$this->_tbl = $this->db->prefix("rmb_sections");
		
		$result = $this->db->query("SELECT * FROM $this->_tbl WHERE id_sec='$id'");
		if ($this->db->getRowsNum($result)<=0) return false;
		
		$row = $this->db->fetchArray($result);
		
		$this->initVar('titulo', $row['titulo']);
		$this->initVar('id_b', $row['id_b']);
		$this->initVar('id_sec',$row['id_sec']);
		$this->initVar('order',$row['order']);
		
		return true;
		
	}
	public function getTitle(){
		return $this->getVar('titulo');
	}
	public function setTitle($value){
		return $this->setVar('titulo', $value);
	}
	public function getBull(){
		return $this->getVar('id_b');
	}
	public function setBull($value){
		return $this->setVar('id_b', $value);
	}
	public function getId(){
		return $this->getVar('id_sec');
	}
	public function getOrder(){
		return $this->getVar('order');
	}
	public function setOrder($value){
		return $this->setVar('order', $value);
	}
	public function save(){
		
		$sql = "UPDATE $this->_tbl SET `titulo`='".$this->getTitle()."',
				`id_b`='".$this->getBull()."',`order`='".$this->getOrder()."' WHERE
				id_sec='".$this->getId()."'";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
		
	}
}

?>