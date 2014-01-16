<?php
include 'sudokuObject.php';

function displayBoard($jsonBoxValues){
	$sO = new sudokuObject;

	$jsonVar = json_decode($jsonBoxValues, true);
	foreach($jsonVar as $i => $j){
		foreach ($j as $k){
			$m = preg_replace("/'/",'',$k);
			$n = preg_replace("/^(.)/",'\'\1',$m);
			$o = preg_replace("/:/",'\':\'',$n);
			$p = preg_replace("/(.)$/",'\1\'',$o);

			$val = preg_replace("/^.*:\'(\d)\'.*$/", '\1',$p);
			$j = preg_replace("/.*(\d)\d\':.*/", '\1', $p);
			$i = preg_replace("/.*\d(\d)\':.*/", '\1', $p);

			$val *= (-1);
			$sO->loadBoard($val, $i, $j);
			}
		}
	$sO->displayBoard();
	}

function displayBoard1($jsonBoxValues){
	$sO = new sudokuObject;

	$jsonVar = json_decode($jsonBoxValues, true);
	$a = 0;
	$b = 0;
	while ($a < 9){
		while($b < 9){
			$val = $jsonVar[$a][$b];
			$sO->loadBoard($val, $a, $b);
			$b++;
			}
		$a++;
		$b = 0;
		}
	$sO->fillBoardR(0,0);
	$sO->displayBoard();
	}
	
if(isset($_GET['val'])){
	$jsonBoxValues = $_GET['val'];
	displayBoard($jsonBoxValues);
}else if(isset($_GET['val1'])){
	$jsonBoxValues = $_GET['val1'];
	displayBoard1($jsonBoxValues);
}


?>