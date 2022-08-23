<?php
include("../lib/header.php");
include("../db/connect.php");
if(!isset($_POST['submit2-button'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']) ;
    $type = mysqli_real_escape_string($conn, $_POST['account-type']) ;
    $query = "select question from $type where email='$email'";
    $res = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Verify</title>
    </head>
    <body>
    <form method="post">
                    <div class="form-group">
                        <label for="question">Security question</label>
                    <input type="text" class="form-control" id="question" name="question" value="<?php echo $res['question'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="answer">Security answer</label>
                        <input type="text" class="form-control" id="answer" name="answer" placeholder="Answer" required>
                    </div>
                    <br>
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="account-type" value="<?php echo $type; ?>">
                    <button type="submit" class="btn btn-primary" name="submit2-button">Enter</button>
                    <hr>
                    <a href="../register">Signup</a>
                </form>
    </body>
</html>

<?php
}else{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $answer = hash('md5', strtolower($_POST['answer']));
    $query = "select * from $type where email='$email' AND answer='$answer'";
    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res)>0) {
?>
    <!DOCTYPE html>
<html>
    <head>
        <title>Verify</title>
    </head>
    <body>
    <form method="post">
                    <div class="form-group">
                        <label for="newpass">New Password</label>
                    <input type="password" class="form-control" id="newpass" name="newpass" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="confpass">Confirm password</label>
                        <input type="password" class="form-control" id="confpass" name="confpass" placeholder="Confirm password" required>
                    </div>
                    <br>
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="account-type" value="<?php echo $type; ?>">
                    <button type="submit" class="btn btn-primary" name="submit3-button">Enter</button>
                    <hr>
                    <a href="../register">Signup</a>
                </form>
    </body>
</html>
<?php
    }
}

include("../lib/footer.php");
?>