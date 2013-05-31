<?php
require_once('config.php');
$connection = mysql_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS);
if(!$connection){
	//This is a bad error. DIE!
	die('Could not connect to mySql at all, please verify your installation and config.php');
}

if($_GET['from']=='index'){
	//We have a connection, do let's make the database
	mysql_query(query);
}
define('PAGE_TITLE','Initialization Script');
include('header.php');
?>

		<h1>Setup</h1>
	</body>

</html>