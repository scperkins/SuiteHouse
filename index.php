<?php

require_once(BASE_URL . 'config.php');

//Check if our database is configured
$configured = false;

$connection = mysql_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS);

if($connection){
	//This is a good start, now does our database exist?
	if(mysql_select_db(DATABASE_NAME)){
		//We've connected to the database and we'll assume that the database is correctly configured as well
		$configured = true;
	}
	//Close connection unless I actually need something from the database, in which case remove this
	mysql_close($connection);
}

if(!$configured){ //Send them to the setup page
	header('location:status.php?from=index');
}

//Otherwise it's time to display the landlord start page
include(BASE_URL . 'header.php');
?>

<div class="banner">
	<span class="banner">P&amp;E</span>
	<h1 class="banner">Suite House</h1>
</div>

<div>
	<ul class="appList">
		<li>
			<h2>Suite Money</h2>
			<p>
				Descriptive Text about the app and what it does
			</p>
			<a href="" alt="Use Suite Money Application" class="appButton">Suite Money</a>
		</li>

		<li>
			<h2>MyStuff Manager</h2>
			<p>
				Descriptive Text about the app and what it does
			</p>
			<a href="MyStuffManager/" alt="Use MyStuff Manager Application" class="appButton">MyStuff Manager</a>
		</li>
	</ul>

</div>



<?php
include(BASE_URL . 'footer.php');
?>


