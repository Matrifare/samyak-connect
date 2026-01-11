<?php
include_once '../DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();

if ($_SESSION['gender123']) {
    if ($_SESSION['gender123'] == 'Groom') {
        $gender = "and gender='Bride'";
    } else {
        $gender = "and gender='Groom'";
    }
}
$matri_id = $_SESSION['user_id'];
// Counting all the online visitors:
list($totalOnline) = mysqli_fetch_array(mysqli_query($DatabaseCo->dbLink, "SELECT COUNT(*) FROM online_users where
 matri_id!='" . $matri_id . "' $gender and matri_id NOT IN (SELECT DISTINCT(block_to) from block_profile 
 where block_by = '".$matri_id."') AND matri_id NOT IN (SELECT DISTINCT(block_by) from block_profile where
  block_to = '".$matri_id."')"));

// Outputting the number as plain text:
echo $totalOnline;


// Removing entries not updated in the last 24 minutes:
mysqli_query($DatabaseCo->dbLink, "DELETE FROM online_users WHERE dt<SUBTIME(NOW(),'0 0:24:0')");


?>