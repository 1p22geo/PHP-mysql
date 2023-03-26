<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="adduser.php" method="POST">
        <h2>Create a new account</h2>
        <?php
        if (array_key_exists('exists', $_GET)){
            echo '<h3>Username already taken.</h3>';
        }
        ?>
        <label for="user">Username</label>
        <input type="text" id="user" name="user">
        <br>
        <label for="email">E-mail</label>
        <input type="text" id="email" name="email">
        <br>
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass">
        <br>
        <label for="rpass">Repeat password</label>
        <input type="password" id="rpass" name="rpass">
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>