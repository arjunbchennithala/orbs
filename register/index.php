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

    <?php 
        if (isset($_GET['status'])) {
            if($_GET['status']=='failed'){
                echo "<p>Failed to register</p>";
            }
        } 
    ?>

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
                <form method="post" onsubmit="return validateCustomerForm()" enctype="multipart/form-data">
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
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="state" name="state" placeholder="State">
                    </div>
                    <div class="form-group">
                        <label for="security-question">Security question for account recovery </label>
                        <input type="text" class="form-control" id="security-question" name="question" placeholder="Your security question">
                    </div>
                    <div class="form-group">
                        <label for="security-answer">Security answer for account recovery </label>
                        <input type="text" class="form-control" id="security-answer" name="answer" placeholder="Your security answer">
                    </div>
                    <div class="form-group">
                        <label for="prphoto">Photo</label>
                        <input type="file" class="form-control" id="prphoto" name="photo" placeholder="Photo">
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
                <form method="post" onsubmit="return validateRestaurantForm()" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label for="security-question-rest">Security question for account recovery </label>
                        <input type="text" class="form-control" id="security-question-rest" name="question" placeholder="Your security question">
                    </div>
                    <div class="form-group">
                        <label for="security-answer-rest">Security answer for account recovery </label>
                        <input type="text" class="form-control" id="security-answer-rest" name="answer" placeholder="Your security answer">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo">
                    </div>
                    <br>
                    <input type="hidden" name="account-type" value="restaurant">
                    <button type="submit" class="btn btn-primary" name="submit-button">Register</button>
                    <hr>
                </form>
            </div>
        </div>
</div>
    
<?php
}
else{
    if($_POST['account-type'] == 'customer') {
        $file_name = time().$_FILES['photo']['name'];
        $folder = "../uploads/photos/customer/profile/$file_name";
        if(!move_uploaded_file($_FILES['photo']['tmp_name'], $folder))
            goto ex;
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = hash('md5', $_POST['password']);
        $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $question = mysqli_real_escape_string($conn, strtolower($_POST['question']));
        $answer = hash('md5', strtolower($_POST['answer']));
        $date = date('y-m-d');
        $query = "insert into customer(profile_photo, name, dob, email, password, mobile_number, state, created, question, answer)";
        $query .= " values('$file_name', '$name', '$dob', '$email', '$password', '$mobile_number', '$state', '$date', '$question', '$answer')";
       
    } else if($_POST['account-type'] == 'restaurant') {
        $file_name = time().$_FILES['photo']['name'];
        $folder = "../uploads/photos/restaurant/profile/$file_name";
        if(!move_uploaded_file($_FILES['photo']['tmp_name'], $folder))
            goto ex;
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $location_link = mysqli_real_escape_string($conn, $_POST['location_link']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
        $password = hash('md5', $_POST['password']);
        $question = mysqli_real_escape_string($conn, strtolower($_POST['question']));
        $answer = hash('md5', strtolower($_POST['answer']));
        $date = date('y-m-d');

        $query = "insert into restaurant(photo, name, address, location_link, email, phon_no, password, created, question, answer)";
        $query .= " values('$file_name', '$name', '$address', '$location_link', '$email', '$phone_no', '$password', '$date', '$question', '$answer')";
        
    }
    $res = mysqli_query($conn, $query);
ex:
    if($res) {
        header("Location: /orbs/login?status=success");
        
    }else {
        header("Location: /orbs/register?status=failed");
        
    }
}
include('../lib/footer.php');
mysqli_close($conn);
?>