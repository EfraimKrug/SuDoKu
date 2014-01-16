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
		var x = document.getElementById("WholeBoard");
		x.innerHTML= newBoard;
		alert(newBoard);
		}
	}
	if(val == "default"){ // from board... now figuring the board out
		msg = encodeURIComponent(JSON.stringify(boardValueArrayJSON));
		loadString = "//localhost/sudoku/php/sudokuAJAX.php?val=" + msg;
		alert(loadString);
		}
	else { //from user
		msg = encodeURIComponent(val);
		loadString = "//localhost/sudoku/php/sudokuAJAX.php?val1=" + msg;
		}
	xmlhttp.open("GET",loadString,true);
	xmlhttp.send();
	}

