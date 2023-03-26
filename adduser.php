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
        return $res;

    }
    $user = $_POST['user'];
    $email = $_POST['email'];
    $md5 = md5($_POST['pass']);
    if($_POST['pass'] != $_POST['rpass']){
        header('Location: /register.php');
        die();
    }
    $result = query("SELECT * FROM users WHERE username='{$user}'");

    if($result->num_rows > 0){
        header('Location: /register.php?exists=true');
        die();
    }
    else{
        query("INSERT INTO users(username, email, md5) VALUES ('{$user}', '{$email}', '{$md5}')");
        header('Location: /index.php?registered=true');
    }
?>