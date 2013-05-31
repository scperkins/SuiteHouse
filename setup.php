<?php
require_once('config.php');
$connection = mysql_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS);
if(!$connection){
	//This is a bad error. DIE!
	die('Could not connect to mySql at all, please verify your installation and config.php');
}

if($_GET['create']=='true'){
	//This flag will inform the script to create the databases
	$create = true;
}
define('PAGE_TITLE','Initialization Script');
include('header.php');
?>

		<h1>Suite House Setup</h1>

		<p>
			Informational Text goes here
		</p>

		<div>
			<!--Main Button to Click-->
			<a href="?create=true" alt="Setup Application">Run Setup</a>
		</div>

		<hr>
		<!-- List of Configurations and their status -->
		<dl>
			<!--Primary Database, used for logging into the application -->
			<dt>Suite House Primary Database</dt>
			<dd>Status: 
				<?php
					if(!$create){
						echo mysql_select_db(DATABASE_NAME) ? "Exists" : "Does not Exist";		
					}else{
						//Create primary database
						if(mysql_select_db(DATABASE_NAME)){
							echo "Database Already Exists";
						}else{
							$created = mysql_query("CREATE DATABASE " . DATABASE_NAME);
							echo $created ? "Database Created Successfully" : "Database creation Failed";
						}
						
					}
					
				?>
			</dd>

			<!--Suite Money database, used for logging into the Finance Application -->
			<dt>Suite Money Database</dt>
			<dd>Status:
				<?php
					echo mysql_select_db(DB_SUITE_MONEY_NAME) ? "Exists" : "Does not Exist";	
				?>
			</dd>

			<!--MyStuff Manager database, used for keeping inventory of your items -->
			<dt>MyStuff Manager Database</dt>
			<dd>
				<?php
					echo mysql_select_db(DB_MYSTUFF_MANAGER_NAME) ? "Exists" : "Does not Exist";	
				?>
			</dd>

		</dl>
	</body>

</html>