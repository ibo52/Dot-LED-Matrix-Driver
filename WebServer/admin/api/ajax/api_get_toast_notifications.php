<?php
//ajax api: session_start çağırılmalı
session_start();

if (isset($_SESSION["session-toast-logs"]) ){

    echo json_encode($_SESSION['session-toast-logs']);
    unset($_SESSION['session-toast']);

}else{

    echo json_encode(array());//empty array
}
?>