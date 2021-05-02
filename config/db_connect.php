<?php 

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// check connection
if(!$conn){
	echo 'Connection error: '. mysqli_connect_error();
}

/*
	//For PHP MyAdmin
	$servername = "localhost";
	$username = "ken";
	$password = "test1234";
	$dataBase =	"ninja_pizza";
	
	// connect to the database - procedural MySQLI
	$conn = mysqli_connect($servername, $username, $password, $dataBase);

	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

*/
?>