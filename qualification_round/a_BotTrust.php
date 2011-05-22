<?php
define("FILE_NAME", "A-large.in");
$cases = read_input(FILE_NAME);

$output = "";
foreach($cases as $key => $case){
	list($orders, $order_num)= split_case($case);
	$O = array('position' => 1, 'order' => 0);
	$B = array('position' => 1, 'order' => 0);
	$time   = 0;
	$turn   = 1;

	for($turn = 1; $turn <= $order_num;){
		$O['dist'] = $orders['O'][$O['order']]['dist'];
		$B['dist'] = $orders['B'][$B['order']]['dist'];
		
		for($switch = false; $switch == false; $time++){
			$move = move($O);
			if(!$move && $orders['O'][$O['order']]['turn'] == $turn){
				$O['order']++;
				$switch = TRUE;
				$turn++;
			}
			if($move){
				$O = $move;
			}	

			$move = move($B);
			if(!$move && !$switch && $orders['B'][$B['order']]['turn'] == $turn){
				$B['order']++;
				$switch = TRUE;
				$turn++;
			}
			if($move){
				$B = $move;
			}	
		}
	}
	$output .= "Case #{$key}: {$time}\n";
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
	$order_num = array_shift($case);
	for($i = 1; $i <= $order_num; $i++){
		$color  = array_shift($case);
		$button = array_shift($case);
		$orders[$color][] =array('turn' => $i, 'dist' => $button);
	}
	return array($orders, $order_num);
}

function move($chara){
	if($chara['dist'] > $chara['position']){
		$chara['position']++;
		return $chara;
	}
	
	if($chara['dist'] < $chara['position']){
		$chara['position']--;
		return $chara;
	}
	return false;
}
