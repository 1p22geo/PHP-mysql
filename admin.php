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
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hi, <?php echo $user?></h1>
        <a href="logout.php?session=<?php echo $id?>">Log out</a>
    </header>
    <section class='actions'>
        <?php
        if (array_key_exists('submitted', $_GET)){
            echo '<h2>Document subitted succesfully</h2>';
        }
        if (array_key_exists('deleted', $_GET)){
            $del = $_GET['deleted'];
            echo "<h2>Document {$del} deleted succesfully</h2>";
        }
        ?>
        <h2>Administrative actions</h2>
        <div>
            <article>
                <a href="add.php?session=<?php echo $id?>">Add a document</a>
                <img src="img/add.png" alt='image'>
            </article>
            <article>
                <a href="users.php?session=<?php echo $id?>">Manage users</a>
                <img src="img/user.png" alt='image'>
            </article>
            <article>
                <a href="sessions.php?session=<?php echo $id?>">Manage sessions</a>
                <img src="img/laptop.png" alt='image'>
            </article>
            <article>
                <a href="upload.php?session=<?php echo $id?>">Upload files</a>
                <img src="img/file.png" alt='image'>
            </article>
        </div>
    </section>
    <a href="dir.php?session=<?php echo $id?>" class='link'>Download files</a>

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
                        <div class='title-wrapper'>
                        <h2>{$title}</h2>
                        <a href=del_doc.php?session={$id}&doc={$docid}>X</a>
                        </div>
                        <h4>id:{$docid}</h4>
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
    <script>
        //setInterval(()=>{window.location.reload()}, 1000)
    </script>
</body>
</html>
<!--
<a href="https://www.flaticon.com/free-icons/add" title="add icons">Add icons created by Kiranshastry - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/session" title="session icons">Session icons created by xnimrodx - Flaticon</a>