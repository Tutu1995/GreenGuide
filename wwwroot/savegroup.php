<?php
include("db.php");
ensure_logged_in();

$groupname=htmlspecialchars($_POST["groupname"]);
$groupdescription=htmlspecialchars($_POST["group-description"]);
$category=htmlspecialchars($_POST["category"]);

$buysell=htmlspecialchars(pType("Water", $_POST["water"]));
$social=htmlspecialchars(pType("Social", $_POST["social"]));
$art=htmlspecialchars(pType("Art", $_POST["art"]));
$environment=htmlspecialchars(pType("Environment", $_POST["environment"]));
$other=htmlspecialchars(pType("Other",$_POST["other"]));
$other_item=htmlspecialchars($_POST["other_item"]);

function pType ($p_name, $p_type){
  if  (isset($p_type))
  {
    return $p_name;
  }
  else{
    return $p_type;
  }
}

if  (isset($other_item))
{
  $other=$other_item;
}

try{
  $s_name=$_SESSION["name"];
  $result=$db->prepare("insert into meetup_groups (name, description, owner_email, category, buysell, social, art, environment, other) values(:name, :description, :owner_email, :category, :buysell, :social, :art, :environment, :other)");
  $result->bindParam(':name', $groupname);
  $result->bindParam(':description', $groupdescription);
  $result->bindParam(':owner_email', $s_name);
  $result->bindParam(':category', $category);

  $result->bindParam(':buysell', $buysell);
  $result->bindParam(':social', $social);
  $result->bindParam(':art', $art);
  $result->bindParam(':environment', $environment);
  $result->bindParam(':other', $other);

  $result->execute();
  $last_id = $db->lastInsertId();

  header("Location: mygroups.php");
  exit;

}
catch(Exception $e){
  echo $e->getMessage();
  die("Sorry, error occured. Please try again.");
}
?>
