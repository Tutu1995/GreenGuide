<?php

include("db.php");
ensure_logged_in();

$token = md5(uniqid(rand(), true));
$_SESSION["token"] = $token;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Create Your Group Here</title>

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
#grouppicture img {
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

  <div class="container text-center"><p class="text-primary">Create A Group here.</p></div>
  <div id="grouppicture">
    <img src="CreatePage.png" alt="Create Group">
  </div>

  <div class="container">
    <form class="form" role="form" onsubmit="form_submit()" action="savegroup.php" method="post" enctype="multipart/form-data">
      <p class="text-primary">*Required input </p>
      <div class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-sm-2" for="group-name">*Group Name:</label>
          <div class="col-sm-10">
            <input class="form-control" id= "group-name" type="text" name="groupname" required>
          </div>
          <label class="control-label col-sm-2" for="description">*Group Description:</label>
          <div class="col-sm-10">
            <input class="form-control" id= "description" type="text" name="group-description" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="category">*Group Category:</label>
        <input class="form-control" id= "category" type="text" name="category" placeholder="ex. Buy-sell, Dance, Politics" required>
      </div>

      <div class="form-group">
        <label for="p_type">What is this group about </label>
        <label class="checkbox-inline">
          <input type="checkbox" name="buysell" id="cb1">Buy-sell
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" name="social" id="cb2">Social
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" name="art" id="cb3">Art
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" name="environment" id="cb4">Environmental
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" name="other" id="cb5">Others
        </label>
        <label class="checkbox-inline">
          <input id="other_item" class="form-control" type="text" name="other_item" placeholder="Others" size="20" />
        </label>
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
    $("#grup-name, #description, #category, #cb1, #cb2, #cb3, #cb4, #cb5, #other_item").bind("change keyup",
    function () {
      if ($("#grup-name").val() != "" &&
      $("#description").val() != "" &&
      $("#category").val() != ""
    ) {
      document.getElementById("submit").disabled = false;
      document.getElementById("submit").style.backgroundColor="red";
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
