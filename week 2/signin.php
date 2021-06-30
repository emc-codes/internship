<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sign Up</title>

        <style>
            form {
                padding: 20px;
                width: 50%;
                margin-left: auto;
                margin-right: auto;
            }

            div {
                display: block;
                padding: 10px;
            }

            label {
                padding-right: 20px;
            }

            input {
                width: 200px;
            }

            #actions {
                text-align:center;
            }
        </style>
    </head>
    <body>
    
    <form action="" method="POST">
        <fieldset>
            <legend>Sign In</legend>
            <div>
                <label for="email">Email Address:</label>
                <input id="email" name="email" placeholder="eg: johndoe@gmail.com" type="email" required minlength="12" maxlength="60">
            </div>

            <div>
                <label for="password">Password:</label>
                <input id="password" name="password" placeholder="eg: pass1234" type="password" required minlength="8" maxlength="15">
            </div>

            <div id="actions">
                <input value="Sign In" type="submit"> <span>Or</span> <a href="signup.php">Sign Up</a>
            </div>
        </fieldset>
    </form>
    
    </body>
</html>

<?php
// start session
session_start();

// sign in class 
class SignIn {
    public $email;
    public $password;

    public function __construct() {

        // redirect to index page if user is already signed in
        if (isset($_SESSION["sign_in"])) {
            header("Location: index.php");
        }

        // validate form data submitted
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $this->email = $_POST["email"];
            $this->password = $_POST["password"];

            if (!empty($this->email) && !empty($this->password)) {

                // validate minimum length values 
                if (strlen($this->email) >= 12 && strlen($this->password) >= 8) {

                    // validate maximum length values 
                    if (strlen($this->email) <= 60 && strlen($this->password) <=15) {

                        
                        // set sign_in session if email and password entered match their respective sessions and redirect to index page
                        if (isset($_SESSION[$this->email]) && isset($_SESSION["password".$this->password])) {
                            
                            // set sign in session containing users email 
                            $_SESSION["sign_in"] = $this->email;
                            echo "<h2>Sign In successful for <i>".$this->email."</i></h2>";

                            // redirect after 2 seconds upon successful sign in
                            header("refresh:2; url=index.php");
                        } else {
                            echo "<h2>Invalid Email Address or Password</h2>";
                        }

                    } else {
                        echo "<h2>Please adhere to naxlength values</h2>";
                    }

                } else {
                    echo "<h2>Please adhere to minlength values</h2>";
                }

            } else {
                echo "<h2>No field(s) can be empty!</h2>";
            }
        }
    }
}

new SignIn();

?>
