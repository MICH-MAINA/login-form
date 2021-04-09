<?php 
// the home page is the first page the user see when they have logged in
//page can only be accessed if user has loged in else they are redirected to the login page

session_start();
//if the user is not logged in redirect to the login page..
if(!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
//$_SESSION['loggedin'] explained in authenticate file

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/69f49bfefb.js" crossorigin="anonymous"></script>
</head>
<body class="loggedin">   
        <nav class="navtop">
            <div>
                <h1>Website Title</h1>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
        <div class="content">
            <h2>Home Page</h2>
            <p>Welcome back, <?=$_SESSION['name']?>!</p>
        </div>
</body>
</html>
<!--didnt need to connect to database because we used the session data ->