<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/21/2018
 * Time: 9:21 PM
 */

include_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $view = $_POST['viewType'];
    if($view == 'icon_view'){
        $_SESSION['result_view_type'] = 'icon_view';
        $_SESSION['result_limit'] = 32;
    } else {
        $_SESSION['result_view_type'] = 'list_view';
        $_SESSION['result_limit'] = 10;
    }
}

return print_r(json_encode(array('result'=>'success')));
