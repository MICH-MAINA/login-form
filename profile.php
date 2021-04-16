<?php 

//starting session
session_start();
//if the user is not logged in redirect to the login page...
if(!isset($_SESSION['loggedin'])){
    header('location: index.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phpLogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('failed to connect to MYSQL: '. mysqli_connect_errno());
}

//we dnt have the password or email info stored in sessions so instead we can
//get the results from the database

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id= ?');

//in this case we can use the account id to get the account info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/69f49bfefb.js" crossorigin="anonymous"></script>
</head>
<body class="loggedin">
    <nav class="navtop">
        <div class="controls">
            <h1>Website Title</h1>
            <a href="profile.php"><i class="fas fa-user-circle">Profile</i></a>
            <a href="logout.php"><i class="fas fa-sign-out-alt">Logout</i></a>
        </div>
    </nav>

    <div class="content">
        <h2>Profile Page</h2>
        <div>
            <p>Your account details are below: </p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td><?=$_SESSION['name']?></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><?=$password?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?=$email?></td>
                </tr>
            </table>
        </div>
    </div>
    
    
</body>
</html>