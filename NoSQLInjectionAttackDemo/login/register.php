<?php
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
	echo "Connect to database successfully.";
	echo "<br/>";

	$postedusername = $_REQUEST['username'];
	$postedpassword = $_REQUEST['password'];

	$document = array(
		"username" => $postedusername,
		"password" => $postedpassword
	);

	$bulk = new MongoDB\Driver\BulkWrite;
	$_id = $bulk->insert($document);

	//echo var_dump($_id);

	$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
	$result = $manager->executeBulkWrite('test.users', $bulk, $writeConcern);
	echo "Document inserted successfully.";