<?php
/**
 * This is the html for the importing form
 * User sets a Table name and uploads a csv file
 * This will create a new table with the table name
 * and import the data of a valid csv file
 * @file import.php
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>MJFreeway Importer</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/global.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <!-- container -->
    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <h1>MJFreeway</h1>
            <p>This is the importer. Here you can import a table to your database. Simply fill out the table name you would like, then upload a valid CSV(Comma Separated Values) file to import that into the specified tablename.</p>
        </div>

        <div class="page-header">
            <h1><a href="index.html">Home </a>-> Importer</h1>
        </div>

        <!-- Display any Errors -->
        <?php if(isset($duper) && count($duper->get_error()) > 0) : ?>
            <div class="alert alert-danger">
                Error:
                <?php foreach($duper->get_error() AS $err) : ?>
                    <span><?php print $err; ?></span><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- Display any Messages -->
        <?php if(isset($duper) && count($duper->get_message()) > 0) : ?>
            <div class="alert alert-info">
                Info:
                <?php foreach($duper->get_message() AS $msg) : ?>
                <span><?php print $msg; ?></span><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div>
            <!-- The form to import a table -->
            <form method="post" enctype="multipart/form-data">
                <p>
                    <label for="tableName">Table Name:</label>
                    <input type="text" name="tableName" id="tableName" />
                </p>
                <p>
                    <label for="file">Upload a CSV:</label>
                    <input type="file" name="csv" id="csv">
                </p>
                <p>
                    <input type="submit" value="Import" class="btn btn-lg btn-primary"/>
                </p>
            </form>
        </div>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/js/global.js"></script>
</body>
</html>