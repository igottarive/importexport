<?php
require_once 'includes/db.php';
require_once 'classes/Duplicator.class.php';

$duper = new Duplicator($db);
$duper->showTables();

//If user selected tables, dump them to csv, zip it and return it to user
if(isset($_POST['tables'])) {
    foreach( $_POST['tables'] AS $table) {
        $duper->getTable($table);
    }
    $duper->putFile();
}

echo"<pre>";print_r($_SERVER);
//Get the HTML to the user
require_once 'templates/export.php';