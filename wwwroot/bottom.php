
				<div class="headfoot">
			                <p>
			                    <q>Share your feelings about the environment to the world!</q> - Green Guide<br />
			                    All pages and content &copy; Copyright Green Guide Inc.
			                </p>
			    
			                <div id="w3c">
				                    <a href="https://webster.cs.washington.edu/validate-html.php">
				                        <img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
				                    <a href="https://webster.cs.washington.edu/validate-css.php">
				                        <img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
				                    <a href="https://webster.cs.washington.edu/jslint/?referer">
				                        <img src="https://webster.cs.washington.edu/images/w3c-js.png" alt="Valid CSS" /></a>
				            </div>
		        </div>
        
        </div>
       
	</body>
</html>

<script type="text/javascript">
	"use strict";
// 百度地图API功能
	var map = new BMap.Map("allmap");

	function G(id) {
		return document.getElementById(id);
	}
	
	var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
		{"input" : "suggestId"
		,"location" : map
	});

	ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
	var str = "";
		var _value = e.fromitem.val