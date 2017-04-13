<?php

include_once("./Services/Repository/classes/class.ilRepositoryObjectPlugin.php");
 
/**
* Example repository object plugin
*
* @author Alex Killing <alex.killing@gmx.de>
* @version $Id$
*
*/
class ilShowDbSelectPlugin extends ilRepositoryObjectPlugin
{
	function getPluginName()
	{
		return "ShowDbSelect";
	}
	
	final protected function uninstallCustom()
	{
		global $ilDB;
		$mySqlString="DROP TABLE IF EXISTS  rep_robj_xdbs_data";
		$ilDB->query($mySqlString);
	}
}
?>
