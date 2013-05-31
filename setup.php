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
	//Recreate the whole database, dropping old tables
	if($_GET['new']=='true'){
		$new = true;
	}
}

define('PAGE_TITLE','Initialization Script');
include(BASE_URL . 'header.php');
?>

		<h1>Suite House Setup</h1>

		<p>
			Welcome to Suite House's Quick Installation Script! The status of the current install is listed below, you can use the links below to run the setup script to create the database and table schemas. You can also recreate the installation from scratch. If you do so, you will lose all data stored currently.
		</p>

		<div>
			<!--Main Button to Click-->
			<a href="index.php" alt="Return home">Return to the front page</a>
			<a href="?" alt="Status of the application">Status</a>
			<a href="?create=true" alt="Setup Application">Run Setup</a>
			<a href="?create=true&amp;new=true" onclick="return confirm('Are you sure you want to recreate Suite House? This will remove all current data');" alt="Fresh Installation">Recreate All (cannot be undone)</a>
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
							if($new){
								//Drop database and recreate it
								mysql_query("DROP DATABASE IF EXISTS " .DATABASE_NAME);
								echo mysql_query("CREATE DATABASE " . DATABASE_NAME) ? "Database Created Successfully" : "Database creation Failed";	
							}else{
								echo "Database Already Exists";	
							}
						}else{
							$created = mysql_query("CREATE DATABASE " . DATABASE_NAME);
							echo $created ? "Database Created Successfully" : "Database creation Failed";
						}
						
					}
					
				?>
			</dd>

			<!-- Run configuration of tables here -->

			
		</dl>
<?php
include(BASE_URL . 'footer.php');
?>