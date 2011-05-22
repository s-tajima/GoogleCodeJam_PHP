<?php
define("FILE_NAME", "C-large.in");

$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){
	$case['piles'] = split_piles($case['piles']);

	$xor_sum = 0;
	$and_sum = 0;
	foreach($case['piles'] as $k => $v){
		$xor_sum = $xor_sum ^ $v; 
		$and_sum = $and_sum + $v; 
	}

	if($xor_sum){
		$output .= "Case #{$key}: NO\n";
		continue;
	}

	$answer  = $and_sum - $case['piles'][0];
	$output .= "Case #{$key}: {$answer}\n";
}

echo $output;

function read_input($file_name){
	$fp = fopen($file_name, "r");
	$case_num = fgets($fp);
	for($i = 1; $i <= $case_num; $i++){
		$cases[$i]['pile_num'] = str_replace("\n", "", fgets($fp));
		$cases[$i]['piles']    = str_replace("\n", "", fgets($fp));

	}
	fclose($fp);
	return $cases;
}

function split_piles($piles){
	$piles = preg_split("/ /", $piles);
	sort($piles);
	return $piles;
}
