<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/sudoku.css">
<script>
function getConnection(){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function goAJAX(val){
var msg = "";
var loadString = "";
xmlhttp = getConnection();
xmlhttp.onreadystatechange=function(){
	if (xmlhttp.readyState==4 && xmlhttp.status==200){
		newBoard = xmlhttp.responseText;
		//document.getElementById("WholeShebang").innerHTML="";
		var x = document.getElementById("WholeBoard");
		x.innerHTML= newBoard;
		//var y = document.getElementById("BR0");
		//alert(x.id);
		//alert(y.style.height);
		
		//document.getElementById("WorkBoard").innerHTML=newBoard;
		}
	}
	//alert(val);
	if(val == "default"){ // from board... now figuring the board out
		msg = encodeURIComponent(JSON.stringify(boardValueArrayJSON));
		loadString = "//localhost/sudoku/php/sudokuAJAX.php?val=" + msg;
		}
	else { //from user
		msg = encodeURIComponent(val);
		loadString = "//localhost/sudoku/php/sudokuAJAX.php?val1=" + msg;
		}
	xmlhttp.open("GET",loadString,true);
	xmlhttp.send();
	}

</script>

</head>
<body>

<div id="titleBar">&nbsp;</div>
<script>
function getAnswers(x){
		goAJAX(x);
		//alert('hello');
		}
	
function goAJAX2(t){
	alert(t);
	}
	
function doit(){
	goAJAX('default');
	//alert('done it');
	}
</script>
<!--
<div id="buttonPlace">
<input type='button' onclick='doit()' value='Set up board!'>
</div>
-->
<?php
include '../php/sudokuObject.php';
function test(){
	$sO = new SudokuObject;
	#$sO->loadTest();
	echo "<div>";
	$sO->displayEmptyBoard();
	#echo "</div><div>";
	#echo "<input type=button class='pushButton' value='get answer' onclick='getAnswers(\"" . 
	#		json_encode($sO->getBoard()) . "\");'>";
	echo "<input type=button class='pushButton' value='accept board' onclick='doit(\"\");'>";
	echo "</div>";
	};
test();
?>

<div id="WholeShebang">
<div id="WorkBoard"></div>

<script>

//var boardValueArray = new Array();

// array with: "idname":"idvalue" e.g. "b00":"5"
var boardValueArrayJSON = { "tablevals" : [] };
	
function go2(){
	alert(boardValueArrayJSON.tablevals);
	}
	
function pushValue(box){
	if((box.value > 0) && (box.value < 10)){
		boardValueArrayJSON.tablevals.push( box.id + "':'" + box.value );
		}
	}
	
function setUpBoardReading(){
var l = document.getElementsByClassName("ib").length;
var box = document.getElementById("b00");
	var i=0;
	var j=0;
	var id = "b";
	id = id + i + j;
	for(var i=0; i < 9; i++){
		for(var j=0; j < 9; j++){
			id = "b" + i + j;
			var box = document.getElementById(id);
			box.setAttribute("onblur", "pushValue(this);");
			}
		}
}
setUpBoardReading();
</script>
</div> <!-- end WholeShebang -->
</body>
</html>