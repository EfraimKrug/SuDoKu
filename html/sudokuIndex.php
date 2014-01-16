<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/sudoku.css">
<script type="text/javascript" src="../js/sudoku.js"></script>
<script type="text/javascript" src="../js/sudoku2.js"></script>
</head>
<body>

<div id="titleBar">&nbsp;</div>
<?php
include '../php/sudokuObject.php';
function test(){
	$sO = new SudokuObject;
	echo "<div>";
	$sO->displayEmptyBoard();
	echo "<input type=button class='pushButton' value='accept board' onclick='doit(\"\");'>";
	echo "</div>";
	};
test();
?>

<div id="WholeShebang">
<div id="WorkBoard"></div>
</div> <!-- end WholeShebang -->
</body>
</html>