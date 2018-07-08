<?php
include "config.php";

$condition = "1";
if(isset($_GET['idConcession'])){
   $condition = " id=".$_GET['idConcession'];
}
$concessionData = mysqli_query($con,"select latitude, longitude from concession WHERE ".$condition);

$response = array();

while($row = mysqli_fetch_assoc($concessionData)){

   $response[] = $row;
}

echo json_encode($response);
exit;
?>