<?php
/*******************************************************************
* $Id: plugin.php,v 1.0 09/09/2006 17:42 BitC3R0 Exp $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* plugin.php:                                                      *
* Archivo principal del plugin                                     *
* ----------------------------------------------------             *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.0                                                    *
* @modificado: 09/09/2006 05:42:54 p.m.                            *
*******************************************************************/

class RMBCustom extends RMBPlugin
{
	public function __construct(){
		/**
		 * La variable $_dir debe ser asignada antes de llamar
		 * la función activate()
		 */
		$this->_dir = 'custom';
		$this->activate();
		return true;
		
	}
	
	public function	newContent(RMForm &$form){
		global $mc;
		$form->addElement(new RMText($this->getString('title'),'titulo'));
		$form->addElement(new RMEditor($this->getString('contenido'), 'content', '100%','300px','',$mc['editor']),true);
		$ele = new RMText($this->getString('link'),'link',50,255,'http://');
		$ele->setDescription($this->getString('link_desc'));
		$form->addElement($ele);
		
	}
	
	public function editContent(RMForm $form,$param){
		global $mc;
		$myts = MyTextSanitizer::getInstance();
		
		parse_str($param);
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_plg_custom")." WHERE id_cus='$item'");
		
		if ($this->db->getRowsNum($result)<=0){
			return false;
		}
		$row = $this->db->fetchArray($result);
		
		$form->addElement(new RMText($this->getString('title'),'titulo',50,255,$myts->makeTboxData4Edit($row['titulo'])));
		$form->addElement(new RMEditor($this->getString('contenido'), 'content', '100%','300px',$myts->makeTareaData4Edit($row['content']),$mc['editor']),true);
		$ele = new RMText($this->getString('link'),'link',50,255,$myts->makeTboxData4Edit($row['link']));
		$ele->setDescription($this->getString('link_desc'));
		$form->addElement($ele);
		$form->addElement(new RMHidden('id_cus',$item));
		
	}
	
	public function saveData(){
	
		$myts = MyTextSanitizer::getInstance();
	
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		if ($titulo=='') $titulo = '';
		if ($link=='') $link = '';
		if ($content==''){
			$this->addError($this->getString('errcontent'));
			return false;
		}
		
		$titulo = $myts->makeTboxData4Save($titulo);
		$link = $myts->makeTboxData4Save($link);
		$content = $myts->makeTareaData4Save($content);
		
		$this->db->query("INSERT INTO ".$this->db->prefix("rmb_plg_custom")." (`titulo`,`content`,`link`)
				VALUES ('$titulo','$content','$link')");
		
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		}
		
		$id = $this->db->getInsertId();
		
		$rtn = array();
		
		$rtn[] = "item=$id";
		
		return $rtn;
	
	}
	
	public function editData(){
		
		$myts =& MyTextSanitizer::getInstance();
		
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		if ($id_cus<=0) return false;
		
		if ($titulo=='') $titulo = '';
		if ($link=='') $link = '';
		if ($content==''){
			$this->addError($this->getString('errcontent'));
			return false;
		}
		
		$titulo = $myts->makeTboxData4Save($titulo);
		$link = $myts->makeTboxData4Save($link);
		$content = $myts->makeTareaData4Save($content);
		
		$sql = "UPDATE ".$this->db->prefix("rmb_plg_custom")." SET `titulo`='".$myts->makeTboxData4Save($titulo)."',
				`content`='".$content."',
				`link`='".$myts->makeTboxData4Save($link)."' WHERE id_cus='$id_cus'";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		}
		return "item=$id_cus";
		
	}
	
	public function deleteItem($params){
		parse_str($params);
		
		if ($item<=0){
			return false;
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_plg_custom")." WHERE id_cus='$item'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		}
		
		return true;
		
	}
	
	public function preview($param){
		
		$myts = MyTextSanitizer::getInstance();

		parse_str($param);
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_plg_custom")." WHERE id_cus='$item'");
		
		if ($this->db->getRowsNum($result)<=0){
			return '';
		}
		
		$row = $this->db->fetchArray($result);
		
		$rtn = '';
		if ($row['titulo']!=''){
			$rtn .= $row['link']!='' ? "<a href='$row[link]' target='_blank'>".$myts->makeTboxData4Show($row['titulo'],1,1,1)."</a><br />" : "<strong>".$myts->makeTboxData4Show($row['titulo'],1,1,1)."</strong><br />";
		}
		
		return $rtn;
		
	}
	
	function getData($param){
		
		$myts = MyTextSanitizer::getInstance();
		
		parse_str($param);
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_plg_custom")." WHERE id_cus='$item'");
		
		if ($this->db->getRowsNum($result)<=0){
			return '';
		}
		
		$row = $this->db->fetchArray($result);
		
		$rtn = array();
		$rtn['title'] = $myts->makeTboxData4Show($row['titulo']);
		$rtn['link'] = $myts->makeTboxData4Show($row['link']);
		$rtn['text'] = $myts->makeTareaData4Show($row['content']);
		return $rtn;
	}
}
?>