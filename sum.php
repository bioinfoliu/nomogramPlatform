<?php

$f = fopen('/home/sylee/IPMN_log/IPMN_ip_201201.txt', 'r');
$ip = [];
while ($r = fgets($f)) $ip[] = trim($r);

$mysqli = new mysqli('localhost', 'root', 'bibs@)!$', 'bibsv2');

$latlon = "latlon.csv";
$f = fopen($latlon, "r");
$h = fgetcsv($f);
$ll = [];
while ($r = fgetcsv($f)) {
	$ll[$r[1]] = $r;
}
fclose($f);

$uu = array();
$dd = array();
foreach ($ip as $v) {
	if (isset($dd[$v]))
		$rr = $dd[$v];
	else {
		$q = "SELECT country FROM `ip2nation` WHERE ip < INET_ATON('".$v."') ORDER BY ip DESC LIMIT 1";
		//echo $q;
		$rr = $mysqli->query($q)->fetch_row()[0];
		$dd[$v] = $rr;
	}
	if (!isset($uu[$rr])) $uu[$rr] = 0;
	$uu[$rr]++;
}
echo "Lat	Lon	Title	Value\n";
foreach ($uu as $k=>$v) {
	$lalo = $ll[strtoupper($k)];
	echo $lalo[4]."\t".$lalo[5]."\t".$lalo[0]."\t$v\n";
}

