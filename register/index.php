<?php
include('../db/connect.php');
include('../lib/header.php');
if(isset($_SESSION['userid'])){
    header("Location: /orbs");
}
else if(!isset($_POST['submit-button'])) {

?>
    <link rel="stylesheet" href="../stylesheet/main.css">
    <script src="/orbs/script/registration.js"></script>
    <title>Register</title>
</head>
<body>
<div class="container-fluid" style="padding:0%">
<nav class="navbar navbar-expand-sm sticky-top bg-warning navbar-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">ORBS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../login" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="div-center" id="account-selection" style="height: 100px;">
        <label for="selection">Select type of the account</label>
        <select class="form-select" id="selection" name="account-type" onchange="account_change()">
            <option value="">--Select type of account to continue--</option>               
            <option value="customer">customer</option>
            <option value="restaurant">restaurant</option>
        </select>
    </div>
        <div class="div-center" id="customer" style="display : none">
            <div class="content">
                <h3>Customer registration</h3>
                <hr>
                <form method="post" onsubmit="return validateCustomerForm()">
                    <div class ="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="text" name="name" placeholder="Full name">
                    </div>
                    <div class="form-group">
                        <label for="dob">Dob</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Create Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div> 
                    
                    <div class="form-group">
                        <label for="password2">Repeat Password</label>
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" name="mobile_number" placeholder="Mob No">
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="state" name="state" placeholder="State">
                    </div>
                    <br>
                    <input type="hidden" name="account-type" value="customer">
                    <button type="submit" class="btn btn-primary" name="submit-button">Register</button>
                    <hr>
                </form>
            </div>
        </div>

        <div class="div-center" id="restaurant" style="display : none">
            <div class="content">
                <h3>Restaurant registration</h3>
                <hr>
                <form method="post" onsubmit="return validateRestaurantForm()">
                    <div class ="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="text" name="name" placeholder="Full name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Create Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div> 
                    
                    <div class="form-group">
                        <label for="password2">Repeat Password</label>
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" name="phone_no" placeholder="Mob No">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="location_link">Location link</label>
                        <input type="text" class="form-control" id="location_link" name="location_link" placeholder="Location link">
                    </div>
                    <br>
                    <input type="hidden" name="account-type" value="restaurant">
                    <button type="submit" class="btn btn-primary" name="submit-button">Register</button>
                    <hr>
                </form>
            </div>
        </div>
</div>
    

<!--
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
mysqli_close($conn);
?>