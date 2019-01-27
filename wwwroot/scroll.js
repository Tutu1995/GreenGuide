// JavaScript Document
(function(){
	"use strict";
window.onscroll = function() {myFunction()};

	function myFunction() {
		//alert("scroll");
	    if (document.body.scrollTop> 100 || document.documentElement.scrollTop > 100) {
	    	
	        document.getElementById("fixed").className = "fixed_2";
	        //alert("2");
	        
	    } else {
	    	
	        document.getElementById("fixed").className = "fixed_1";
	        //alert("1");
	    }
	}

})();