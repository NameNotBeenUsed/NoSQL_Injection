<?php
	include_once 'parseTree.php';
	use control\ParseTree;

	$stime = microtime(true);
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	$data = array(
		'username' => $_REQUEST['username'],
		'password' => $_REQUEST['password']
	);

	$string = json_encode($data);
	//echo $string;

	$doc_failed = new DOMDocument();
	$doc_failed->loadHTMLFile("failed.html");
	$doc_succeed = new DOMDocument();
	$doc_succeed->loadHTMLFile("succeed.html");
	$doc_attacked = new DOMDocument();
	$doc_attacked->loadHTMLFile("attacked.html");

	$parseTree = new ParseTree();
	if($parseTree->parseTree($string)){
		echo $doc_attacked->saveHTML();
	}
	else{
		$query = new MongoDB\Driver\Query($data);
		$result = $manager->executeQuery('test.users', $query)->toArray();
		$count = count($result);
		if($count > 0) {
			echo $doc_succeed->saveHTML();
			foreach ($result as $user) {
				echo 'username:'.$user->username."</br>";
				echo 'password:'.$user->password."</br>";
			}
		}
		else{
			echo $doc_failed->saveHTML();
		}
	}

	$etime = microtime(true);
	$total = $etime - $stime;
	$str_total = var_export($total, TRUE);
	if(substr_count($str_total, "E")){
		$float_total = floatval(substr($str_total, 5));
		$total = $float_total/100000;
		echo $total.'seconds';
	} else echo $total.'seconds';