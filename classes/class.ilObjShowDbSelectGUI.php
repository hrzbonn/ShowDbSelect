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


include_once("./Services/Repository/classes/class.ilObjectPluginGUI.php");

/**
* User Interface class for example repository object.
*
* User interface classes process GET and POST parameter and call
* application classes to fulfill certain tasks.
*
* @author Alex Killing <alex.killing@gmx.de>
*
* $Id$
*
* Integration into control structure:
* - The GUI class is called by ilRepositoryGUI
* - GUI classes used by this class are ilPermissionGUI (provides the rbac
*   screens) and ilInfoScreenGUI (handles the info screen).
*
* @ilCtrl_isCalledBy ilObjShowDbSelectGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI, ilShowDBSelectTableGUI, ilTableListGUI,ilShowDbSelectTableGUI
* @ilCtrl_Calls ilObjShowDbSelectGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI, ilTableListGUI,ilShowDbSelectTableGUI
*
*/
class ilObjShowDbSelectGUI extends ilObjectPluginGUI
{
	/**
	* Initialisation
	*/
	protected function afterConstructor()
	{
		// anything needed after object has been constructed
		// - example: append my_id GET parameter to each request
		//   $ilCtrl->saveParameter($this, array("my_id"));
	}
	
	/**
	* Get type.
	*/
	final function getType()
	{
		return "xdbs";
	}
	
	/**
	* Handles all commmands of this class, centralizes permission checks
	*/
	function performCommand($cmd)
	{
		switch ($cmd)
		{
			case "editProperties":		// list all commands that need write permission here
			case "updateProperties":
			//case "...":
				$this->checkPermission("write");
				$this->$cmd();
				break;
			
			case "showContent":			// list all commands that need read permission here
			case "start":
			//case "...":
				$this->checkPermission("read");
				$this->$cmd();
				break;
		}
	}

	/**
	* After object has been created -> jump to this command
	*/
	function getAfterCreationCmd()
	{
		return "editProperties";
	}

	/**
	* Get standard command
	*/
	function getStandardCmd()
	{
		return "start";
	}
	function start()
	{
		global $ilCtrl;
		$ilCtrl->redirect($this,"showContent");	
	}
	
//
// DISPLAY TABS
//
	
	/**
	* Set tabs
	*/
	function setTabs()
	{
		global $ilTabs, $ilCtrl, $ilAccess;
		
		// tab for the "show content" command
		if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
		{
			$ilTabs->addTab("content", $this->txt("content"), $ilCtrl->getLinkTarget($this, "showContent"));
		}

		// standard info screen tab
		$this->addInfoTab();

		// a "properties" tab
		if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
		{
			$ilTabs->addTab("properties", $this->txt("properties"), $ilCtrl->getLinkTarget($this, "editProperties"));
		}

		// standard epermission tab
		$this->addPermissionTab();
	}
	

// THE FOLLOWING METHODS IMPLEMENT SOME EXAMPLE COMMANDS WITH COMMON FEATURES
// YOU MAY REMOVE THEM COMPLETELY AND REPLACE THEM WITH YOUR OWN METHODS.

//
// Edit properties form
//

	/**
	* Edit Properties. This commands uses the form class to display an input form.
	*/
	function editProperties()
	{
		global $tpl, $ilTabs;
		
		$ilTabs->activateTab("properties");
		$this->initPropertiesForm();
		$this->getPropertiesValues();
		$tpl->setContent($this->form->getHTML());
	}
	
	/**
	* Init  form.
	*
	* @param        int        $a_mode        Edit Mode
	*/
	public function initPropertiesForm()
	{
		global $ilCtrl;
	
		include_once("Services/Form/classes/class.ilPropertyFormGUI.php");
		$this->form = new ilPropertyFormGUI();
	
		// title
		$ti = new ilTextInputGUI($this->txt("title"), "title");
		$ti->setRequired(true);
		$this->form->addItem($ti);
		
		// description
		$ta = new ilTextAreaInputGUI($this->txt("description"), "desc");
		$this->form->addItem($ta);
		
		// online
		$cb = new ilCheckboxInputGUI($this->lng->txt("online"), "online");
		$this->form->addItem($cb);
		
		// Server
		$ti = new ilTextInputGUI($this->txt("option_server"), "opserver");
		$this->form->addItem($ti);
		
		// DB-Nutzer
		$ti = new ilTextInputGUI($this->txt("option_user"), "opuser");
		$ti->setMaxLength(30);
		$ti->setSize(30);
		$this->form->addItem($ti);

		// DB-Passwort
		//$ti = new ilPasswordInputGUI($this->txt("option_pw"), "oppw");
		$ti = new ilTextInputGUI($this->txt("option_pw"), "oppw");
		$this->form->addItem($ti);
		
		// DB-Datenbank
		$ti = new ilTextInputGUI($this->txt("option_db"), "opdb");
		$this->form->addItem($ti);
		
		// SQL-Statement
		//$ti = new ilTextInputGUI($this->txt("option_sql"), "opsql");
		$ti = new ilTextAreaInputGUI($this->txt("option_sql"), "opsql");
		$this->form->addItem($ti);

		$this->form->addCommandButton("updateProperties", $this->txt("save"));
	                
		$this->form->setTitle($this->txt("edit_properties"));
		$this->form->setFormAction($ilCtrl->getFormAction($this));
	}
	
	/**
	* Get values for edit properties form
	*/
	function getPropertiesValues()
	{
		$values["title"] = $this->object->getTitle();
		$values["desc"] = $this->object->getDescription();
		$values["online"] = $this->object->getOnline();
		$values["opserver"] = $this->object->getOptionServer();
		$values["opuser"] = $this->object->getOptionUser();
		//$values["oppw"] = $this->object->getOptionPW();
		$values["opdb"] = $this->object->getOptionDB();
		$values["opsql"] = $this->object->getOptionSQL();
		$this->form->setValuesByArray($values);
	}
	
	/**
	* Update properties
	*/
	public function updateProperties()
	{
		global $tpl, $lng, $ilCtrl;
	
		$this->initPropertiesForm();
		if ($this->form->checkInput())
		{
			$this->object->setTitle($this->form->getInput("title"));
			$this->object->setDescription($this->form->getInput("desc"));
			$this->object->setOptionServer($this->form->getInput("opserver"));
			$this->object->setOptionUser($this->form->getInput("opuser"));
			if ($this->form->getInput("oppw") != "") $this->object->setOptionPW($this->form->getInput("oppw"));
			$this->object->setOptionDB($this->form->getInput("opdb"));
			$this->object->setOptionSQL($this->form->getInput("opsql"));
			$this->object->setOnline($this->form->getInput("online"));			
			$con = mysql_connect($this->object->getOptionServer(),$this->object->getOptionUser(),$this->object->getOptionPW()); // Einstellungen auf Richtigkeit prüfen
			if ($con) $this->object->update();
			ilUtil::sendSuccess($lng->txt("msg_obj_modified"), true);
			$ilCtrl->redirect($this, "editProperties");
		}

		$this->form->setValuesByPost();
		$tpl->setContent($this->form->getHtml());
	}
	
//
// Show content
//

	/**
	* Show content
	*/
	function showContent()
	{
	global $tpl, $ilTabs;
		
	$ilTabs->activateTab("content");
	
	//Aufrufen der TableListGui welche den HTML-Code zurückgibt.
	//Welcher durch setContent ausgegeben wird.
	//TableListGui Verantwortlich für die Datenbeschaffung der Tablle
	include_once("class.ilTableListGUI.php");
	$table= new ilTableListGUI($this->object);
	$content=$table->getHTML();
	$tpl->setContent($content);
	}
	
	// Rückgabe des Links zur Änderung der Sortierreihenfolge
    private function getLink($field,$ndir)
    {
        $link = $_SERVER["REQUEST_URI"];
        $zeichen_eins = strpos($link, 'cmd');
        $zeichen_zwei = strpos($link, '&cmdClass', $zeichen_eins);

        return substr_replace($link, 'showContent&sortcol=' . $field . '&dir='.$ndir, $zeichen_eins + 4, $zeichen_zwei - $zeichen_eins - 4);
        
    }

}
?>
