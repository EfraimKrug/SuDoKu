<?php
interface SudokuInterface
{
	public function getBoard();
	public function fillBoardR($ih, $jh, $directionh = "front");
	public function loadBoard($val, $i, $j);
	public function fillSquare($i, $j, $val = 1);
	public function unfillSquare($i, $j);
	public function getValue($i, $j);
	public function fillRow($j);
	public function findBoxStart($idx);
	public function findBoxEnd($idx);
	public function compareValues($val1, $val2);
	public function nextI($i, $j);
	public function nextJ($i, $j);
	public function prevI($i, $j);
	public function prevJ($i, $j);
	public function isBoardFilled($i, $j);
	public function testBox($val, $i, $j);
	public function testRow($val, $i, $jHold);
	public function testCol($val, $iHold, $j);
	public function testBoxRecursive($val, $iStart, $jStart, $i, $j, $iEnd, $jEnd);
	public function testAll($val, $i, $j);
}

class SudokuObject implements SudokuInterface
{
		var $board = array(
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0));

		var $title = "";
		
	 public function SudokuObject($title = "Sudoku by Efraim")
		{
			$this->title = $title;
		}

	//get/set functions
	public function getBoard(){
		return $this->board;
		}
		
	//print/output functions
	public function printBoardRecursive($i, $j){	
	if($j > 8){
		return;
		}
	if($i < 9){
		if($this->board[$i][$j] < 0){
			$x = 0 - $this->board[$i][$j];
			echo ("<b><font color=red>$x</font></b>&nbsp;&nbsp;");
			}
		else {
			echo ($this->board[$i][$j] . "&nbsp;&nbsp;");
			}
		$this->printBoardRecursive($i+1, $j);
		return;
		}
	echo "<br>";
	$this->printBoardRecursive(0, $j+1);
	return;
	}

	public function displayBoard(){
		echo "<div id='WholeBoard'>";
		$this->displayBoardRecursive(0,0);
		echo "<input type=button class='pushButton' value='get answers' onclick='getAnswers(\"" . 
			json_encode($this->getBoard()) . "\");'>";
		echo "</div>";
		}
		
	public function displayBoardRecursive($i, $j){	
	if($i == 0){
		if(($j > 0) && ($j < 9)){
			echo "</div>";
			}
		echo "<div class='BoardRow' id='BR" . $j . "'>";
		}
	if($j > 8){
		return;
		}
	if($i < 9){
		if($this->board[$i][$j] < 0){
			$x = 0 - $this->board[$i][$j];
			echo ("<div class='original'><div class=ib>$x</div></div>");
		} else {
			if($this->board[$i][$j] < 1){
				$x = "&nbsp;";
				}
			else {
				$x = $this->board[$i][$j];
				}
			echo ("<div class='board'><span class=ib>" . $x . "</span></div>");
			#echo ("<div class='board'>" . $this->board[$i][$j] . "</div>");
			}
		$this->displayBoardRecursive($i+1, $j);
		return;
		}
	#echo "</div>";
	$this->displayBoardRecursive(0, $j+1);
	return;
	}

	public function displayEmptyBoard(){
		echo "<div id='WholeBoard'>";
		$this->displayEmptyBoardRecursive(0,0);
		echo "</div>";
		}
		
	public function displayEmptyBoardRecursive($i, $j){	
	if($i == 0){
		if($j > 0){
			echo "</div>";
			}
		echo "<div class='iBoardRow'>";
		}
	if($j > 8){
		return;
		}
	if($i < 9){
			echo ("<div class='iboard'><input class='ib' id='b" . $j . $i . "'/></div>");
			$this->displayEmptyBoardRecursive($i+1, $j);
			return;
			}
	#echo "</div>";
	$this->displayEmptyBoardRecursive(0, $j+1);
	return;
	}
	
	//load board functions
	public function fillBoardR($ih, $jh, $directionh = "front"){
		$seconds = 180;
		set_time_limit($seconds);

		$i = 0; $j = 0;
		$direction = "front";
		while($j < 9){
			if($this->isBoardFilled(0, 0)){
			return true;
			}
			if($i > 8)$i=8;
			if($j > 8)$j=8;
			$val = $this->getValue($i, $j);
			if($direction == "front"){
				if($val == 0){
					$r = $this->fillSquare($i, $j);
					if($r > 0){
						$j = $this->nextJ($i, $j);
						$i = $this->nextI($i, $j);
						$direction = "front";
						continue;
					}
					$j = $this->prevJ($i, $j);
					$i = $this->prevI($i, $j);
					$direction = "back";
					continue;
				}
				$j = $this->nextJ($i, $j);
				$i = $this->nextI($i, $j);
				$direction = "front";
				continue;
			}
			else {
				if($val > 0){
					$val = $this->unfillSquare($i, $j);
					$r = $this->fillSquare($i, $j, $val+1); 
					if($r > 0){
						$j = $this->nextJ($i, $j);
						$i = $this->nextI($i, $j);
						$direction = "front";
						continue;
						}
					else {
						$j = $this->prevJ($i, $j);
						$i = $this->prevI($i, $j);
						$direction = "back";
						continue;
						}
					}
				else {
					$j = $this->prevJ($i, $j);
					$i = $this->prevI($i, $j);
					$direction = "back";
					continue;
					}
				}
			}
		return false;
		}
		

	public function loadBoard($val, $i, $j){
		$this->board[$i][$j] = $val;
	}
	

	# if i can not fill the square - return 0
	public function fillSquare($i, $j, $val = 1){
	while ($val < 10){
		if($this->testAll($val, $i, $j)){
			$this->loadBoard($val, $i, $j);
			return $val;
			}
		$val++;
		}
	return 0;
	}

# clear value out of the square
	public function unfillSquare($i, $j){
	$oldVal = $this->getValue($i, $j);
	$this->loadBoard(0, $i, $j);
	return $oldVal;
	}

	public function getValue($i, $j){
		return $this->board[$i][$j];
	}
	
# @param direction: "front" or "back"

	public function fillRow($j){
	$direction = "front";
	$i = 0;
	echo "in fillRow";

		while($i < 9){
			$val = $this->getValue($i, $j);
		
			if($val < 0){
				if($direction = "front"){
					$i++;
					}
				continue;
				}
		
			if($this->fillSquare($i, $j) > 0){
				$i++;
				$direction = "front";
				continue;
				}
			$i++;
			}
	}

	//utility functions
	public function findBoxStart($idx){
	if($idx < 3){
		return 0;
		}
	if($idx < 6){
		return 3;
		}
	return 6;
	}

	public function findBoxEnd($idx){
	if($idx < 3){
		return 2;
		}
	if($idx < 6){
		return 5;
		}
	return 8;
	}
	
	public function compareValues($val1, $val2){
	if($val1 == $val2){
		return true;
		}
	$negVal2 = 0 - $val2;
	if($val1 == $negVal2){
		return true;
		}
	return false;
	}


	public function nextI($i, $j){
	if($i < 8){
		return $i + 1;
		}
	return 0;
	}

	public function nextJ($i, $j){
	if($i < 8){
		return $j;
		}
	if($j < 8){
		return $j + 1;
		}
	return 8;
	}

	public function prevI($i, $j){
	if($i > 0){
		return $i - 1;
		}
	return 8;
	}

	public function prevJ($i, $j){
	if($i > 0){
		return $j;
		}
	if($j > 0){
		return $j - 1;
		}
	return 0;
	}

	public function isBoardFilled($i, $j){
	$x = 0; $y = 0;
		while($x < 9){
			while($y < 9){
				if($this->board[$x][$y] == 0){
					return false;
					}
				$y++;
				}
			$x++;
			}
		$x = 0;
		while($x < 9){
				if($this->board[$x][8] == 0){
					return false;
					}
				$x++;
				}
		return true;
		}
	
	//test functions
	public function testBox($val, $i, $j){
	$iStart = $this->findBoxStart($i);
	$jStart = $this->findBoxStart($j);
	$iEnd = $this->findBoxEnd($i);
	$jEnd = $this->findBoxEnd($j);
	
	$r = $this->testBoxRecursive($val, $iStart, $jStart, $iStart, $jStart, $iEnd, $jEnd);
	return $r;
	}

	public function testRow($val, $i, $jHold){
	if($i > 7){
		return true;
		}
	if($this->compareValues($val, $this->board[$i][$jHold])){
		$x = $this->board[$i][$jHold];
		return false;
		}
	return $this->testRow($val, $i+1, $jHold);
	}

	public function testCol($val, $iHold, $j){
	if($j > 7){
		return true;
		}
	if($this->compareValues($val, $this->board[$iHold][$j])){
		$x = $this->board[$iHold][$j];
		return false;
		}
	return $this->testCol($val, $iHold, $j + 1);
	}

	public function testBoxRecursive($val, $iStart, $jStart, $i, $j, $iEnd, $jEnd){
	if($this->compareValues($val, $this->board[$i][$j])){
		return false;
		}
	$jEndHold = $jEnd - 1;
	$iEndHold = $iEnd - 1;
	if(($i > $iEndHold)&&($j > $jEndHold)){
		if($this->compareValues($val, $this->board[$i][$j])){
			return false;
			}
		return true;
		}
	if($i < $iEnd){
			$r = $this->testBoxRecursive($val, $iStart, $jStart, $i + 1, $j, $iEnd, $jEnd);
			return $r;
			}
		
	$r = $this->testBoxRecursive($val, $iStart, $jStart, $iStart, $j + 1, $iEnd, $jEnd);
	return $r;
}	

	public function testAll($val, $i, $j){
		$iHold = $i;
		$jHold = $j;
	
		$return = $this->testCol($val, $iHold, 0);
	
		if(!$return) return $return;
		$return = $this->testRow($val, 0, $jHold);
	
		if(!$return) return $return;
		return $this->testBox($val, $i, $j);
	}
	
	public function loadTest(){
		$this->loadBoard( -6, 0, 1); 
		$this->loadBoard( -7, 0, 2);
		$this->loadBoard( -4, 0, 3);
		$this->loadBoard( -8, 0, 7);
		$this->loadBoard( -2, 1, 1);
		$this->loadBoard( -7, 1, 4);
		$this->loadBoard( -9, 1, 6);
		$this->loadBoard( -6, 3, 0);
		$this->loadBoard( -2, 3, 5);
		$this->loadBoard( -3, 3, 7);
		$this->loadBoard( -4, 3, 8);
		$this->loadBoard( -3, 4, 3);
		$this->loadBoard( -5, 4, 5);
		$this->loadBoard( -7, 5, 0);
		$this->loadBoard( -9, 5, 1);
		$this->loadBoard( -6, 5, 3);
		$this->loadBoard( -5, 5, 8);
		$this->loadBoard( -4, 7, 2);
		$this->loadBoard( -3, 7, 4);
		$this->loadBoard( -1, 7, 7);
		$this->loadBoard( -5, 8, 1);
		$this->loadBoard( -6, 8, 5);
		$this->loadBoard( -4, 8, 6);
		$this->loadBoard( -9, 8, 7);
		}
}
##############################
## end sukoku object
##############################			
function _test(){
	$sO = new sudokuObject;
	echo "<BR>BEGIN EMPTY:";
	$sO->displayEmptyBoard();
	$sO->loadTest();
	echo "<BR>BEGIN FULL:";
	$sO->displayBoard();
	}
#test();
?>