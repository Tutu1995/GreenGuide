<?php
include("db.php");
ensure_logged_in();

$ownerPageId = $_SESSION['createeventpageid'];
$location_lat = 'test_location_lat';
$location_long = 'test_location_long';
$event_summary = htmlspecialchars($_POST['description']);
$event_address = htmlspecialchars($_POST['address']);
$event_data = htmlspecialchars($_POST['date']);

try{
  $s_name=$_SESSION["name"];
  $result=$db->prepare("insert into meetup_events (owner_page_id, location_lat, location_long, event_summary, event_address, event_data) values(:owner_page_id, :location_lat, :location_long, :event_summary, :event_address, :event_data)");
  $result->bindParam(':owner_page_id', $ownerPageId);
  $result->bindParam(':location_lat', $location_lat);
  $result->bindParam(':location_long', $location_long);
  $result->bindParam(':event_summary', $event_summary);
  $result->bindParam(':event_address', $event_address);
  $result->bindParam(':event_data', $event_data);

  $result->execute();
  $last_id = $db->lastInsertId();
}
catch(Exception $e){
  echo $e->getMessage();
  die("Sorry, error occured. Please try again.");
}
?>
