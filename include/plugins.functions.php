<?php
/*******************************************************************
* $Id: plugins.functions.php,v 1.0 06/09/2006 13:30 BitC3R0 Exp $  *
* ---------------------------------------------------------------  *
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
* ---------------------------------------------------------------  *
* plugins.functions.php:                                           *
* Funciones para el manejo de plugins                              *
* ---------------------------------------------------------------  *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0                                                    *
* @modificado: 06/09/2006 01:30:54 p.m.                            *
*******************************************************************/

function showFooter(){
	/**
	 * IMPORTANT: Please don't remove or change the next lines. Help us to create this modules
	 * IMPORTANTE:	Por favor no remuevas o modifiques las siguientes lineas. Ayudanosa seguir creando módulos
	 */
	$rtn = "Powered by <a href=\"http://www.redmexico.com.mx/modules/rmmf/\">RMSOFT Bulletin 1.0</a> &nbsp; &bull;
			&nbsp; Download at <a href=\"http://www.xoops-mexico.net\">XOOPS México</a><br /><br />	
			<script language='JavaScript' type='text/javascript' src='http://ads.xoops-mexico.net/adx.js'></script>
			<script language='JavaScript' type='text/javascript'>
			<!--
			   if (!document.phpAds_used) document.phpAds_used = ',';
			   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
			   
			   document.write (\"<\" + \"script language='JavaScript' type='text/javascript' src='\");
			   document.write (\"http://ads.xoops-mexico.net/adjs.php?n=\" + phpAds_random);
			   document.write (\"&amp;what=zone:18&amp;block=1&amp;blockcampaign=1\");
			   document.write (\"&amp;exclude=\" + document.phpAds_used);
			   if (document.referrer)
				  document.write (\"&amp;referer=\" + escape(document.referrer));
			   document.write (\"'><\" + \"/script>\");
			//-->
			</script><noscript><a href='http://ads.xoops-mexico.net/adclick.php?n=afb1a97e' target='_blank'><img src='http://ads.xoops-mexico.net/adview.php?what=zone:18&amp;n=afb1a97e' border='0' alt=''></a></noscript>";
	return $rtn;
}

?>