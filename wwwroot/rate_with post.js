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
		hint.innerHTML="Serious pollution! I can't breath!";
	}
	if (this.innerHTML==-2){
		hint.innerHTML="Too Bad!";
	}
	if (this.innerHTML==-1){
		hint.innerHTML="Not good";
	}
	if (this.innerHTML==0){
		hint.innerHTML="soso";
	}
	if (this.innerHTML==1){
		hint.innerHTML="good";
	}
	if (this.innerHTML==2){
		hint.innerHTML="very good";
	}
	if (this.innerHTML==3){
		hint.innerHTML="it's a joy just breathing";
	}
}

function squareClick(){
	var rate =document.getElementById("rate");
	rate.innerHTML="Your rating is: "+this.innerHTML;
	var rating =document.getElementById("rating");
	rating.value=this.innerHTML;
	
	
	var post=document.getElementById("post");
	var squareCount=7;	
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="20px";
	note.style.top="5px";
	note.innerHTML="<-Bad"
	post.appendChild(note);
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="370px";
	note.style.top="5px";
	note.innerHTML="Good->"
	post.appendChild(note);
	alert("post1");
	var color=["red","orange","yellow","white","aqua","lime","RGB(0,176,80)"];
	alert("post2");
	for(var i=0; i<squareCount;i++){
		alert("count:"+i);
		var square = document.createElement("div");
		square.className="square";
		square.style.left=(103+35*i)+"px";
		square.style.top="3px";
				
		if ((-3+i)>0){
			square.innerHTML="+"+(-3+i);
		}else{
			square.innerHTML=-3+i;
		}
		alert("i:"+i+"inner:"+(parseInt(this.innerHTML)+3));
		if (i==(parseInt(this.innerHTML)+3)){
			alert("i:"+i+"inner:"+(parseInt(this.innerHTML)+3));
			alert(color[i]);
			square.style.backgroundColor=color[i];
		}
		else {
			square.style.backgroundColor="silver";
		}	
		post.appendChild(square);	
	}
}

})();