<?php
include('../db/connect.php');
include('../lib/header.php');

if(!isset($_POST['submit-button'])) {
?>
    <title>Register</title>
</head>
<body>
    Registration page
<?php
}
else{
?>
    Login with the provided credentials :
    <a href="../login">Login</a>
<?php
}
include('../lib/footer.php');
?>