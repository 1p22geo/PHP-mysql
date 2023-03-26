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
    $user = $res->fetch_assoc()['username'];
    if ($user != 'admin'){
        header('Location: /index.php');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/table.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hi, <?php echo $user?></h1>
        <a href="logout.php?session=<?php echo $id?>">Log out</a>
    </header>
    <section>
        <?php
        if (array_key_exists('deleted', $_GET)){
            $del = $_GET['deleted'];
            echo "<h2>User {$del} deleted succesfully</h2>";
        }
        ?>
        <h2>Users:</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>E-mail</th>
                <th>Registry date</th>
                <th>Delete user</th>
            </tr>
            <?php 
            $res = query("SELECT * FROM users ORDER BY reg_date DESC");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    $uid = $row['id'];
                    $name = $row['username'];
                    $email = $row['email'];
                    $reg = $row['reg_date'];
                    echo <<<STR
                    <tr>
                        <td>{$name}</td>
                        <td>{$email}</td>
                        <td>{$reg}</td>
                        <td><a href='deluser.php?session={$id}&user={$uid}'>Delete</a></td>
                        
                        </tr>
                    STR;
                }
            }
            ?>
        </table>
    </section>
</body>
</html>