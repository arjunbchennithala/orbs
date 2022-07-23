<?php
include('../db/connect.php');
include('../lib/header.php');
if(isset($_SESSION['userid'])){
    header("Location: /orbs");
}
else if(!isset($_POST['submit-button'])) {
?>
    <script src="/orbs/script/registration.js"></script>
    <title>Register</title>
</head>
<body>
    Registration page <br>
<!---
    Customer registration
    <form method="post" onsubmit="return validateCustomerForm()">
        <input type="text" name="name" placeholder="Full name" required> <br>
        DOB : <input type="date" name="dob" required> <br>
        <input type="email" name="email" placeholder="email"  required> <br>
        <input type="password" name="password" placeholder="Password" required > <br>
        <input type="password" name="password2" placeholder="Repeat password" required> <br>
        <input type="number" name="mobile_number" placeholder="Mob Num" required > <br>
        <input type="text" name="country" placeholder="Country"  required> <br>
        <input type="text" name="state" placeholder="state" required > <br>
        <input type="hidden" name="account-type" value="customer"> <br>
        <input type="submit" value="Signup" name="submit-button">
    </form>

    <br><br><br><br>
    Restaurant registration
    <form method="post" onsubmit="return validateRestaurantForm()">
        <input type="text" name="name" placeholder="Name" required> <br>
        <input type="email" name="email" placeholder="Email id"  required> <br>
        <input type="password" name="password" placeholder="Password" required > <br>
        <input type="password" name="password2" placeholder="Repeat password" required> <br>
        <input type="number" name="phone_no" placeholder="Mob Num" required > <br>
        <input type="text" name="address" placeholder="address"  required> <br>
        <input type="text" name="location_link" placeholder="location link" required > <br>
        <input type="hidden" name="account-type" value="restaurant"> <br>
        <input type="submit" value="Signup" name="submit-button">
    </form>
-->
<?php
}
else{
    if($_POST['account-type'] == 'customer') {

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = hash('md5', $_POST['password']);
        //$password = mysqli_real_escape_string($conn, $_POST['password']);
        $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $date = date('y-m-d');
        $query = "insert into customer(name, dob, email, password, mobile_number, country, state, created)";
        $query .= " values('$name', '$dob', '$email', '$password', '$mobile_number', '$country', '$state', '$date')";
        echo $query;
    } else if($_POST['account-type'] == 'restaurant') {

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $location_link = mysqli_real_escape_string($conn, $_POST['location_link']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
        $password = hash('md5', $_POST['password']);
        //$password = mysqli_real_escape_string($conn, $_POST['password']);
        $date = date('y-m-d');

        $query = "insert into restaurant(name, address, location_link, email, phon_no, password, created)";
        $query .= " values('$name', '$address', '$location_link', '$email', '$phone_no', '$password', '$date')";
        echo $query;
    }
    $res = mysqli_query($conn, $query);
    if($res) {
        //echo "Success";
        header("Location: /orbs/login");
    }else {
        //echo "Failed";
        header("Location: /orbs/register");
    }
}
include('../lib/footer.php');
?>