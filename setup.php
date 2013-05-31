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
			<?php
				if(!$create){
					//Check for database existing
					if(mysql_select_db(DATABASE_NAME)){
						//Check out the existence of each table we need

						//Users table
						echo "<dt>Members Table</dt>";
						echo "<dd>";
						echo (false !== mysql_query("SELECT 1 from `members`")) ? "Existing" : "Does not Exist, please run the creation script";
						echo "</dd>";

						//Houses table
						echo "<dt>Houses Table</dt>";
						echo "<dd>";
						echo (false !== mysql_query("SELECT 1 from `houses`")) ? "Existing" : "Does not Exist, please run the creation script";
						echo "</dd>";

						//Tasks tables
						echo "<dt>Tasks Table</dt>";
						echo "<dd>";
						echo (false !== mysql_query("SELECT 1 from `tasks`")) ? "Existing" : "Does not Exist, please run the creation script";
						echo "</dd>";



					}else{
						//Can't run config scripts if the database doesn't exist
						?>
							<dt>Table Status failed</dt>
							<dd>No database exists for tables to be inquired on</dd>
						<?php
					}
				}else{
					//Create the tables if they don't exist
					if(!$new){ 
						//Create tables with IF NOT EXISTS flag
						echo "<dt>Members Table</dt>";
						echo "<dd>";
						if(false === mysql_query("SELECT 1 from `members`")){
							$members = "CREATE TABLE IF NOT EXISTS members (
								pkId INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
								fkHouseId INT(10) NULL,
								membername VARCHAR(50),
								salt CHAR(64),
								encryptedPass CHAR(64),
							);";
							echo mysql_query($members) ? "Table Created" : "Table not created";
						}else{
							echo "Table already exists";
						}
						echo "</dd>";


					}else{
						//Drop the old tables and create the new ones

						echo "<dt>Members Table</dt>";
						echo "<dd>";
						mysql_query("DROP TABLE `members`;");
						$members = "CREATE TABLE `members` (
								pkId INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
								fkHouseId INT(10) NULL,
								membername VARCHAR(50),
								salt CHAR(64),
								encryptedPass CHAR(64),
							);";
						echo mysql_query($members) ? "Table Created" : "Table not created";
						echo "</dd>";
					}
				}
			?>

			
		</dl>
<?php
include(BASE_URL . 'footer.php');
?>