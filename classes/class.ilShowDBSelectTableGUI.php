<?php
include_once ('Services/Table/classes/class.ilTable2GUI.php');
class ilShowDbSelectTableGUI extends ilTable2GUI
{
	
	 //Konstruktor initialisiert Variabeln mit Default-Werten und setzt das Template
	 //Muss für neue Tabelle nur übernommen werden und der Templatepfad angepasst werden
	 //Das Template welches benötigt wird kann aus dem Ordner Template/default genommen werden
    function __construct($a_parent_obj, $a_parent_cmd)
    {
        global $ilCtrl,$ilUser;
		

        parent::__construct($a_parent_obj, $a_parent_cmd);

		//aktiviert oben rechts in der Tabelle ein Häckchen mit Zeilen in der gewählt werden kann
		//wieviele Zeilen angezeigt werden sollen
        $this->setShowRowsSelector(true);        
        $this->setFormAction($ilCtrl->getFormAction($a_parent_obj));
        // sets the template which describe the appearance of the table
        $this->rowtemplate="tpl.table3.html";
        $this->rowtemplatepath=$template_path;
        $this->setRowTemplate($this->rowtemplate,
            '/Customizing/global/plugins/Services/Repository/RepositoryObject/ShowDbSelect');
        
    }

	
	
	
	
	
	//Setzt die Daten welche in die Zeilen kommen sollen
    //Muss ein Array der folgenden Form sein: array(array('row1 column1','row1 column2'),array('row2 column1','row 2 column2'))
    //Die Arrays im Array müssen assoziativ sein
    function setmyData($data)
    {
        $this->setData($data);
    }
	//Setzt den Tabellentitel
	 function setTableTitle($title)
    {
        $this->tableTitle=$title;
    }
	//Setzt die Spaltenanzahl
	function setColumnnumber($columnumber)
	{
		$this->columnnumber=$columnumber;
	}
	//setzt die Spalten Namen
	function setColumnnames($columnnames)
	{
		$this->columnnames=$columnnames;
	}

	 //Beendet die Tabelle und gibt deren HTML-Code zurück
    function getTableHTMLCODE()
    {
        global $lng;

		for($i=0;$i<$this->columnnumber;$i++)
		{
			$width=100/$this->columnnumber; // Berechnung der breite einer Spalte in Prozent d.h im Augenblick 100%/Anzahl der Spalten
			$this->addColumn($this->columnnames[$i],$this->columnnames[$i],$width."%");//Erstellen einer Spalte (im Html <th></th>) erstes argument einfach der Spaltenname zweites
			// Argument ist die Bezeichung in der Datenbank(in diesem Falle identisch zum Spalten name) und das Dritte Argument ist die Spaltenbreite wobei noch ein Prozentzeichen ergänzt werden muss 
		}
        $this->setTitle($this->tableTitle);
        return $this->getHTML();
    }

	//Gibt die Daten an das Standardtemplate zur Ausgabe weiter
	//Muss bei neuer Tabelle einfach übernommen werden
    protected function fillRow($a_set)
    {
        $this->tpl->setCurrentBlock("tbl_content_cell");
        foreach ((array) $a_set as $key => $value)
        {
                if ($value == false OR $value == NULL OR strlen($value) == 0) {
                    $value = ' ';
                }
                $this->tpl->setVariable("TBL_CONTENT_CELL", $value);
                $this->tpl->parseCurrentBlock();
        }
        $this->tpl->setCurrentBlock("tbl_content_row");
        $this->tpl->parseCurrentBlock();
    }


}

?>