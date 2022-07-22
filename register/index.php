<?php
include('../db/connect.php');
include('../lib/header.php');

if(!isset($_POST['submit-button'])) {
?>
    <title>Register</title>
</head>
<body>
    Registration page <br>
    <form method="post">
        <input type="text" name="username" placeholder="Username"> <br>
        <input type="text" name="password" placeholder="Password"> <br>
        <input type="hidden" value="customer" name="account-type">
        <input type="submit" name="submit-button" value="Register">
    </form>
<?php
}
else{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $query = "insert into customer(name, email, dob, password, mobile_number, country, state, created) values('" . $username . "', '" . $username;
?>
    Login with the provided credentials :
    <a href="../login">Login</a>
<?php
}
include('../lib/footer.php');
?>