<?php
/*******************************************************************
* $Id: mail.class.php,v 1.0 08/09/2006 22:23 BitC3R0 Exp $         *
* --------------------------------------------------------         *
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
* --------------------------------------------------------         *
* mail.class.php:                                                  *
* Clase para el manejo de cuentas de Email                         *
* --------------------------------------------------------         *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0                                                    *
* @modificado: 08/09/2006 10:23:54 p.m.                            *
*******************************************************************/

class RMBMail extends RMObject
{

	private $_tbl;

	function __construct($id=null){
		
		$this->db =& Database::getInstance();
		$this->_tbl = $this->db->prefix("rmb_emails");
		
		if ($id==null){
			$this->initVar('id_mail',0);
			$this->initVar('smtp','');
			$this->initVar('user','');
			$this->initVar('password','');
			$this->initVar('limit',100);
			$this->initVar('from',100);
			$this->initVar('used',0);
			$this->setNew();
			return;
		}
		
		if ($id<=0) return false;
		
		$result = $this->db->query("SELECT * FROM $this->_tbl WHERE id_mail='$id'");
		if ($this->db->getRowsNum($result)<=0) return false;
		
		$row = $this->db->fetchArray($result);
		foreach ($row as $k => $v){
			$this->initVar($k,$v);
		}
		$this->unsetNew();
		return true;
	}
	
	public function setServer($value){
		return $this->setVar('smtp',$value);
	}
	public function getServer(){
		return $this->getVar('smtp');
	}
	
	public function setUser($value){
		return $this->setVar('user',$value);
	}
	public function getUser(){
		return $this->getVar('user');
	}
	
	public function setPass($value){
		return $this->setVar('password',$value);
	}
	public function getPass(){
		return $this->getVar('password');
	}
	
	public function setLimit($value){
		return $this->setVar('limit',$value);
	}
	public function getLimit(){
		return $this->getVar('limit');
	}
	
	public function getID(){
		return $this->getVar('id_mail');
	}
	
	public function setFrom($value){
		return $this->setVar('from', $value);
	}
	
	public function getFrom(){
		return $this->getVar('from');
	}
	
	public function setUsed($value){
		return $this->setVar('used', $value);
	}
	
	public function getUsed(){
		return $this->getVar('used');
	}
	
	public function save(){
		if ($this->isNew()){
			$sql = "INSERT INTO $this->_tbl (`smtp`,`user`,`password`,`from`,`limit`) VALUES ('".$this->getServer()."',
					'".$this->getUser()."','".$this->getPass()."','".$this->getFrom()."','".$this->getLimit()."')";
		} else {
			$sql = "UPDATE $this->_tbl SET `smtp`='".$this->getServer()."',`user`='".$this->getUser()."',
					`password`='".$this->getPass()."',`from`='".$this->getFrom()."',`limit`='".$this->getLimit()."',
					`used`='".$this->getUsed()."' WHERE id_mail='".$this->getID()."'";
		}
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	public function delete(){
		
		$this->db->queryF("DELETE FROM $this->_tbl WHERE id_mail='".$this->getID()."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
		
	}
	
}
?>
