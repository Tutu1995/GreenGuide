// JavaScript Document
(function(){
	"use strict";
window.onload=function(){
	//alert("square!");
	var squareArea=document.getElementById("sarea");
	var squareCount=7;
	var hint=document.getElementById("hint");
	hint.innerHTML="";
	hint.innerHTML="Roll over squares, then click to rate."; 
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="20px";
	note.style.top="5px";
	note.innerHTML="<-Bad"
	squareArea.appendChild(note);
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="370px";
	note.style.top="5px";
	note.innerHTML="Good->"
	squareArea.appendChild(note);
	
	for(var i=0; i<squareCount;i++){
		//alert("count:"+i);
		var square = document.createElement("div");
		square.className="square";
		square.style.left=(103+35*i)+"px";
		square.style.top="3px";
		square.onmouseover=squareOver;
		square.onclick=squareClick;
		squareArea.appendChild(square);
		if ((-3+i)>0){
			square.innerHTML="+"+(-3+i);
		}else{
			square.innerHTML=-3+i;
		}
		
		if (i==0){
			square.style.backgroundColor="red";
		}
		if (i==1){
			square.style.backgroundColor="orange";
		}
		if (i==2){
			square.style.backgroundColor="yellow";
		}
		if (i==3){
			square.style.backgroundColor="white";
		}
		if (i==4){
			square.style.backgroundColor="aqua";
		}
		if (i==5){
			square.style.backgroundColor="lime";
		}
		if (i==6){
			square.style.backgroundColor="RGB(0,176,80)";
		}
	}
};

function squareOver(){
	var no_border = document.querySelectorAll("#sarea div");
    for (var i = 0; i < no_border.length; i++) {
        no_border[i].style.border="";
    }  
	hint.innerHTML=""; 
	
	this.style.border="2px solid black";
	this.style.cursor="pointer";
	
	if (this.innerHTML==-3){
		hint.innerHTML="Serious pollution! I can't breath! serious smog and the air is harmful to health. PM2.5 >300. Water is dirty and smelly, even with strange color. All Fish are dead totally. Waste dump untreated everywhere. ";
	}
	if (this.innerHTML==-2){
		hint.innerHTML="Too Bad! Air is very bad and unhealthy. PM2.5 200-300. Water is polluted by untreated waste water. Most fish are dead.";
	}
	if (this.innerHTML==-1){
		hint.innerHTML="Not good. Air quality is bad and everyone begins to experience health effects. PM2.5 150-200. Rivers are dirty.";
	}
	if (this.innerHTML==0){
		hint.innerHTML="So-so. Air quality is so-so and PM2.5 100-150. Water is polluted.";
	}
	if (this.innerHTML==1){
		hint.innerHTML="Air quality is ok and PM2.5 50-100. Waste water is treated before releasing to rivers.";
	}
	if (this.innerHTML==2){
		hint.innerHTML="Good environmental management. Air quality is good and PM2.5<50. Water is clean with fish.";
	}
	if (this.innerHTML==3){
		hint.innerHTML="Great environmental management! Air quality is awesome and it is a joy just breathing. PM2.5<30. Water is clean and good ecosystems around the rivers.";
	}
}

function squareClick(){
	var rate =document.getElementById("rate");
	rate.innerHTML=" "+this.innerHTML;
	var rating =document.getElementById("rating");
	rating.value=this.innerHTML;
}

})();