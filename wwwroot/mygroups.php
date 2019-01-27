<?php
include("db.php");
ensure_logged_in();

$edit_token = md5(uniqid(rand(),TRUE));
$_SESSION["edit_token"] = $edit_token;

$img_token = md5(uniqid(rand(),TRUE));
$_SESSION["img_token"] = $img_token;

try{
  $s_name=$_SESSION["name"];
  $rows=$db->query("select name, description, id from meetup_groups m where m.owner_email='$s_name'");
  $all=array();
  foreach ($rows as $row) {
    $all[]=$row;
  }
}
catch(Exception $e){
  //die(print_r($e));
  die("Sorry. Error occurred. Please try again.");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <!-- <link href="WriteReview.css" type="text/css" rel="stylesheet" /> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link href="mygroups.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.4.min.js" type="text/javascript"></script>
    <title>User Pages</title>
    <link rel="shortcut icon" href="green-pin.png">
  </head>
  <body>
    <?php
    include("header_b.php");
    ?>
    <div class="container-fluid"><h2 class="text-primary">YOUR PAGES</h2></div>
    <div class="well well-sm">
        <strong>Display</strong>
        <div class="btn-group">
            <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
            </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                class="glyphicon glyphicon-th"></span>Grid</a>
        </div>
    </div>
    <div class="row list-group" id="allPagesInGrid">
      <!-- The shape of the Div after Javascript alters the dom -->
      <!-- <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        Product title</h4>
                    <p class="group inner list-group-item-text">
                        Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                        sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="http://www.jquery2dotnet.com">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div id="content"/>
    <?php
    include("footer.php");
    ?>
  </body>
</html>

<script type="text/javascript">
"use strict";
$(document).ready(function() {
    $('#list').click(function(event){
      event.preventDefault();
      var allPages = document.getElementById("allPagesInGrid");
      if (!allPages) {
        return;
      }
      var allItems = allPages.children;
      if (!allItems) {
        return;
      }
      var numItems = allItems.length;
      for (var i = 0; i < numItems; i++) {
        if (allItems[i]) allItems[i].setAttribute("class", "list-group-item");
      }
    });
    $('#grid').click(function(event) {
      event.preventDefault();
      var allPages = document.getElementById("allPagesInGrid");
      if (!allPages) {
        return;
      }
      var allItems = allPages.children;
      if (!allItems) {
        return;
      }
      var numItems = allItems.length;
      for (var i = 0; i < numItems; i++) {
        if (allItems[i]) {
          allItems[i].setAttribute("class", 'item  col-xs-4 col-lg-4');
        }
      }
    });
});
var getQueryString = function ( field, url ) {
	var href = url;
	var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
	var string = reg.exec(href);
	return string ? string[1] : null;
};
document.onclick = function (e) {
  e = e ||  window.event;
  var element = e.target || e.srcElement;
  if (element.tagName == 'A') {
    var pageId = getQueryString("pageid", element.href);
    $.ajax({
       type: "GET",
       url: 'viewpage.php',
       data: "pageid=" + pageId,
       success: function(data) {
         var elem = $('#content');
         $(window).scrollTop(elem.offset().top);
         $(window).scrollLeft(elem.offset().left);
         elem.html(data);
       }
     });
    return false;
 }
};

var data = <?php echo json_encode($all) ?>;
var all = data;
var edit_token = <?php echo json_encode($edit_token) ?>;
var img_token = <?php echo json_encode($img_token) ?>;
var length=data.length;

document.getElementById("profile").className="active";
setPagesInAGrid();

function setPagesInAGrid() {
  var pageGrid = document.getElementById("allPagesInGrid");
  while (pageGrid.hasChildNodes()) {
    pageGrid.removeChild(pageGrid.firstChild);
  }

  var pageNum = data.length;
  for (var i = 0; i < pageNum; i++) {
    var rectangular = document.createElement("div");
    rectangular.setAttribute("class", "item  col-xs-4 col-lg-4");
    var thumbnail = document.createElement("div");
    thumbnail.setAttribute("class", "thumbnail");
    var caption = document.createElement("div");
    caption.setAttribute("class", "caption");

    var h4 = document.createElement("h4");
    h4.setAttribute("class", "group inner list-group-item-heading");
    h4.innerHTML = data[i].name;

    var description = document.createElement("p");
    description.setAttribute("class", "group inner list-group-item-text");
    description.innerHTML = data[i].description;

    var row = document.createElement("div");
    row.setAttribute("class", "row");

    var buttonCol = document.createElement("div");
    buttonCol.setAttribute("class", "col-xs-12 col-md-6");
    var detailsButton = document.createElement('a');
    detailsButton.setAttribute("class", "btn btn-success");
    detailsButton.innerHTML = "View Details";
    var pageUrl =  "viewpage.php?pageid=" + data[i].id;
    //detailsButton.onClick=getPageDetails(data[i].id);
    detailsButton.href = pageUrl;

    buttonCol.appendChild(detailsButton);
    row.appendChild(buttonCol);
    caption.appendChild(h4);
    caption.appendChild(description);
    caption.appendChild(row);
    thumbnail.appendChild(caption);
    rectangular.appendChild(thumbnail);
    pageGrid.appendChild(rectangular);
  }
}
</script>
