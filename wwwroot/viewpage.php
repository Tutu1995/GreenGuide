<?php
include("db.php");
ensure_logged_in();

try{
  // Parse the url to get the query param.
  $pageid = $_GET['pageid'];
  $s_name=$_SESSION["name"];
  $rows = $db->query("select * from meetup_groups m where m.owner_email='$s_name' and m.id='$pageid'");
  if (!isset($rows)) {
    die("Sorry, Page does not exist, or access denied.");
  }
  $allDetails=array();
  foreach ($rows as $row) {
    $allDetails[]=$row;
  }
}
catch(Exception $e){
  die("Sorry. Error occurred. Please try again.");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link href="mygroups.css" type="text/css" rel="stylesheet"/>
  </head>
  <body>
    <div class="item list-group-item">
      <div id="pagedetails" class="caption"/>
      <div id="createevent" class="col-xs-12 col-md-6"/>
    </div>
    <?php
    include("footer.php");
    ?>
  </body>
</html>

<script type="text/javascript">
"use strict";
var data = <?php echo json_encode($allDetails) ?>;
var pageDiv=document.getElementById("pagedetails");
var ownerName = <?php echo json_encode($s_name) ?>;
var page_info=
  "<h4 style='margin:0 0 5px 0;'>"+data[0].name+"</h4>" +
  "Owner: " + ownerName + "<br/>" +
  "Page Category: " + data[0].category +
  "<br/><br/>";
pageDiv.innerHTML = page_info;
showEvents();
showCreateEventControl();

function showEvents() {
  var pageDiv=document.getElementById("pagedetails");
  var eventsDiv = document.createElement("div");
  var html = "<h4 style='margin:0 0 5px 0;'>All your events will appear below.</h4>";
  eventsDiv.innerHTML = html;
  pageDiv.appendChild(eventsDiv);
  var br = document.createElement('br');
  pageDiv.appendChild(br);
}

function showCreateEventControl() {
  var pageId = <?php echo json_encode($pageid) ?>;
  var createEventDiv = document.getElementById("createevent");
  var createEventButton = document.createElement('a');
  createEventButton.setAttribute("class", "btn btn-success");
  createEventButton.href =  "createevent.php?pageid=" + pageId;;
  createEventButton.innerHTML = "Create New Event Here"; // <a>INNER_TEXT</a>
  createEventDiv.appendChild(createEventButton);
}
</script>
