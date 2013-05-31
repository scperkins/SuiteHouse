<?php

require_once('config.php');

//Check if our database is configured
$configured = false;

$connection = mysql_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS);

if($connection){
	//This is a good start, now does our database exist?
	if(mysql_select_db(DATABASE_NAME)){
		//We've connected to the database and we'll assume that the database is therefore configured
		$configured = true;
	}
	//Close connection unless I actually need something from the database, in which case remove this
	mysql_close($connection);
}

if(!$configured){ //Send them to the setup page
	header('location:setup.php?from=index');
}

//Otherwise it's time to display the landlord start page
include('header.php');
?>