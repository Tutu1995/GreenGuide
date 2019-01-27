<?php
  include("top_1113bootest.php");
  include("db.php");
  ensure_logged_in();

	$id=htmlspecialchars($_POST["id"]);

  //$txt=htmlspecialchars($_POST["txt"]);

  $img_e_token = md5(uniqid(rand(),TRUE));
  $_SESSION["img_e_token"] = $img_e_token;

  

 // $img_d_token = md5(uniqid(rand(),TRUE));
  //$_SESSION["img_d_token"] = $img_d_token;

  $img_token=htmlspecialchars($_POST["img_token"]);


  if(!isset($_POST["img_token"]) || !isset($_SESSION["img_token"]) || $_POST["img_token"] !== $_SESSION["img_token"]) {
        print "Error: Your session is invalid. Transfer not performed. Or please check the uploading image size.";
        die();
      } else {
          //unset($_SESSION["img_token"]);

  try{
          //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
          //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
         /*
            $p_image= array();
            //$images=$con->query("select * from image where review_id=:id ");
            $images=$con->prepare("select * from image where review_id=:id ");
            $images->bindParam(':id', $id);
            $images->execute();

            if($images){  
                foreach($images as $image)  
                {
                  $p_image[]=$image;
                  //echo'<img height="190" width="190" src="data:image;base64,'.$image[2].'"> ';
                 
                }
            }

          */

            $p_image= array();
            //$p_name= array();
            $p_id= array();
            $p_size= array();
            $p_type= array();

            //$inupfile=0;


            $upimg=$db->prepare("select * from image where review_id=:id ");
            $upimg->bindParam(':id', $id);
            $upimg->execute();

            if($upimg){

                foreach($upimg as $img_id)
                {
                    $p_id[]=$img_id[0];
                    $p_size[]=$img_id[2];
                    $p_type[]=$img_id[3];
                    $img_name="uploads/".$img_id[0].".*";
                    //$p_name[]=basename($img_name,".*");
                    //echo $img_name;
                    foreach(glob("$img_name") as $image){
                        //$image=file_get_contents($image);
                      //$image=base64_encode($image);
                        $p_image[]=$image;
                        //$inupfile=1;
                    }         
                }
            } 


            /*
            if($inupfile==0){
              //$images=$con->query("select * from image where review_id= '$id' ");
              $images=$db->prepare("select * from image where review_id=:id ");
              $images->bindParam(':id', $id);
              $images->execute();
              
              if($images){ 
                  foreach($images as $image)  
                  {
                    //$p_image[]=$image[0];
                    $p_image[]=$image[1];
                    $p_id[]=$image[0];
                  }
              }
            }
            */






            $img_size=$db->prepare("select size from review where id=:id ");
            $img_size->bindParam(':id', $id);
            $img_size->execute();

            $i_size=0;

            if($img_size){  
                foreach($img_size as $size)  
                {
                    $i_size=$size[0];
                  
                }
            }


          
    }
    catch(Exception $e){
      //die(print_r($e));
      die("Sorry, error occured. Please try again.");
    }
	  
}

//$img_token = md5(uniqid(rand(),TRUE));
//$_SESSION["img_token"] = $img_token;

?>



            <div class="container">
                <!--<button onclick="location.href = 'http://greenguide.azurewebsites.net/profile.php';" id="done" class="done" >Done Image Edit -- Back to My Reviews </button> -->
                <a href="http://www.lovegreenguide.com/profile.php" class="btn btn-info" style="margin-top: 10px;" role="button" >Done Image Edit --> Back to My Reviews</a>
                <br/><br/>
                

                <!--<p style="color: blue;"><?=$txt?></p>-->
                Choose New Images: (Maximum total upload file size: 1 MB. Accepted file types: .png .jpeg .jpg .bmp .gif)<br/>
                <form method="post" enctype="multipart/form-data">
            					<input id="myFile" type="file" name="image[]" size="80" accept="image/gif, image/jpeg, image/png, image/jpg, image/bmp" multiple required onchange="myFunction()"/>
                      <input type="hidden" name="img_token" value="<?= $img_token ?>" />
                      <input type="hidden" name="id" value="<?= $id ?>" />
        			        <!--<input id="submit" type="submit" name="submit" value="Upload New Images" />-->
                      <p id="demo" class="text-primary"></p>  
                      <button type="submit" id="submit" name="submit" class="btn btn-default">Upload New Images</button>                
      			    </form><br/> 


                <?php
                     

                       if(isset($_POST['submit'])){
                           
                           
                                 try{
                                        //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
                                        //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $img_size=$db->prepare("select size from review where id=:id ");
                                        $img_size->bindParam(':id', $id);
                                        $img_size->execute();

                                        $i_size=0;

                                        if($img_size){  
                                            foreach($img_size as $size)  
                                            {
                                                $i_size=$size[0];
                                              
                                            }
                                        }

                                        $checkid=$db->prepare("select id from profile where review_id=:id and name=:name");  
                                        $checkid->bindParam(':id', $id);
                                        $checkid->bindParam(':name', $_SESSION["name"]);
                                        $checkid->execute();
                                        
                                        if($checkid){
                                          foreach($checkid as $check_id){
                                        
                                              if(isset($_FILES['image'])){  

                                                  $img_size=0;
                                                  foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
                                                    if($_FILES['image']['tmp_name'][$key]){
                                                      $img_size+=$_FILES['image']['size'][$key];
                                                    }
                                                  }

                                                   if($img_size==0)     
                                                    { 
                                                        echo "Please select an image."; 
                                                    } else { 

                                                            if($img_size>(1048576-$i_size)){
                                                                echo "Sorry, updated image size is bigger than 1 MB. Please check the image size again.";
                                                            } else {
                                                                $n = round(((1048576-$i_size-$img_size)/1024/1024),4);
                                                                echo "This review has ".$n. " MB left for new images."  ;   

                                                                $target_dir = "uploads/";                         
                                                                foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
                                                                      $image=addslashes($_FILES['image']['tmp_name'][$key]);
                                                                      //$name=addslashes($_FILES['image']['name'][$key]);
                                                                      $image=file_get_contents($image);
                                                                      $image=base64_encode($image);
                                                                      $up_size=$_FILES['image']['size'][$key];
                                                                      //$result=$con->query("insert into image (name,image,review_id) values('$name','$image','$id')");
                                                                      //$result=$db->prepare("insert into image (image,review_id,size) values(:image, :id, :size)");
                                                                      $target_file = $target_dir . basename(addslashes($_FILES['image']['name'][$key]));
                                                                      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                                                                      $result=$db->prepare("insert into image (review_id,size,file_type) values(:id, :size, :type)");
                                                                      //$result->bindParam(':image', $image);
                                                                      $result->bindParam(':id', $id);
                                                                      $result->bindParam(':size', $up_size);
                                                                      $result->bindParam(':type', $imageFileType);
                                                                      $result->execute();

                                                                      $img_last_id = $db->lastInsertId();
                                                                      
                                                                      $upload_file_name = $target_dir .basename($img_last_id).".". $imageFileType;

                                                                      if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $upload_file_name)) {
                                                                            echo "  The file ". basename(addslashes($_FILES['image']['name'][$key])). " has been uploaded. ";
                                                                      } else {
                                                                            echo "Sorry, there was an error uploading your file.";
                                                                      }

                                                                }
                                                                      $all_size=$i_size+$img_size;
                                                                     
                                                                      $set_null=$db->prepare("update review set status=:status, size=:size where id=:id"); 
                                                                      $set_null->bindParam(':id', $id);
                                                                      $set_null->bindValue(':status', null, PDO::PARAM_INT);
                                                                      $set_null->bindParam(':size', $all_size);
                                                                      $set_null->execute(); 

                                                                      //include("show_up_img.php");

                                                                     /*
                                                                      $p_image= array();
                                                                      //$images=$con->query("select * from image where review_id=:id ");
                                                                      $images=$con->prepare("select * from image where review_id=:id ");
                                                                      $images->bindParam(':id', $id);
                                                                      $images->execute();

                                                                      if($images){  
                                                                          foreach($images as $image)  
                                                                          {
                                                                            $p_image[]=$image;
                                                                            //echo'<img height="190" width="190" src="data:image;base64,'.$image[2].'"> ';
                                                                           
                                                                          }
                                                                      }
                                                                    */

                                                                      $p_image= array();
                                                                      $p_id= array();
                                                                      $p_size= array();
                                                                      $p_type= array();
                                                                      //$inupfile=0;

                                                                      $upimg=$db->prepare("select * from image where review_id=:id ");
                                                                      $upimg->bindParam(':id', $id);
                                                                      $upimg->execute();

                                                                      if($upimg){

                                                                          foreach($upimg as $img_id)
                                                                          {
                                                                              $p_id[]=$img_id[0];
                                                                              $p_size[]=$img_id[2];
                                                                              $p_type[]=$img_id[3];
                                                                              $img_name="uploads/".$img_id[0].".*";
                                                                              //echo $img_name;
                                                                              foreach(glob("$img_name") as $image){
                                                                                  //$image=file_get_contents($image);
                                                                                //$image=base64_encode($image);
                                                                                  $p_image[]=$image;
                                                                                  //$inupfile=1;
                                                                              }         
                                                                          }
                                                                      } 


                                                                      /*
                                                                      if($inupfile==0){
                                                                        //$images=$con->query("select * from image where review_id= '$id' ");
                                                                        $images=$db->prepare("select image from image where review_id=:id ");
                                                                        $images->bindParam(':id', $id);
                                                                        $images->execute();
                                                                        
                                                                        if($images){ 
                                                                            foreach($images as $image)  
                                                                            {
                                                                              $p_image[]=$image[0];
                                                                             
                                                                            }
                                                                        }
                                                                      }
                                                                      */
                                                          }
                                                    }
                                              }
                                          }
                                         }
                                  }
                                  catch(Exception $e){
                                    //die(print_r($e));
                                    die("Sorry, error occured. Please try again.");
                                  }
                          
                        }
                      
                        
?>

  
                <div id="list"></div>
                
              
            </div>

            <?php
                include("footer.php");
            ?>

          <!--
          <h1 style="clear:both; visibility: hidden;">hidden</h1>
          <div class="headfoot" >
                <p>
                    <q>Share your feeling about the environment to the world!</q> - Green Guide<br>
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
          -->
        </div>
       
	</body>
</html>



<script type="text/javascript">
		
  var image = <?php echo json_encode($p_image) ?>;
  //var image_name = <?php echo json_encode($p_name) ?>;
  var img_p_id = <?php echo json_encode($p_id) ?>;
  var img_p_size = <?php echo json_encode($p_size) ?>;
  var img_p_type = <?php echo json_encode($p_type) ?>;
  var img_review_id = <?php echo json_encode($id) ?>;
  //var inupfile = <?php echo json_encode($inupfile) ?>;
  var i_size = <?php echo json_encode($i_size) ?>;
  //alert("i_size:"+i_size);

  document.getElementById("submit").disabled = true;

  //alert("image_name:"+image_name[0]);

  //var img_d_token = <?php echo json_encode($img_d_token) ?>;

  document.getElementById("profile").className="active";

  var list=document.getElementById("list");
      while (list.hasChildNodes()) {   
        list.removeChild(list.firstChild);
      }

     
          for (var j = 0; j < image.length; j++) {                     
            var img = document.createElement("img");            
            //img.setAttribute("src", "data:image/jpg;base64,"+image[j].image);     
            /*
            if(inupfile==0){
                  img.setAttribute("src", "data:image/jpg;base64,"+image[j]);
                  var image_id=image_id[j];
                  //alert(image_id);
            }
            else{  */ 
                  img.setAttribute("src", image[j]);   

                  //alert("image_basename:"+image_name[j]);
                  var image_id=img_p_id[j];
                  //alert(image_id);
            //} 

         
            img.className="img_e";  
            var image_div = document.createElement("div");
            image_div.className="image_e_div";  
            image_div.setAttribute("id", "img_div_d"+image_id ); 

            image_div.appendChild(img); 
            

            var btn = document.createElement("BUTTON");       
            btn.innerHTML="Delete";          
            //btn.className="btn_img_d";

            

            btn.data = {        
                img_id: image_id,  
                id: img_review_id,     
                size: img_p_size[j],
                type: img_p_type[j]
            }
            //alert("img_id:"+ image_id );
            //alert("btn id:"+ img_review_id );
            //alert("btn size:"+ img_p_size[j] );
            //alert("btn type:"+ img_p_type[j] );
            btn.onclick=btnClick_img_d;
            
            image_div.appendChild(btn);

            list.appendChild(image_div); 

          }


  function myFunction(){
      var x = document.getElementById("myFile");
      var txt = "";
      var file_size=0;
      var _validFileExtensions = ["jpg", "jpeg", "bmp", "gif", "png"];  
      var file_type=true;

      if ('files' in x) {
          if (x.files.length == 0) {
              txt = "Select one or more files.";
          } else {
              for (var i = 0; i < x.files.length; i++) {
                  //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                  var file = x.files[i];
                  
                  if ('size' in file) {
                      file_size +=  file.size;
                  }
                  var FileName  = x.files[i].name;
                  /*
                  var arr1 = new Array;
          arr1 = FileName.split("\\");
          var len = arr1.length;
          var img1 = arr1[len-1];
          var filext = img1.substring(img1.lastIndexOf(".")+1);
          */
              
                
              if (FileName.length > 0) {
                var FileExt = FileName.substring(FileName.lastIndexOf('.')+1);
                //alert(FileExt);

                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        //alert(FileExt.toLowerCase());
                        //alert(sCurExtension.toLowerCase());
                        if (FileExt.toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }

                    if (!blnValid) {
                        txt += "Sorry, " + FileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", ")+"<br>";
                        document.getElementById("submit").disabled = true;
                        var file_type=false;
                        document.getElementById("submit").style.color="gray";
                        //return false;
                    }
                    
                }
              }

              
              var n = parseFloat(file_size/1024/1024).toFixed(4);
              txt += "Total image size: " + n + " MB <br>";
              if (file_size>(1048576-i_size)){
                txt += "The total image size is too big! Please choose the file again. ";
                document.getElementById("submit").disabled = true;
                document.getElementById("submit").style.color="gray";
              } else if(file_size<=(1048576-i_size) && file_type){
                txt += "The total image size is OK.";
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").style.color="green";
                document.getElementById("submit").style.fontWeight="bold";
              }
          }
      } 
      else {
          if (x.value == "") {
              txt += "Select one or more files.";
          } else {
              txt += "The files property is not supported by your browser!";
              txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
          }
      }
      
      document.getElementById("demo").innerHTML = txt;
  }




  function btnClick_img_d(){
        //alert("delete image");
       
          var params = new FormData();
          params.append("img_id", this.data.img_id); 
          params.append("id", this.data.id);  
          params.append("size", this.data.size);   
          params.append("type", this.data.type);   
          //params.append("img_d_token", img_d_token);
          //alert(this.data.size);
          
          var ajax = new XMLHttpRequest();
          ajax.onload = img_del;
          ajax.open("POST", "btnClick_img_d.php", true);
          ajax.send(params);

          

      }

  function img_del() {
        //alert("3");
        if (this.status == 200) {
          //alert("4");
          //alert("this.responseText"+this.responseText);  

          var img_d=document.getElementById("img_div_d"+this.responseText );        
          list.removeChild(img_d);        
     
        }
        else{
          //alert("error in ajax");
          alert("Sorry, error occured. Please try again.");
        }
      }     
  

  map = new BMap.Map("allmap");
  // 百度地图API功能
  function G(id) {
    return document.getElementById(id);
  }
  
  var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
    {"input" : "suggestId"
    ,"location" : map
  });

  ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
  var str = "";
    var _value = e.fromitem.value;
    var value = "";
    if (e.fromitem.index > -1) {
      value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
    }    
    str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
    
    value = "";
    if (e.toitem.index > -1) {
      _value = e.toitem.value;
      value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
    }    
    str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
    G("searchResultPanel").innerHTML = str;
  });

  var myValue;
  ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
  var _value = e.item.value;
    myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
    G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
    
    setPlace();
  });
  
  
  function setPlace(){
    //map.clearOverlays();    //清除地图上所有覆盖物
    function myFun(){
      var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
      
      senGet(local.getResults().getPoi(0).title, pp.lng, pp.lat);
      
    }
    var local = new BMap.LocalSearch(map, { //智能搜索
      onSearchComplete: myFun
    });
    local.search(myValue);
  }
  
  
  function senGet(company, lng, lat)
    {
        var mydiv = document.getElementById('getCompany').innerHTML = '<form id="getC"  action="company.php"><input name="company" type="hidden" value="'+ company +'" /><input name="lng" type="hidden" value="'+ lng +'" /><input name="lat" type="hidden" value="'+ lat +'" /></form>';
        var f=document.getElementById('getC');
        if(f){
        f.submit();
            //alert('submitted!');
        }
    }
  
  

</script>