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
    <form action="check.php" method="POST">
        <?php
        if (array_key_exists('registered', $_GET)){
            echo '<h3>Account created, you can now</h3>';
        }
        if (array_key_exists('badlogin', $_GET)){
            echo '<h3>Wrong username or password.</h3>';
        }
        ?>
        <h2>Log in to your account</h2>
        <label for="user">Username</label>
        <input type="text" id="user" name="user">
        <br>
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass">
        <br>
        <button type="submit">Submit</button>
        <a href="register.php">Or register if you don't have one.</a>
    </form>
</body>
</html>