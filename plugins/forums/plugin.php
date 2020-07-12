<?php
// $Id: plugins.php,v 0.1 29/11/2006 20:48 BitC3R0 Exp $  //
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
// @version: 0.1	                                              //

/**
 * Plugin creado para RMSOFT Bulletin que permite integrar las discusiones
 * en los foros al boletín
 * @author: BitC3R0
 * @copyright: Red México Soft
 */
class RMBForums extends RMBPlugin
{
	/**
	 * Activamos el plugin
	 */
	public function __construct(){
		/**
		 * La variable $_dir debe ser asignada antes de llamar
		 * la función activate()
		 */
		$this->_dir = 'forums';
		$this->activate();
		return true;
		
	}
	/**
	 * Creamos nuevo contenido
	 */
	public function newContent(RMForm &$form){
		
		$db =& $this->db;
		$form->setTitle($this->getString('newTitle'));
		
		if ($this->getConfig('showmode')){
			$result = $db->query("SELECT * FROM ".$db->prefix('bb_topics')." ORDER BY topic_replies DESC LIMIT 0,".$this->getConfig('limit'));
		} else {
			$result = $db->query("SELECT * FROM ".$db->prefix('bb_topics')." ORDER BY topic_time DESC LIMIT 0,".$this->getConfig('limit'));
		}
		
		$ele = new RMCheck($this->getString('select_topics'));
		while ($row = $db->fetchArray($result)){
			if ($this->getConfig('showmode')==0){
				$ele->addOption($row['topic_title'] . " <em>(" . date($this->getConfig('date'), $row['topic_time']) . ")</em>",'topics[]',$row['topic_id']);
			} else {
				$ele->addOption($row['topic_title'] . " " . sprintf($this->getString('replies_num'), $row['topic_replies']),'topics[]',$row['topic_id']);
			}
		}
		$form->addElement($ele);
	}
	// Guardar el contenido
	public function saveData(){
		
		$topics = isset($_POST['topics']) ? $_POST['topics'] : array();
		
		$items = array();
		
		foreach ($topics as $k){
			$items[] = "topic=$k&content=".$this->getConfig('content');
		}
		
		return $items;
		
	}
	public function preview($item){
		parse_str($item);
		$db =& $this->db;
		$result = $db->query("SELECT topic_id, topic_title FROM ".$db->prefix("bb_topics")." WHERE topic_id='$topic'");
		if ($db->getRowsNum($result)<=0){
			return false;
		}
		
		$row = $db->fetchArray($result);
		$rtn = "<a href='".XOOPS_URL."/modules/newbb/viewtopic.php?topic_id=$topic' target='_blank'>$row[topic_title]</a>";
		return $rtn;
	}
	public function editContent(RMForm $form, $item){
		
		parse_str($item);
		$db =& $this->db;
		$result = $db->query("SELECT topic_id, topic_title FROM ".$db->prefix("bb_topics")." WHERE topic_id='$topic'");
		if ($db->getRowsNum($result)<=0) return false;
		
		$row = $db->fetchArray($result);
		
		$form->addElement(new RMLabel($this->getString('selectedtopic'), "<strong>$row[topic_title]</strong>"));
		$ele = new RMSelect($this->getString('content'), 'content'); 
		$ele->addOption(0, $this->getString('nocontent'), $content==0 ? 1 : 0);
		$ele->addOption(1, $this->getString('contentold'), $content==1 ? 1 : 0);
		$ele->addOption(2, $this->getString('contentnew'), $content==2 ? 1 : 0);
		
		$form->addElement($ele);
		$form->addElement(new RMHidden('topic', $topic));
	}
	public function editData(){
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		if ($item<=0) return false;
		
		$rtn = "topic=$topic&content=$content";
		return $rtn;
	}
	public function deleteItem($params){
		return true;
	}
	public function getData($item){
		$myts =& MyTextSanitizer::getInstance();
		$db =& $this->db;
		parse_str($item);
		
		$result = $db->query("SELECT * FROM ".$db->prefix("bb_topics")." WHERE topic_id='$topic'");
		
		if ($db->getRowsNum($result)<=0){
			return false;
		}
		
		$row = $db->fetchArray($result);
		$rtn = array();
		$rtn['title'] = $row['topic_title'];
		$rtn['link'] = XOOPS_URL.'/modules/newbb/viewtopic.php?topic_id='.$topic;
		$tbl1 = $db->prefix("bb_posts");
		$tbl2 = $db->prefix("bb_posts_text");
		if ($content==1){
			
			$res = $db->query("SELECT $tbl1.post_id, $tbl2.post_text FROM $tbl1, $tbl2 WHERE $tbl1.topic_id=$topic AND $tbl2.post_id=$tbl1.post_id ORDER BY $tbl1.post_time LIMIT 0, 1");
			if ($db->getRowsNum($res)<=0) return;
			$rw = $db->fetchArray($res);
			$rtn['text'] = $myts->makeTareaData4Show($rw['post_text']);
		} elseif ($content==2){
			$res = $db->query("SELECT $tbl1.post_id, $tbl2.post_text FROM $tbl1, $tbl2 WHERE $tbl1.topic_id=$topic AND $tbl2.post_id=$tbl1.post_id ORDER BY $tbl1.post_time DESC LIMIT 0, 1");
			if ($db->getRowsNum($res)<=0) return;
			$rw = $db->fetchArray($res);
			$rtn['text'] = $myts->makeTareaData4Show($rw['post_text']);
		}
		return $rtn;
		
	}
}
?>