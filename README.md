-- Details about the project --
* Big security implications obviously. This needs to be behind a session or a login system to make sure the user has the appropriate permissions
* For now we will assume the fields in the db are varchar(500) DEFAULT NULL on creation and that will cover our need

-- Requirements PHP Engineer Assessment --

MJ Freeway is in need of an application that will allow a user to back up specific tables in a database to a file and restore them to the same database with a different table name. The core of this application should be written in PHP. You can use other items such as jquery, bootstrap, etc. for the front end.

Minimum Requirements:

Downloading the table:
The application should begin by analyzing the database that is given to you and give the user a list of tables that exist. The user can select table that are in the list and run the process of backing up the table. When backing up the table, it will return the table to the user in a csv format with the first row being the name of the fields in the table.

Uploading the table:
The application should begin by allowing the user to name the table and selecting a csv file to upload. The application should then take the first row of data and use those as the table names and create the table. It would then take the rest of the rows and insert them into the table.

Notes:
This project has room for creativity and you can add as much creativity as you would like such as error checking, error handling, data type mapping, make it API based, etc.
