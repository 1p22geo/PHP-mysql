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
}
$doc = $_GET['doc'];
$res = query("SELECT * FROM documents WHERE id={$doc}");
if($res->num_rows < 0){
    if ($user == 'admin'){
        header("Location: /admin.php?session={$id}");
    }
    else{
        header("Location: /user.php?session={$id}");
    }
    die();
}
$row = $res->fetch_assoc();
$docid = $row['id'];
$title = $row['title'];
$date = $row['submitted'];
$desc = $row['doc_description'];
$content = $row['content'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/doc.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hi, <?php echo $user?></h1>
        <a href="logout.php?session=<?php echo $id?>">Log out</a>
    </header>
    <section class="doc">
        <?php
        echo <<<STR
        <div>
            <h1>{$title}</h1>
            <h2>{$date}</h2>
            
            <h4>
                Document ID {$docid}
            </h4>
            <h3>
                {$desc}
            </h3>
            <p>
                {$content}
            </p>
        </div>
        STR;
        ?>
    </section>
</body>
</html>