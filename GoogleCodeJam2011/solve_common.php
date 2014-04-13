<?php
//define("FILE_NAME", "a-test.in");
//define("FILE_NAME", "A-small-attempt0.in");
//define("FILE_NAME", "A-large.in");
//define("FILE_NAME", "A-large-practice.in");

$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){

}
echo $output;

function read_input($file_name){
	$fp = fopen($file_name, "r");
	$case_num = fgets($fp);
	for($i = 1; $i <= $case_num; $i++){
		$cases[$i] = str_replace("\n", "", fgets($fp));

	}
	fclose($fp);
	return $cases;
}

function split_case($case){
	$case = preg_split("/ /", $case);
	$res['n'] = array_shift($case);
	$res['Pd']  = array_shift($case);
	$res['Pg'] = array_shift($case);
	return $res;
}

