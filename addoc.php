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
if (!array_key_exists('session', $_POST)){
    header('Location: /index.php');
    die();
}
$id = $_POST['session'];
$res = query("SELECT * FROM loginsessions WHERE id='{$id}' AND expired IS NOT TRUE ORDER BY id DESC");
if($res->num_rows <1){
    header('Location: /index.php');
    die();
}
else{
    $user = $res->fetch_assoc()['username'];
    if ($user != 'admin'){
        header('Location: /index.php');
        die();
    }
    else{
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $content = $_POST['content'];
        query("INSERT INTO documents(title, doc_description, content) VALUES('{$title}', '{$desc}', '{$content}')");
        header("Location: /admin.php?session={$id}&submitted=true");
        die();
    }
}
?>