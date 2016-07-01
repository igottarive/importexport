<?php
require_once 'includes/db.php';
require_once 'classes/Duplicator.class.php';

//Try to import to database if we have what we need
if(isset($_FILES['csv']) && $_FILES['csv']['error'] == 0) {
    $duper = new Duplicator($db);
    $duper->importData($_FILES['csv']['tmp_name'], $_POST['tableName']);
}

//Get the HTML to the user
require_once 'templates/import.php';
?>