<?php
    include("../lib/header.php");
?>
        <title>Reset</title>
    </head>
    <body>
        <div class="div-center">
        <div class="content" style="display:block; margin-left:auto;">
                <h3>Reset Password</h3>
                <hr>
                <form method="post" action="verify.php">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="username" placeholder="Email" required>
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
    
<?php

include("../lib/footer.php");

?>