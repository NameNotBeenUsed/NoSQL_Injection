<?php

	$stime = microtime(true);
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$query_function = "function() {
		if(this.username == '$username' && this.password == '$password') 
		return {'username': this.username, 'password': this.password}
	}";

	//echo $query_function;

	$query = new MongoDB\Driver\Query(array('$where' => $query_function));

	$result = $manager->executeQuery('test.users', $query)->toArray();

	$count = count($result);

	$doc_failed = new DOMDocument();
	$doc_failed->loadHTMLFile("failed.html");
	$doc_succeed = new DOMDocument();
	$doc_succeed->loadHTMLFile("succeed.html");

	if($count > 0){
		echo $doc_succeed->saveHTML();
	}
	else{
		echo $doc_failed->saveHTML();
	}

	$etime = microtime(true);
	$total = $etime - $stime;
	$str_total = var_export($total, TRUE);
	if(substr_count($str_total, "E")){
		$float_total = floatval(substr($str_total, 5));
		$total = $float_total/100000;
		echo $total.'seconds';
	} else echo $total.'seconds';