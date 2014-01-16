
function getAnswers(x){
		goAJAX(x);
		//alert('hello');
		}
	
function goAJAX2(t){
	alert(t);
	}
	
function doit(){
	goAJAX('default');
	}

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
