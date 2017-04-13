<?php
/*
	+-----------------------------------------------------------------------------+
	| ILIAS open source                                                           |
	+-----------------------------------------------------------------------------+
	| Copyright (c) 1998-2009 ILIAS open source, University of Cologne            |
	|                                                                             |
	| This program is free software; you can redistribute it and/or               |
	| modify it under the terms of the GNU General Public License                 |
	| as published by the Free Software Foundation; either version 2              |
	| of the License, or (at your option) any later version.                      |
	|                                                                             |
	| This program is distributed in the hope that it will be useful,             |
	| but WITHOUT ANY WARRANTY; without even the implied warranty of              |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
	| GNU General Public License for more details.                                |
	|                                                                             |
	| You should have received a copy of the GNU General Public License           |
	| along with this program; if not, write to the Free Software                 |
	| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
	+-----------------------------------------------------------------------------+
*/

include_once("./Services/Repository/classes/class.ilObjectPlugin.php");

/**
* Application class for example repository object.
*
* @author Alex Killing <alex.killing@gmx.de>
*
* $Id$
*/
class ilObjShowDbSelect extends ilObjectPlugin
{
	/**
	* Constructor
	*
	* @access	public
	*/
	function __construct($a_ref_id = 0)
	{
		parent::__construct($a_ref_id);
	}
	

	/**
	* Get type.
	*/
	final function initType()
	{
		$this->setType("xdbs");
	}
	
	/**
	* Create object
	*/
	function doCreate()
	{
		global $ilDB;
		
		$ilDB->manipulate("INSERT INTO rep_robj_xdbs_data ".
			"(id, is_online) VALUES (".
			$ilDB->quote($this->getId(), "integer").",".
			$ilDB->quote(0, "integer").
			")");
	}
	
	/**
	* Read data from db
	*/
	function doRead()
	{
		global $ilDB;
		
		$set = $ilDB->query("SELECT * FROM rep_robj_xdbs_data ".
			" WHERE id = ".$ilDB->quote($this->getId(), "integer")
			);
		while ($rec = $ilDB->fetchAssoc($set))
		{
			$this->setOnline($rec["is_online"]);
			$this->setOptionServer($rec["option_server"]);
			$this->setOptionUser($rec["option_user"]);
			$this->setOptionPW($rec["option_pw"]);
			$this->setOptionDB($rec["option_db"]);
			$this->setOptionSQL($rec["option_sql"]);
		}
	}
	
	/**
	* Update data
	*/
	function doUpdate()
	{
		global $ilDB;
		
		$ilDB->manipulate($up = "UPDATE rep_robj_xdbs_data SET ".
			" is_online = ".$ilDB->quote($this->getOnline(), "integer").",".
			" option_server = ".$ilDB->quote($this->getOptionServer(), "text").",".
			" option_user = ".$ilDB->quote($this->getOptionUser(), "text").",".
			" option_pw = ".$ilDB->quote($this->getOptionPW(), "text").",".
			" option_db = ".$ilDB->quote($this->getOptionDB(), "text").",".
			" option_sql = ".$ilDB->quote($this->getOptionSQL(), "text").
			" WHERE id = ".$ilDB->quote($this->getId(), "integer")
			);
	}
	
	/**
	* Delete data from db
	*/
	function doDelete()
	{
		global $ilDB;
		
		$ilDB->manipulate("DELETE FROM rep_robj_xdbs_data WHERE ".
			" id = ".$ilDB->quote($this->getId(), "integer")
			);
		
	}
	
	/**
	* Do Cloning
	*/
	function doClone($a_target_id,$a_copy_id,$new_obj)
	{
		global $ilDB;
		
		$new_obj->setOnline($this->getOnline());
		$new_obj->setOptionServer($this->getOptionServer());
		$new_obj->setOptionUser($this->getOptionUser());
		$new_obj->setOptionPW($this->getOptionPW());
		$new_obj->setOptionDB($this->getOptionDB());
		$new_obj->setOptionSQL($this->getOptionSQL());
		$new_obj->update();
	}
	
//
// Set/Get Methods for our example properties
//

	/**
	* Set online
	*
	* @param	boolean		online
	*/
	function setOnline($a_val)
	{
		$this->online = $a_val;
	}
	
	/**
	* Get online
	*
	* @return	boolean		online
	*/
	function getOnline()
	{
		return $this->online;
	}
	
	/**
	* Set option Server
	*
	* @param	string		option server
	*/
	function setOptionServer($a_val)
	{
		$this->option_server = $a_val;
	}
	
	/**
	* Get option Server
	*
	* @return	string		option server
	*/
	function getOptionServer()
	{
		return $this->option_server;
	}
	
	/**
	* Set option User
	*
	* @param	string		option user
	*/
	function setOptionUser($a_val)
	{
		$this->option_user = $a_val;
	}
	
	/**
	* Get option User
	*
	* @return	string		option user
	*/
	function getOptionUser()
	{
		return $this->option_user;
	}
	
	/**
	* Set option PW
	*
	* @param	string		option pw
	*/
	function setOptionPW($a_val)
	{
		$this->option_pw = $a_val;
	}
	
	/**
	* Get option PW
	*
	* @return	string		option pw
	*/
	function getOptionPW()
	{
		return $this->option_pw;
	}
	
	/**
	* Set option DB
	*
	* @param	string		option db
	*/
	function setOptionDB($a_val)
	{
		$this->option_db = $a_val;
	}
	
	/**
	* Get option DB
	*
	* @return	string		option db
	*/
	function getOptionDB()
	{
		return $this->option_db;
	}
	
		/**
	* Set option SQL
	*
	* @param	string		option sql
	*/
	function setOptionSQL($a_val)
	{
		$this->option_sql = $a_val;
	}
	
	/**
	* Get option SQL
	*
	* @return	string		option sql
	*/
	function getOptionSQL()
	{
		return $this->option_sql;
	}

}
?>
