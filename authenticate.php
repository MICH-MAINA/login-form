<?php
//starts the session which allows us to preserve account details on the server and will be 
//be used later on to remember logged-in user
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER =  'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    //if there is an error with connection, stop the script and display the error message below
    exit('Failed to connect to MySQL: '.mysqli_connect_error()) ;
}

//to check if the data from the login form was submitted
//isset() will check if the data exists
if (!isset($_POST['username'], $_POST['password'])) {
    //could not get the data that should have been sent
    exit('Please fill both the username and password fields!');
}
//preparing the sql so as to prevent sql injection
if($stmt = $con-> prepare('SELECT id, password FROM accounts WHERE username= ?')){
    //bind parameters(s =string, i= int, b= blob, etc), in our case the username is a string so we use the s
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    //store the result so we can check if the account exests in the database.
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        //accounts exists, now we verify the password
        //NOTE: USE PASSWORD HASH IN THE REGISTRATION FILE TO STORE THE HASHED PASSWORDS
        if($_POST['password'] === $password){
            //verification success! User has logged in!
            //create sessions, so we know the user has logged in, the remember the data on the server
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id' ]= $id;
            header('Location: homepage.php');
        } else{
            //if the password is incorrect
            echo 'Incorrect password!';
        }
    }else {
        //incorrect username
        echo ' Incorrect username!';
    }

    $stmt-> close();
}
?>