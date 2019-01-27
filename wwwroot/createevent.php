<?php

include("db.php");
ensure_logged_in();

$token = md5(uniqid(rand(), true));
$_SESSION["token"] = $token;
$ownerPageId = $_GET['pageid'];
$_SESSION['createeventpageid'] = $ownerPageId;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Create A new event here:</title>

  <link href="WriteReview.css" type="text/css" rel="stylesheet" />

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

  <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>

  <script src="rate.js" type="text/javascript"></script>
  <link rel="shortcut icon" href="green-pin.png">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- the javascript and CSS, hengyu made -->
  <link rel="stylesheet" type="text/css" href="review.css">

  <script src="turb.js" type="text/javascript"></script>
</head>
<style>
body {
  margin: 0;
}
#eventpicture img {
  width: 100%;
  margin: auto;
}
</style>
<body>
  <?php
  include("header_b.php");

  if (isset($_SESSION["flash"])) {
    ?>
    <div class="container-fluid">
      <div id="flash"><?=$_SESSION["flash"]?></div>
    </div>
    <?php
    unset($_SESSION["flash"]);
  }

  ?>

  <div class="container text-center"><p class="text-primary">Create an Event here.</p></div>
  <div id="eventpicture">
    <!-- <img src="CreatePage.png" alt="Create event"> -->
  </div>

  <div class="container">
    <form class="form" role="form" onsubmit="form_submit()" action="saveevent.php" method="post" enctype="multipart/form-data">
      <p class="text-primary">*Required input </p>
      <div class="form-horizontal">
        <div class="form-event">
          <label class="control-label col-sm-2" for="description">*Event Description:</label>
          <div class="col-sm-10">
            <input class="form-control" id= "description" type="text" name="event-description" required>
          </div>
        </div>
      </div>

      <div class="form-event">
        <label for="address">*Event Full Address:</label>
        <input class="form-control" id= "category" type="text" name="category" required>
      </div>
      <div class="form-event">
        <label for="date">*Event Date:</label>
        <input class="form-control" id="category" type="text" name="date" required>
      </div>

      <input type="hidden" name="token" value="<?= $token ?>" />

      <button id="submit" type="submit" class="btn btn-default">Submit</button>
      <br><br><br>

    </form><br/>

  </div>

  <div id="loading" style="display: none">
    <img src="loading.gif" />
    Loading ...
  </div>
  <?php
  include("footer.php");
  ?>
  <script type="text/javascript">
  "use strict";
  document.getElementById("submit").disabled = true;

  $(function () {
    $("#event-name, #description, #category").bind("change keyup",
    function () {
      if ($("#event-name").val() != "" &&
      $("#description").val() != "" &&
      $("#category").val() != ""
    ) {
      document.getElementById("submit").disabled = false;
      document.getElementById("submit").style.backgroundColor="yellow";
    }
  });
});
</script>

</body>
</html>
<script type="text/javascript">
function G(id) {
  return document.getElementById(id);
}

function form_submit(){
  document.getElementById("submit").value="Processing...";
  document.getElementById("submit").disabled = true;
}

var navigationControl = new BMap.NavigationControl({
  anchor: BMAP_ANCHOR_TOP_LEFT,
  type: BMAP_NAVIGATION_CONTROL_LARGE,
  enableGeolocation: true
});

function toggleLoadingMessage() {
  var load = document.getElementById("loading");
  if (load.style.display) {
    load.style.display = "";
  } else {
    load.style.display = "none";
  }
}

</script>
