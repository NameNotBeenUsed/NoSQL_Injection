<?php
$stime = microtime(true);
$manager = new MongoDB\Driver\Manager();

$uname = $_GET['username'];
$pwd = $_GET['password'];

$cmd = new MongoDB\Driver\Command([
'$eval'=> "db.users.distinct('uname', {uname: '".$uname."', pwd: '".$pwd."'})"
]);
echo "db.users.distinct('uname', {uname: '".$uname."', pwd: '".$pwd."'})";
$result = $manager->executeCommand('test', $cmd)->toArray();
$result =((array)$result[0])['retval'];
$count = count($result);

$doc_failed = new DOMDocument();
$doc_failed->loadHTMLFile("failed.html");
$doc_succeed = new DOMDocument();
$doc_succeed->loadHTMLFile("succeed.html");

if ($count>0) {
    foreach ($result as $user) {
        echo $doc_succeed->saveHTML();
        $user=(array)$user;
        echo 'username: '.$user['username']."\n";
        echo 'password: '.$user['password']."\n";
    }
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
}else echo $total.'seconds';