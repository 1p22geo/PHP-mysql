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
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hi, <?php echo $user?></h1>
        <a href="logout.php?session=<?php echo $id?>">Log out</a>
    </header>
    <form action="addoc.php" class="wide" method="POST" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
        <h2>Create a new document</h2>
        <?php
        if (array_key_exists('exists', $_GET)){
            echo '<h3>Username already taken.</h3>';
        }
        ?>
        <label for="title">Title</label>
        <input type="text" id="title" name="title">
        <br>
        <label for="desc">Description</label>
        <textarea id='desc' name="desc" cols='100' rows='10'></textarea>
        <br>
        <label for="content">Content</label>
        <textarea id='content' name="content" cols='100' rows='30'></textarea>
        <br>
        <input name='session' hidden value='<?php echo $id?>'>
        <button type="submit">Submit</button>
    </form>
</body>
</html>