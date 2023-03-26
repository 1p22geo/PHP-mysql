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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hi, <?php echo $user?></h1>
        <a href="logout.php?session=<?php echo $id?>">Log out</a>
    </header>
    <section>
        <h2>Documents today:</h2>
        <div>
        <?php
            $res = query("SELECT * FROM documents ORDER BY submitted DESC");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    $docid = $row['id'];
                    $title = $row['title'];
                    $date = $row['submitted'];
                    $desc = $row['doc_description'];
                    echo <<<STR
                    <article>
                        <h2>{$title}</h2>
                        <h3>{$date}</h3>
                        
                        <p>
                            {$desc}
                        </p>
                        <a href=doc.php?doc={$docid}&session={$id}>Continue reading</a>
                    </article>
                    STR;
                }
            }
            ?>
        </div>
    </section>
</body>
</html>