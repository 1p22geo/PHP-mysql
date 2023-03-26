<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      

    function query($q){
        global $conn;
        if(!($conn->query($q) === TRUE)){
            die('Query failed');
        }
    }
    query("CREATE DATABASE test");
    $conn = new mysqli($servername, $username, $password, "test");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    query("CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(45) NOT NULL,
    email VARCHAR(60) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    md5 VARCHAR(60) NOT NULL)
    ");
    $name = "admin";
    $email = "realadmin@realmail.com";
    $md5 = md5("qwertyuiop");
    query("INSERT INTO users(username, email, md5) VALUES ('{$name}', '{$email}', '{$md5}')");

    query("CREATE TABLE loginsessions(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(45) NOT NULL,
        start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expired BOOLEAN
        )
    ");
    query("CREATE TABLE documents(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        title VARCHAR(45) NOT NULL,
        doc_description TEXT NOT NULL,
        content TEXT
        )
    ");
    ?>
    <h1>Database created. You can proceed by logging in to admin</h1>
</body>
</html>