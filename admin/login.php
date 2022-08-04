<?php
if(isset($_SESSION['account-type'])) {
    if($_SESSION['account-type']=='admin')
        include('dashboard.php');
    else {
echo "Hello World";
/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-login</title>
</head>
<body>
    
</body>
</html>
*/

    }
}
?>