<#1>
<?php
$fields = array(
	'id' => array(
		'type' => 'integer',
		'length' => 4,
		'notnull' => true
	),
	'is_online' => array(
		'type' => 'integer',
		'length' => 1,
		'notnull' => false
	),
	'option_server' => array(
		'type' => 'text',
		'length' => 255,
		'notnull' => false
	),
	'option_user' => array(
		'type' => 'text',
		'length' => 255,
		'notnull' => false
	),
		'option_pw' => array(
		'type' => 'text',
		'length' => 255,
		'notnull' => false
	),
		'option_db' => array(
		'type' => 'text',
		'length' => 255,
		'notnull' => false
	),
	'option_sql' => array(
		'type' => 'text',
		'length' => 4000,
		'notnull' => false
	)
);

$ilDB->createTable("rep_robj_xdbs_data", $fields);
$ilDB->addPrimaryKey("rep_robj_xdbs_data", array("id"));
?>
<#2>
<?php
?>
