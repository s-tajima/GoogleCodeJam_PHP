<?php
//define("FILE_NAME", "a-test.in");
//define("FILE_NAME", "A-small-attempt2.in");
//define("FILE_NAME", "A-large.in");
define("FILE_NAME", "A-large-practice.in");

$cases = read_input(FILE_NAME);
$output = "";
foreach($cases as $key => $case){
	$output .= "Case #{$key}:\n";
	$impossible = false;
	foreach($case['pattern'] as $key => $val){
		$count = 0;
		foreach($val as $k => $v){
			if($v == "#"){
				$count++;
			}
		}
		if($count%2 != 0){
			$output .= "Impossible\n";
			continue 2;
		}	
	}

	for($i = 1; $i <= $case['column']; $i++){
		$count = 0;
		$tile = 0;
		for($j = 1; $j <= $case['row']; $j++){
			if($case['pattern'][$j][$i] == "#"){
				$case['pattern'][$j][$i] = "/";
				if($case['pattern'][$j+1][$i+1] == "#") $case['pattern'][$j+1][$i+1] = "/";
				if($case['pattern'][$j][$i+1] == "#") $case['pattern'][$j][$i+1] = '\\';
				if($case['pattern'][$j+1][$i] == "#") $case['pattern'][$j+1][$i] = '\\';
			}

			if($case['pattern'][$j][$i] == "/" || $case['pattern'][$j][$i] == '\\'){
				$count++;
			}
		}
		if($count%2 != 0){
			$output .= "Impossible\n";
			continue 2;
		}	


	}

	$output .= write_pattern($case['pattern']);

}
echo $output;

function read_input($file_name){
	$fp = fopen($file_name, "r");
	$case_num = fgets($fp);
	for($i = 1; $i <= $case_num; $i++){
		$tiles = str_replace("\n", "", fgets($fp));
		preg_match_all("/[0-9]+/", $tiles, $matches);
		$cases[$i]['row'] = $matches[0][0];
		$cases[$i]['column'] = $matches[0][1];
		for($j=1; $j <= $cases[$i]['row']; $j++){
			$pattern_row = str_replace("\n", "", fgets($fp));
			preg_match_all("/[\.#]/", $pattern_row, $ms);
			foreach($ms[0] as $k => $m){
				$cases[$i]['pattern'][$j][$k+1] = $m;
			}
		}
	}
	fclose($fp);
	return $cases;
}

function write_pattern($pattern){
	$output = "";
	foreach($pattern as $key => $val){
		foreach($val as $k => $v){
			$output .= $v;
		}
		$output .= "\n";
	}
	return $output;
}
