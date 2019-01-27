<?php
	$id=$_POST["id"];

  try{
          $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
         
            $p_image= array();
            $images=$con->query("select * from image where review_id='$id' ");
            if($images){  
                foreach($images as $image)  
                {
                  $p_image[]=$image;
                  //echo'<img height="190" width="190" src="data:image;base64,'.$image[2].'"> ';
                 
                }
            }
          
    }
    catch(Exception $e){
      die(print_r($e));
    }
	  


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Write a Review</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
       
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        <script src="rate.js" type="text/javascript"></script>
		
	</head>

	<body>
      <div class="wrapper">
            <header>	
                <p class="head">
                    Green Guide
                </p>
            
                <div id="search">
                    <!-- form to search for every movie by a given actor -->
                    <form action="search-all.php" >
                            <div>
                                <input id="suggestId_2" name="s_company" type="text" size="24" placeholder="Company Name" autofocus /> 
                                <input name="s_location" type="text" size="24" placeholder="Near Location" /> 
                                <input type="submit" value="go" />
                            </div>
                    </form>
                    <div id="searchResultPanel_2" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                    <div id="getCompany"></div>
                 </div>  
                 
                 <nav>
                     <ul id="topmenu">
                          <li>Home</li>
                          <li>User Profile</li>
                          <li><a href="WriteReview.php">Write a Community Review</a></li>
                          <li><a href="map.php">Explore Reviews on a Map</a></li>
                     </ul> 
                 </nav>
             </header>       
		

            <div class="main">
                
                <button onclick="location.href = 'http://greenguide.azurewebsites.net/profile.php';" id="done" class="done" >Done Image Edit --> Back to User Profile :) </button>
                <br/><br/><br/>

                Choose New Images: <br/>
                <form id="file-form" action="new_img.php" method="post" enctype="multipart/form-data">
            					<input id="file-select" type="file" name="image[]" size="80" accept="image/*" multiple />
            					<input id="id" type="hidden" name="id" value="<?=$id?>" > 
        			        <!--<input id="upload-button" type="submit" name="submit" value="Upload New Images" /> -->
                      <button type="submit" name="submit" id="upload-button">Upload New Images</button>                 
      			    </form><br/>

  
                <div id="list"></div>
                
              
            </div>
          

          <div class="headfoot">
                <p>
                    <q>Share your feeling about the environment to the world!</q> - Green Guide<br />
                    All pages and content &copy; Copyright Green Guide Inc.
                </p>
    
                <div id="w3c">
                    <a href="https://webster.cs.washington.edu/validate-html.php">
                        <img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
                    <a href="https://webster.cs.washington.edu/validate-css.php">
                        <img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
                </div>
          </div>
        
        </div>
       
	</body>
</html>

<script type="text/javascript">
		
  var image = <?php echo json_encode($p_image) ?>;

  var list=document.getElementById("list");
      while (list.hasChildNodes()) {   
        list.removeChild(list.firstChild);
      }

     
          for (var j = 0; j < image.length; j++) {                     
            var img = document.createElement("img");            
            img.setAttribute("src", "data:image/jpg;base64,"+image[j].image);            
            img.className="img_e";  
            var image_div = document.createElement("div");
            image_div.className="image_e_div";  
            image_div.setAttribute("id", "img_div_d"+image[j].id ); 

            image_div.appendChild(img); 
            

            var btn = document.createElement("BUTTON");       
            btn.innerHTML="Delete";          
            //btn.className="btn_img_d";
            btn.data = {        
                img_id: image[j].id,        
            }
            alert("data_id:"+ image[j].id );
            btn.onclick=btnClick_img_d;
            
            image_div.appendChild(btn);

            list.appendChild(image_div); 

          }



  function btnClick_img_d(){
          alert("delete image");
       
          var params = new FormData();
          params.append("img_id", this.data.img_id);      
          
          var ajax = new XMLHttpRequest();
          ajax.onload = img_del;
          ajax.open("POST", "btnClick_img_d.php", true);
          ajax.send(params);

          

      }

  function img_del() {
        alert("3");
        if (this.status == 200) {
          alert("4");
          alert(this.responseText);  

          var img_d=document.getElementById("img_div_d"+this.responseText );        
          list.removeChild(img_d);        
     
        }
        else{
          alert("error in ajax");
        }
      }



  var form = document.getElementById('file-form');
  var fileSelect = document.getElementById('file-select');
  var uploadButton = document.getElementById('upload-button'); 
  var id = document.getElementById('id'); 


  form.onsubmit = function(event) {
          event.preventDefault();

          // Update button text.
          uploadButton.innerHTML = 'Uploading...';

          // The rest of the code will go here...
          // Get the selected files from the input.
          var files = fileSelect.files;

          // Create a new FormData object.
          var formData = new FormData();

          // Loop through each of the selected files.
          for (var i = 0; i < files.length; i++) {
          var file = files[i];


          // Add the file to the request.
          formData.append('image[]', file, file.name);
        }
        formData.append('id', id.value);
        alert(id.value);

        // Set up the request.
        var xhr = new XMLHttpRequest();
        xhr.onload=up_img;
        // Open the connection.
        xhr.open('POST', 'new_img.php', true);
        xhr.send(formData);
}

 

function up_img() {
        alert("3");
        if (this.status == 200) {
          alert(this.responseText);
          var json = JSON.parse(this.responseText);
          alert("4");
          var uploadButton = document.getElementById('upload-button'); 
          uploadButton.innerHTML = 'Upload'; 
          var list=document.getElementById("list");


          for (var j = 0; j < json.all_image.length; j++) {                      
            alert("yes");
            var img = document.createElement("img");            
            img.setAttribute("src", "data:image/jpg;base64,"+json.all_image[j].image);            
            img.className="img_e";  
            var image_div = document.createElement("div");
            image_div.className="image_e_div";  
            image_div.setAttribute("id", "img_div_d"+json.all_image[j].id ); 

            image_div.appendChild(img); 
            

            var btn = document.createElement("BUTTON");       
            btn.innerHTML="Delete";          
            //btn.className="btn_img_d";
            btn.data = {        
                img_id: json.all_image[j].id,        
            }
            alert("data_id:"+ json.all_image[j].id );
            btn.onclick=btnClick_img_d;
            
            image_div.appendChild(btn);

            list.appendChild(image_div); 

          }      
     
        }
        else{
          alert("error in ajax");
        }
      }





    

</script>