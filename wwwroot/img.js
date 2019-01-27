var current=1; var total=2; var time;



window.onload = function() {
	 
	imageChanger(); 

};

function imageChanger() { time=setInterval(function(){changeImage();}, 10000); }

function changeImage() { 
current++; 
	if(current > total)
	{ 
		current=1;
	}
	document.getElementById("image").src="image"+current+".png"; 

	if(current ==1 )
	{
		document.getElementById("title").innerHTML = "Protecting the environment is everyone's responsibility, and it starts with understanding the issues. *";
	}
	if(current ==2 )
	{
		document.getElementById("title").innerHTML = "Clean water and green mountains are as valuable as gold and silver mountains.";
	}
}


