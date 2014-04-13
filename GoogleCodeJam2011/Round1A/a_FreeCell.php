<?php
//define("FILE_NAME", "A-large.in");
//define("FILE_NAME", "A-small-attempt3.in");
//define("FILE_NAME", "a-test.in");
define("FILE_NAME", "A-large-practice.in");

$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){
	$res = split_case($case);
	$n = $res['n'];
	$Pd = $res['Pd'];
	$Pg = $res['Pg'];

	if(($Pd == 0 && $Pg == 0) || ($Pd == 100 && $Pg == 100)){
		$output .= "Case #{$key}: Possible\n";
		continue;
	}

	if(($Pd != 100 && $Pg == 100) || ($Pd != 0 && $Pg == 0)){
		$output .= "Case #{$key}: Broken\n";
		continue;
	}

	$gcd = gcd($Pd, 100);
	$mul = 100/$gcd;
	if($mul <= $n){
		$output .= "Case #{$key}: Possible\n";
		continue;	  
	}

	$output .= "Case #{$key}: Broken\n";
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

function gcd($m,$n) {
   if ($m == $n) {
      return $n;
   }
   if ($m < $n) { 
      $i = $m;
      $m = $n;
      $n = $i;
      $i = 0;
   }
   for (;;) {    
      if ($m % $n == 0) {return $n;}
      elseif ($m % $n < 0) {return 0;}
      elseif ($m % $n > 0) {
         $i = $m % $n;
         $m = $n;
         $n = $i;
      }
   }
}
