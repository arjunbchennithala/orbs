<?php
    session_start();
    include("../lib/header.php");
    $email = '';
    $question = '';
    $answer = '';
    if(!isset($_POST['submit-button'])) {
?>
        <title>Reset</title>
    </head>
    <body>
        <div class="div-center">
        <div class="content" style="display:block; margin-left:auto;">
                <h3>Reset Password</h3>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="username" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="question">Your security question</label>
                        <input type="text" class="form-control" id="question" name="question" placeholder="Question" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="answer">Your security answer</label>
                        <input type="text" class="form-control" id="answer" name="answer" placeholder="Answer" required>
                    </div>
                    <div class="form-group">
                        <label for="selection">Select type of the account</label>
                        <select class="form-select" id="selection" name="account-type" aria-label="Default select example">
                            <option value="customer">customer</option>
                            <option value="restaurant">restaurant</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit-button">Enter</button>
                    <hr>
                    <a href="../register">Signup</a>
                </form>
            </div>
        </div>
        <script>
            $('#email').keyup(function(){
                var account_type = $('#selection').val();
                var email = $('#email').val();
                $.ajax({url:"/orbs/accounts.php?type=fetch&user-type="+account_type+"&email="+email, complete:function(data){
                    if(data.response != 204 ) {
                        $('#question').val(data.responseJSON.question);
                    }
                }});
            });
        </script>
<?php
    }else{
        $email = $_POST['username'];
        $answer = $_POST['answer'];
        $account_type = $_POST['account-type'];
?>
    <title>Reset</title>
    </head>
    <body>
        <div class="div-center">
        <div class="content" style="display:block; margin-left:auto;">
                <h3>Reset Password</h3>
                <hr>
                <form method="post" action="verify.php" onsubmit="return validate()">
                    <div class="form-group">
                        <label for="newpass">New Password</label>
                        <input type="text" class="form-control" id="newpass" name="newpass" placeholder="New Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confpass">Confirm Password</label>
                        <input type="text" class="form-control" id="confpass" name="confpass" placeholder="Confirm Password" required>
                    </div>
                    <br>
                    <input type="hidden" name="email" value="<?php echo $email ?>">
                    <input type="hidden" name="answer" value="<?php echo $answer ?>">
                    <input type="hidden" name="account-type" value="<?php echo $account_type ?>">
                    <button type="submit" class="btn btn-primary" name="submit-button">Reset</button>
                    <hr>
                    <a href="../register">Signup</a>
                </form>
            </div>
        </div>
        <script>
            function validate() {
                if($('#newpass').val() != $('#confpass').val()) {
                    alert("Passwords doesn't match");
                    $('#newpass').val('');
                    $('#confpass').val('');
                    return false;
                }else{
                    return true;
                }
            }
        </script>
<?php
    }
include("../lib/footer.php");

?>