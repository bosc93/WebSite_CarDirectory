<?php
$host = "localhost"; /* Host name */
$port = "81"; /* Port */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "cardirectory"; /* Database name */

$con = mysqli_connect($host, $port, $user, $password, $dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}