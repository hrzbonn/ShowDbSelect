<?php

include_once ("class.ilShowDBSelectTableGUI.php");



//Ruft die Daten aus der Datenbank auf und verwaltet diese
//und übergibt diese an ilShowDBSelectTableGui welche den HtmlCode erzeugt
class ilTableListGUI
{

private $daten;
private $object;
private $columnnames;
private $columnnumber;

//Konstruktor setzt die Variabeln
//$objekt ist dabei das $this->object der ilObjShowDbSelectGUI 
function __construct($object)
{
	$this->daten=array();
	$this->columnnames=array();
	$this->object=$object;
}
//Gibt den Sql String zurück mithilfe der Funktion aus dem Objekt $this->object der Klasse ilObjShowDbSelectGUI
function getSQLString()
{
	return $this->object->getOptionSQL();
}
//Stellt die Datenbankverbindung her mithilfe der Funktion aus dem Objekt $this->object der Klasse ilObjShowDbSelectGUI
//Zudem wird der Sqlstring ausgewertet  und die Funktionen getColumnames aufgerufen sowie set Data
function setDataFromDb()
{
	$con = mysql_connect($this->object->getOptionServer(),$this->object->getOptionUser(),$this->object->getOptionPW());
 	if (!$con) $content = 'Keine Verbindung zur Datenbank' . mysql_error();
 	if (!mysql_select_db($this->object->getOptionDB())) $content = "Datenbank nicht vorhanden";
	$query=mysql_query($this->getSQLString());
	$this->columnnames=$this->getColumnnames($query);
	$this->setData($query);
}
//Gibt die Spaltennamen mithilfe des SqlQuerys zurück
function getColumnnames($query)
{
		$field = mysql_num_fields($query);
        for ($i=0;$i<$field;$i++)
		{
            $names[] = mysql_field_name($query,$i);
        }
		$this->columnnumber=count($names);
        return $names;
}
//Setzt die Daten aus dem Query in einen Array welcher im Daten Array gespeichert wird da die Tabelle einen 2D Array
//in der Form: array(array(Spaltenname=>Inhalt,Spaltenname2=>Inhalt2),array(Spaltenname=>Inhalt3,Spaltenname2=>Inhalt4)) erwartet
function setData($query)
{
	while ($row = mysql_fetch_array($query))
	{
		$column_array=array();
		for($i=0;$i<$this->columnnumber;$i++)
		{
			$rowname=$this->columnnames[$i];
			$column_array[$rowname]=$row["$rowname"];
		}
		array_push($this->daten,$column_array);
	}
}

//Wird aufgerufen in der Klasse ilObjShowDbSelectGUI um den HTML-Code zu erhalten
//Zuerst wird die FUnktion setDataFromDb aufgerufen um die Daten aus der Datenbank auszuwerten und zu speichern
//Dann wird die Tablle erstellt durch new ilShowDbSelectTableGUI($this,"cmdBefehl"); wobei Cmdbefehl die Funktion ist in welcher ilTableListGUI aufgerufen wird was in diesem Falle showContent ist
//anschließend werden Spaltenname und Spaltenanzahl sowie TabellenTitel und die Daten an die Tabelle übergeben
//abschließend wird über die HtmlCode Funktion der Tabelle der HtmlCode zurückgegeben.
function getHTML()
{
	$this->setDataFromDb();
	$table=new ilShowDbSelectTableGUI($this,"showContent");
	
	$table->setColumnnames($this->columnnames);
	$table->setColumnnumber($this->columnnumber);
	$table->setTableTitle("Liste");
	$table->setmyData($this->daten);
	
	return $table->getTableHTMLCODE();
}
	
}


?>