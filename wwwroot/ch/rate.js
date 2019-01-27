// JavaScript Document
(function(){
	"use strict";
window.onload=function(){
	//alert("square!");
	var squareArea=document.getElementById("sarea");
	var squareCount=7;
	var hint=document.getElementById("hint");
	hint.innerHTML="";
	hint.innerHTML="点击选择评分"; 
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="20px";
	note.style.top="5px";
	note.innerHTML="<-差"
	squareArea.appendChild(note);
	
	var note = document.createElement("div");
	note.className="note";
	note.style.left="370px";
	note.style.top="5px";
	note.innerHTML="好->"
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
		hint.innerHTML="严重污染！我不能呼吸！严重烟雾对健康有害。PM2.5>300。水是又脏又臭，甚至呈现诡异的色彩。所有的鱼都完全死了。未经处理的废弃物到处都是。";
	}
	if (this.innerHTML==-2){
		hint.innerHTML="太糟糕了！空气很糟糕，不利健康。PM2.5:200-300。水被未经处理的废水污染。大多数鱼都死了。";
	}
	if (this.innerHTML==-1){
		hint.innerHTML="不好。空气质量不好，每个人都开始感到不适。PM2.5:150-200。河流是肮脏的。";
	}
	if (this.innerHTML==0){
		hint.innerHTML="一般般。空气质量马马虎虎。PM2.5:100-150。水被污染。";
	}
	if (this.innerHTML==1){
		hint.innerHTML="空气质量尚可。PM2.5:50-100。废水排放到河流之前经过处理。";
	}
	if (this.innerHTML==2){
		hint.innerHTML="良好的环境管理。空气质量好，PM2.5<50。水是干净的有鱼。";
	}
	if (this.innerHTML==3){
		hint.innerHTML="优秀的环境管理！空气质量真棒，呼吸是一种快乐。PM2.5<30。河流清洁并围绕良好的生态系统。";
	}
}

function squareClick(){
	var rate =document.getElementById("rate");
	rate.innerHTML=" "+this.innerHTML;
	var rating =document.getElementById("rating");
	rating.value=this.innerHTML;
}

})();