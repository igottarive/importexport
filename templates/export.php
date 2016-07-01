<?php
/**
 * This is the html for the exporting form
 * User selects the table names that they wish to export
 * This will create a csv of the table(s)
 * and zip them all together and return it to the user
 * @file export.php
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>MJFreeway Exporter</title>

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
<body role="document">
    <!-- container -->
    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <h1>MJFreeway</h1>
            <p>This is the exporter. Here you can export one or many tables from your database. Simply select the tables you wish to export then click the export button.</p>
        </div>

        <div class="page-header">
            <h1><a href="index.html">Home </a>-> Exporter</h1>
        </div>

        <!-- If the zipfile is present, display the link, if not, display the form to make one -->
        <?php if(isset($duper->zipFile)) : ?>
            <h1>
                <span class="label label-success">
                    Here's your zipped export:
                    <a href="<?php print $duper->zipFile;?>">Download</a>
                </span>
            </h1>
        <?php else : ?>
            <!-- The form to select the tables to export -->
            <form method="post">
                <p>Please select the tables that you would like to export (Use shift to select many):</p>
                <label for="tables"></label>
                <select class="export list-group" name="tables[]" id="tables" multiple="multiple" size="8">
                    <?php foreach($duper->tables AS $table) : ?>
                        <option class="list-group-item"><?php print $table; ?></option>
                    <?php endforeach; ?>
                </select>
                <p><input type="submit" value="Export" class="btn btn-lg btn-primary"/></p>
            </form>
        <?php endif; ?>
        
    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/js/global.js"></script>
</body>
</html>