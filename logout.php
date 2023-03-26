<?php

$servername = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password, "test");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
function query($q){
    global $conn;
    $res = $conn->query($q);
    if(!(!!$res === TRUE)){
        die('Query failed');
    }
    else{
        return $res;
    }
}
if (!array_key_exists('session', $_GET)){
    header('Location: /index.php');
    die();
}
$id = $_GET['session'];
$res = query("SELECT * FROM loginsessions WHERE id='{$id}' AND expired IS NOT TRUE ORDER BY id DESC");
if($res->num_rows <1){
    header('Location: /index.php');
    die();
}
else{
    
    query("UPDATE loginsessions SET expired=TRUE WHERE id='{$id}'");
    header('Location: /index.php');
}
?>