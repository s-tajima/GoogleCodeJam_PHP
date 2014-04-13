<?php
define("FILE_NAME", "a-test.in");
//define("FILE_NAME", "A-small-attempt0.in");
//define("FILE_NAME", "A-large.in");
//define("FILE_NAME", "A-large-practice.in");

$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){
	$output .= "Case #{$key}:\n";
	$results = $case['result'];
	$team_num = $case['team_num'];

	foreach($results as $key => $val){
		preg_match_all("/[\.10]{1}/", $val, $match);
		$res[$key]['result'] = $match[0];

		$val = preg_replace("/\./", "", $val);
		preg_match_all("/1/", $val, $m1);
		preg_match_all("/0/", $val, $m0);
		$sum = count($m1[0]) + count($m0[0]);
		$res[$key]['wp'] = count($m1[0]) / $sum;
	}

	foreach($res as $key => $val){
		$tmp = 0;
		$num = 0;
		foreach($val['result'] as $k => $v){
			if($v == ".") continue;
			$tmp += $res[$k+1]['wp'];
			$num++;
		}
		echo "$v:$tmp:$num:" .$k+1 . "\n";
		$res[$key]['owp'] = $tmp/$num;
	}

	foreach($res as $key => $val){
		$tmp = 0;
		$num = 0;
		foreach($val['result'] as $k => $v){
			if($v == ".") continue;
			$tmp += $res[$k+1]['owp'];
			$num++;
		}
		$res[$key]['oowp'] = $tmp/$num;
	}
	
	foreach($res as $key => $val){
		$rpi = ( $val['wp'] * 0.25 ) + ( $val['owp'] * 0.5 ) + ( $val['oowp'] * 0.25 );
		$output .= $rpi . "\n";
		
	}

}
echo $output;

function read_input($file_name){
	$fp = fopen($file_name, "r");
	$case_num = fgets($fp);
	for($i = 1; $i <= $case_num; $i++){
		$team_num = str_replace("\n", "", fgets($fp));
		$cases[$i]['team_num'] = $team_num;
		for($j = 1; $j <= $team_num; $j++){
			$cases[$i]['result'][$j] = str_replace("\n", "", fgets($fp));
		}
	}
	fclose($fp);
	return $cases;
}

function split_result($result){
	preg_replace("/[01.]{1}/", $spell, $matches);
	preg_match_all("/[01.]{1}/", $spell, $matches);

	$res['n'] = array_shift($case);
	$res['Pd']  = array_shift($case);
	$res['Pg'] = array_shift($case);
	return $res;
}

