<?php
define("FILE_NAME", "B-small-attempt6.in");
$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){
	$rule = split_case($case);
	$spell = $rule['invoke']['spell'];

	$cmb_patterns = $rule['cmb_patterns'];
	$cmb_replaces = $rule['cmb_replaces'];

	$opp_patterns = $rule['opp_patterns'];
	$opp_replaces = $rule['opp_replaces'];

	foreach($opp_patterns as $ke => $val){
		$matches = array();
		preg_match_all($val, $spell, $matches);
		foreach($matches[0] as $k => $v){
			$m = $v;
			$v = preg_replace($cmb_patterns, $cmb_replaces, $v);
			if($m !== $v){
				$spell = preg_replace("/$m/", $v ,$spell);
			}else{
				$spell = preg_replace("/$m/", "" ,$spell);
			}
		}
	}

	$spell = preg_replace($cmb_patterns, $cmb_replaces, $spell);
	$spell = preg_replace($opp_patterns, $opp_replaces, $spell);

	$spell = split_spell($spell);
	$output .= "Case #{$key}: [{$spell}]\n";

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

	$rule['cmb_patterns'] = array();
	$rule['cmb_replaces'] = array();
	$rule['opp_patterns'] = array();
	$rule['opp_replaces'] = array();
	$rule['invoke'] = array();
	$exceptions = array();

	$combine_num = array_shift($case);
	for($i = 1; $i <= $combine_num; $i++){
		$combine = array_shift($case); 
		preg_match_all("/[A-Z]{1}/", $combine, $matches);

		$rule['cmb_patterns'][] = "/{$matches[0][0]}{$matches[0][1]}|{$matches[0][1]}{$matches[0][0]}/";
		$rule['cmb_replaces'][] = "{$matches[0][2]}";
		$exceptions[] = $matches[0][2];
	}

	$exceptions = implode("", $exceptions);
	$oppose_num = array_shift($case);
	for($i = 1; $i <= $oppose_num; $i++){
		$combine = array_shift($case); 
		preg_match_all("/[A-Z]{1}/", $combine, $matches);

		$rule['opp_patterns'][] = "/{$matches[0][0]}[^{$matches[0][0]}{$exceptions}]*?{$matches[0][1]}|{$matches[0][1]}[^{$matches[0][1]}{$exceptions}]*?{$matches[0][0]}/";
		$rule['opp_replaces'][] = "";
	}

	
	$rule['invoke']['num'] = array_shift($case);
	$rule['invoke']['spell'] = array_shift($case);

	return $rule;
}

function split_spell($spell){
	preg_match_all("/[A-Z]{1}/", $spell, $matches);
	$spell = $matches[0];
	$spell = implode(", ", $spell);
	return $spell;
}

