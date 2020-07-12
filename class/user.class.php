<?php
/*******************************************************************
* $Id: user.class.php,v 1.1 08/09/2006 12:31 BitC3R0 Exp $         *
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
* user.class.php:                                                  *
* Clase para el control de Usuarios                                *
* --------------------------------------------------------         *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.1                                                    *
* @modificado: 08/09/2006 12:31:12 p.m.                            *
*******************************************************************/

class RMBUser extends RMObject
{
	private $_xUser = '';
	private $_tbl = '';
	
	public function __construct($id=null){
		
		$this->db =& Database::getInstance();
		$this->_tbl = $this->db->prefix("rmb_users");
		
		if ($id==null){
			$this->initVar('id_user', 0);
			$this->initVar('uid', 0);
			$this->initVar('alta', 0);
			$this->initVar('registered', 0);
			$this->initVar('email', '');
			$this->initVar('code','');
			$this->setNew();
			return;
		}
		
		//if ($id<=0) return false;
		
		if (checkEmail($id)){
			$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_users")." WHERE email='$id'");
		} else {
			$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmb_users")." WHERE id_user='$id'");
		}
		
		if ($this->db->getRowsNum($result)<=0){
			$this->initVar('id_user', 0);
			$this->initVar('uid', 0);
			$this->initVar('alta', 0);
			$this->initVar('registered', 0);
			$this->initVar('email', '');
			$this->initVar('code','');
			$this->setNew();
			return false;
		}
		
		$row = $this->db->fetchArray($result);
		foreach ($row as $k => $v){
			$this->initVar($k, $v);
		}
		
		if ($this->getVar('register')==1){
			$this->_xUser = new XoopsUser($this->getVar('uid'));
		}
		
		$this->unsetNew();
		return true;
		
	}
	
	public function setEmail($value){
		
		if (!checkEmail($value)){
			return false;
		}
		
		return $this->setVar('email', $value);
		
	}
	public function getEmail(){
		return $this->getVar('email');
	}
	
	public function setRegister($value){
		return $this->setVar('registered',$value);
	}
	/**
	 * Redefinimos la función getVar
	 */
	public function getVar($var, $type=0, $format='s'){
		if (isset($this->vars[$var])){
			return parent::getVar($var, $type);
		} else {
			if (get_class($this->_xUser)=='XoopsUser'){ return $this->_xUser->getVar($var, $format); }
		}
	}
	
	public function setXUser($id){
		$this->_xUser = new XoopsUser($id);
		return $this->setVar('uid', $id);
	}
	
	public function setCode($value){
		$this->setVar('code', $value);
	}
	public function getCode(){
		return $this->getVar('code');
	}
	
	public function userExists(){
		
		$result = $this->db->query("SELECT COUNT(*) FROM $this->_tbl WHERE email='".$this->getVar('email')."'");
		list($num) = $this->db->fetchRow($result);
		if ($num<=0){
			return false;
		} else {
			return true;
		}
		
	}
	
	public function save(){
		
		if ($this->isNew()){
			
			if ($this->userExists()) return false;
			
			$sql = "INSERT INTO $this->_tbl (`uid`,`alta`,`registered`,`email`,`code`) VALUES
					('".$this->getVar('uid')."','".time()."','".$this->getVar('registered')."','".$this->getVar('email')."',
					'".$this->getCode()."')";
			$this->db->queryF($sql);
			if ($this->db->error()!=''){
				$this->addError($this->db->error());
				return false;
			} else {
				return true;
			}
			
		} else {
			
			$sql = "UPDATE $this->_tbl SET `uid`='".$this->getVar('uid')."',
					`registered`='".$this->getVar('registered')."',`email`='".$this->getVar('email')."',
					`code`='".$this->getVar('code')."' WHERE id_user='".$this->getVar('id_user')."'";
			$this->db->queryF($sql);
			if ($this->db->error()!=''){
				$this->addError($this->db->error());
				return false;
			} else {
				return true;
			}
			
		}
		
	}
	
	function delete(){
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmb_users")." WHERE id_user='".$this->getVar('id_user')."'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
		
	}
	
}

?>