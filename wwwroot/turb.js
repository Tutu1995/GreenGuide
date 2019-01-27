	var buttons = document.querySelectorAll("#turbNum");
	var Amount = document.getElementById("turbRate");
	for (var i = 0; i < buttons.length; i++) {	
		buttons[i].addEventListener("click", function() {
			
			this.style.backgroundColor = "red";
			Amount.value ="" + this.value;
			alert(Amount.value);
			console.log(Amount.value);
		})
	}