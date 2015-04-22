<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|
*/

//$dbconfig['mainuser']['hostname'] = '127.0.0.1';
//$dbconfig['mainuser']['port'] = '3306';
//$dbconfig['mainuser']['username'] = 'aimobile';
//$dbconfig['mainuser']['password'] = 'mobilecom_2014_!@#';
//$dbconfig['mainuser']['database'] = 'mobile_com';
//$dbconfig['mainuser']['dbdriver'] = 'mysql';
//$dbconfig['mainuser']['pconnect'] = true;
//$dbconfig['mainuser']['db_debug'] = FALSE;
//$dbconfig['mainuser']['cache_on'] = FALSE;
//$dbconfig['mainuser']['char_set'] = 'utf8';
//$dbconfig['mainuser']['dbcollat'] = 'utf8_general_ci';
/* End of file database.php */

$dbconfig['mainuser']['hostname'] = '10.161.156.118';
$dbconfig['mainuser']['port'] = '3306';
$dbconfig['mainuser']['username'] = 'webtronics';
$dbconfig['mainuser']['password'] = 'uoshon_2014B2_!@#';
$dbconfig['mainuser']['database'] = 'mobile_com';
$dbconfig['mainuser']['dbdriver'] = 'mysql';
$dbconfig['mainuser']['pconnect'] = FALSE;
$dbconfig['mainuser']['db_debug'] = FALSE;
$dbconfig['mainuser']['cache_on'] = FALSE;
$dbconfig['mainuser']['char_set'] = 'utf8';
$dbconfig['mainuser']['dbcollat'] = 'utf8_general_ci';


$dbconfig['sedserver']['hostname'] = '10.168.24.32';
$dbconfig['sedserver']['port'] = '3306';
$dbconfig['sedserver']['username'] = 'webtronics';
$dbconfig['sedserver']['password'] = 'uoshon_2014B2_!@#';
$dbconfig['sedserver']['database'] = 'mobile_com';
$dbconfig['sedserver']['dbdriver'] = 'mysql';
$dbconfig['sedserver']['pconnect'] = FALSE;
$dbconfig['sedserver']['db_debug'] = FALSE;
$dbconfig['sedserver']['cache_on'] = FALSE;
$dbconfig['sedserver']['char_set'] = 'utf8';
$dbconfig['sedserver']['dbcollat'] = 'utf8_general_ci';