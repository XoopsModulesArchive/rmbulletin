<?php
// $Id: plugin.php,v 0.5 29/11/2006 20:38 BitC3R0 Exp $  //
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
// @version: 0.5	                                              //

include_once XOOPS_ROOT_PATH.'/rmcommon/form.class.php';

class RMBNews extends RMBPlugin
{

	public function __construct(){
		/**
		 * La variable $_dir debe ser asignada antes de llamar
		 * la función activate()
		 */
		$this->_dir = 'news';
		$this->activate();
		return true;
		
	}
	
	public function moduleExists(){
		return $this->moduleInstalled('news');
	}
	/**
	 * Función para mostrar el formulario de creación
	 * de nuevo contenido con este plugin
	 * ===REQUERIDA===
	 */
	public function	newContent(RMForm &$form){
		global $boletin;
		
		$myts = MyTextSanitizer::getInstance();
		
		$form->setTitle($this->getString('newtitle'));
		$ele = new RMCheck($this->getString('selectnews'));
		
		// Cargamos las noticias
		$result = $this->db->query("SELECT storyid,uid,title,published,hometext FROM ".$this->db->prefix("stories")." ORDER BY published DESC LIMIT 0,".$this->getConfig('newsnumber'));
		while ($row = $this->db->fetchArray($result)){
			$ele->addOption($row['title']." <span style='font-size: 10px;'>(".$this->getString('date')." ".date($this->getConfig('dateformat'),$row['published']).")</span>",'articles[]',$row['storyid'], 0);
		}
		$form->addElement($ele);
		$form->addElement(new RMYesNo($this->getString('showauthor'),'author',1));
		$form->addElement(new RMYesNo($this->getString('showdate'),'date',1));
		$form->addElement(new RMYesNo($this->getString('showtext'),'text',1));
		$form->addElement(new RMLabel('',"<span style='font-size: 10px;'>".$this->getString('paramsdesc')."</span>"));
	}
	/**
	 * Función para procesar los datos a guardar.
	 * Esta función debe devolver un array con los elementos a
	 * insertar en el contenido del boletín
	 * Se puede usar para procesar los datos de la manera mas conveniente
	 * @params array $_POST
	 * @return array con los parámetros a insertar
	 *   Ej.  $rtn[0] = 'Parametros', $rtn[1] = 'Parámetros'
	 */
	public function saveData(){
		
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		$items = array();
		
		foreach ($articles as $k){
			$items[] = "article=$k".($author==1 ? "&autor=1" : '').($date==1 ? "&date=1" : '').($text==1 ? "&text=1" : '');
		}
		
		return $items;
	}
	/**
	 * Esta función permite generar los parámetros a guardar
	 * cuando se edita un elemento
	 */
	public function editData(){
		
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		if ($item<=0) return false;
		
		$rtn = "article=$article".($author==1 ? "&autor=1" : '').($date==1 ? "&date=1" : '').($text==1 ? "&text=1" : '');
		return $rtn;
	}
	/**
	 * Función utilizada para eliminar un elemento
	 * @return bool
	 */
	public function deleteItem($params){
		return true;
	}
	/**
	 * Esta función permite generar una vista previa del item
	 * @param string $item Parámetros del elemento
	 */
	public function preview($item){
		
		$myts = MyTextSanitizer::getInstance();
		parse_str($item);
		
		$result = $this->db->query("SELECT storyid,title,hometext FROM ".$this->db->prefix("stories")." WHERE storyid='$article'");
		if ($this->db->getRowsNum($result)<=0){
			return false;
		}
		
		$row = $this->db->fetchArray($result);
		
		$rtn = "<a href='".XOOPS_URL."/modules/news/article.php?storyid=$article' target='_blank'>$row[title]</a>";
		return $rtn;
	}
	/**
	 * Esta función edita un item del contenido
	 * @param RMForm $form
	 * @param string $item Parámetros del elemento
	 */
	public function editContent(RMForm $form,$item){
		
		$id = isset($_GET['item']) ? $_GET['item'] : '';
		parse_str($item);
		
		$result = $this->db->query("SELECT storyid,title FROM ".$this->db->prefix("stories")." WHERE storyid='$article'");
		if ($this->db->getRowsNum($result)<=0){
			return false;
		}
		
		$row = $this->db->fetchArray($result);
		
		$form->addElement(new RMLabel($this->getString('artitcletitle'),"<strong>".$row['title']."</strong>"));
		$form->addElement(new RMHidden('article', $row['storyid']));
		$form->addElement(new RMYesNo($this->getString('showauthor'),'author',(isset($autor) ? $autor : 0)));
		$form->addElement(new RMYesNo($this->getString('showdate'),'date',(isset($date) ? $date : 0)));
		$form->addElement(new RMYesNo($this->getString('showtext'),'text',(isset($text) ? $text : 0)));
	}
	/**
	 * Esta función devuelve el contenido de un elemento
	 * correctamente formateado
	 */
	function getData($item){
		
		$myts =& MyTextSanitizer::getInstance();
		
		parse_str($item);
		$result = $this->db->query("SELECT storyid,uid,title,published,hometext FROM ".$this->db->prefix("stories")." WHERE storyid='$article'");
		if ($this->db->getRowsNum($result)<=0){
			return false;
		}
		$row = $this->db->fetchArray($result);
		
		$rtn = array();
		$rtn['title'] = $myts->makeTboxData4Show($row['title']);
		$rtn['link'] = XOOPS_URL."/modules/news/article.php?storyid=$article";
		$rtntext = '';
		if ($text==1){
			$rtntext .= $myts->makeTareaData4Show($row['hometext']);
		}
		$rtn['text'] = $rtntext;
		$rtntext = '';
		if ($autor==1){
			$ra = $this->db->query("SELECT uid,uname FROM ".$this->db->prefix("users")." WHERE uid='$row[uid]'");
			if ($this->db->getRowsNum($ra)>0){
				$rar = $this->db->fetchArray($ra);
				$rtntext = $this->getString('autor')." <strong>".$rar['uname']."</strong>";
			}
		}
		if ($date==1){
			$rtntext .= " | ".date($this->getConfig('dateformat'), $row['published']);
		}
		$rtn['extra'] = $rtntext;

		return $rtn;
	}
	
}
?>
