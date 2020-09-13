<?php
#if($_SESSION['dbconnect'] != 'OK') {
    $db_user = "baza";
    $db_password = "123";
    $db_name = "localhost/baza";
    $db_coding = "UTF8";
try {
    $conn = oci_connect($db_user, $db_password);
    $cursor = oci_new_cursor($conn);
    $_SESSION['dbconnect'] = 'OK';
}catch (Exception $e){
        $_SESSION['dbconnect'] = 'BAD, very BAD';
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
#}
?>