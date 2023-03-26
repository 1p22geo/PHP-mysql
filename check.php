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
    $user = $_POST['user'];
    $md5 = md5($_POST['pass']);
    $result = query("SELECT * FROM users WHERE username='{$user}' AND md5='{$md5}'");

    if($result->num_rows > 0){
        query("INSERT INTO loginsessions(username, expired) VALUES('{$user}', FALSE)");
        $res = query("SELECT * FROM loginsessions WHERE username='{$user}' AND expired IS NOT TRUE ORDER BY id DESC");
        $row = $res ->fetch_assoc();
        $id = $row['id'];
        if($user=="admin"){
            header("Location: /admin.php?session={$id}");
        }
        else{
            header("Location: /user.php?session={$id}");
        }
    }
    else{
        header('Location: /index.php?badlogin=true');
    }
?>