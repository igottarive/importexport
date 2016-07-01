<?php

/**
 * The user class used for logging in and storing user information
 * @author Justin Pruskowski <racecorp5@gmail.com>
 * @version 0.1
 */
class Duplicator {

    /**
     *  Database Connection
     *  @var PDO connection
     */
    private $db = null;

    /**
     * File that has been uploaded
     * @var string
     */
    private $uploadFile = null;

    /**
     * File for user to download
     * @var array
     */
    public $downloadFiles = array();

    /**
     * File for user to download
     * @var string
     */
    public $zipFile = null;

    /**
     *  The name of the table to copy
     *  @var string
     */
    public $tableName = null;

    /**
     *  The name of the new table
     *  @var string
     */
    public $newTableName = null;

    /**
     *  An array of the tables in the database
     *  @var array
     */
    public $tables = array();

    /**
     *  The data from a specific table
     *  @var array
     */
    public $data = array();

    /**
     *  Messages to display to user
     *  @var array
     */
    private $msg = array();

    /**
     *  Errors to log
     *  @var array
     */
    private $error = array();


    /** 
     *  Initial object values
     *  Will setup object with values of user db
     *  @param PDO $db PDO Connection
     */
    function __construct($db) {
        if(!$db) return NULL;
        $this->db = $db;
        return $this;
    }

    /**
     * Make sure the upload file is valid
     * Then create the table and import the data
     * @note tableName needs to be set
     * @param string $fileName name of file
     * @param string $tableName name of table
     */
    function importData($fileName, $tableName) {
        if(!$fileName && !$tableName) return;
        $this->uploadFile = $fileName;
        if (($handle = fopen($this->uploadFile, "r")) !== FALSE) {
            $row = 0;
            $columns = '';
            while (($data = fgetcsv($handle)) !== FALSE) {
                //Create table with the field names in row 1
                if($row == 0) {
                    //Get headers for inserting
                    $columns = implode(', ',array_values($data));

                    //Cleanup user input
                    $this->newTableName = filter_input(INPUT_POST, 'tableName', FILTER_SANITIZE_STRING);
                    $this->db->quote($this->newTableName);
                    $this->newTableName = $tableName;

                    if(!$this->createTable($this->newTableName, $data)) return;
                } else {
                    $escaped_values = array_map('filter_var', array_values($data));
                    $values  = implode('", "', $escaped_values);
                    $q = 'INSERT INTO '. $this->newTableName .'(' . $columns . ') 
                        VALUES ( "' . $values . '");';
                    $statement = $this->db->prepare($q);
                    if($statement->execute()) {
                        $this->msg[] = 'Row ' . $row . ' inserted.';
                    }
                    $this->error[] = 'Row ' . $row . ' not inserted.';
                }
                $row++;
            }
            fclose($handle);
            $this->msg[] = 'Inserted ' . ($row - 1) . ' rows.';
        }
    }

    /**
     * Create a zip file for exporting the table(s)
     * @note sets zipFile to be the zip that was created
     * @param string $type Type of file (CSV only for now)
     */
    function putFile($type = 'csv') {
        $name = 'dump';
        if( $type == 'csv') {
            //Each table in $data
            foreach($this->data AS $name => $table) {
                $this->downloadFiles[$name] = tempnam('/tmp', 'mjfreewayExport'.$name);
                $handle = fopen($this->downloadFiles[$name], "w");

                //Write Headers (object property names of first row)
                fputcsv($handle, array_keys($table[0]));

                //Write Data (object values for all properties)
                foreach($table AS $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            }
        } else {
            $this->error[] = 'Only CSV is supported ATM.';
        }

        //Build a zipfile with all of the tables in it
        $zip = new ZipArchive();
        $filename = tempnam('/tmp', 'mjfreewayExport'.$name) . '.zip';
        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            $this->error[] = 'Cannot open ' . $filename . '.';
            exit();
        }

        //Add each of the table files
        foreach($this->downloadFiles AS $file) {
            $zip->addFile($file);
        }

        $zip->close();
        $this->zipFile = $filename;
    }

    /**
     * Set this->tables to the listing of all tables
     * in $this->db
     */
    function showTables() {
        $q = 'SHOW TABLES;';
        $this->tables = array();
        $results = $this->db->query($q, PDO::FETCH_NUM);
        if(!$results) {
            $this->error[] = 'There was a problem getting the tables.';
            return;
        }
        foreach ($results AS $row) {
            $this->tables[] = $row[0];
        }
    }

    /**
     * Get all of the data in a single table
     *  @param $tableName
     */
    function getTable($tableName = null) {
        //Might need better sanitization
        $tableName = filter_var($tableName, FILTER_SANITIZE_STRING);

        $q = 'SELECT * FROM ' . $tableName . ';';
        $results = $this->db->query($q, PDO::FETCH_ASSOC);
        if(!$results) {
            $this->error[] = 'There was a problem getting the data for table ' . $tableName . '.';
            return;
        }
        foreach ($results AS $row) {
            $this->data[$tableName][] = $row;
        }
    }

    /**
     * Write the table to the database with these steps
     *  Make sure newTableName doesn't exist
     *  Create table with name $newTableName
     * @return bool
     */
    function createTable($newTableName, $fields) {
        $fieldType = 'varchar(500) DEFAULT NULL'; //Use a varchar field type in the table
        $q = 'CREATE TABLE ' . $newTableName .' (' . implode(' ' . $fieldType .' , ', $fields);
        $q .= ' ' . $fieldType . ');';
        $statement = $this->db->prepare($q);

        if($statement->execute()) {
            $this->msg[] = 'Table ' . $newTableName . ' created.';
            return TRUE;
        }
        $this->error[] = 'Table ' . $newTableName . ' not created.';
        return FALSE;
    }

    /* Extras */

    /**
     *  Get info messages
     *  @returns array
     */
    public function get_message() {
        return $this->msg;
    }

    /**
     *  Get errors
     *  @returns array
     */
    public function get_error() {
        return $this->error;
    }
}
?>