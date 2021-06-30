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

            #submit-btn {
                text-align: center;
            }
        </style>
    </head>
    <body>

    <form action="" method="POST">
        <fieldset>
            <legend>Sign Up</legend>
            <div>
                <label for="email">Email Address:</label>
                <input id="email" name="email" placeholder="eg: johndoe@gmail.com" type="email" required minlength="12" maxlength="60">
            </div>

            <div>
                <label for="password">Password:</label>
                <input id="password" name="password" placeholder="eg: pass1234" type="password" required minlength="8" maxlength="15">
            </div>

            <div>
                <label for="conf_password">Confirm Password:</label>
                <input id="conf_password" name="conf_password" placeholder="eg: pass1234" type="password" required minlength="8" maxlength="15">
            </div>

            <div id="submit-btn">
                <input value="Sign Up" type="submit"> <span>Or</span> <a href="signin.php">Sign In<a>
            </div>
        </fieldset>
    </form>

    </body>
</html>

<?php
// start session
session_start();

// sign up class
class SignUp {
    private $email;
    private $password;
    private $conf_password;

    public function __construct() {

        // validate submitted form data
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["conf_password"])) {
            $this->email = $_POST["email"];
            $this->password = $_POST["password"];
            $this->conf_password = $_POST["conf_password"];

            if (!empty($this->email) && !empty($this->password) && !empty($this->conf_password)) {

                // validate minimum length values 
                if (strlen($this->email) >= 12 && strlen($this->password) >= 8 && strlen($this->conf_password) >= 8) {

                    // validate maximum length values 
                    if (strlen($this->email) <= 60 && strlen($this->password) <=15 && strlen($this->conf_password) <=15) {

                        if ($this->password === $this->conf_password) {

                            // check if user exists and return an error if so
                            if (isset($_SESSION[$this->email])) {
                                echo "<h2>".$this->email." already exists</h2>";
                            } else {

                                // set sessions for new user (session email and password equals users email and password thereby making it possible for multiple users to exist on same device)
                                $_SESSION[$this->email] = $this->email;
                                $_SESSION["password".$this->password] = $this->password;

                                // signup confirmation message and redirect to sign in page after 2 seconds
                                echo "<h2> User".$this->email." signed up successfully</h2>";
                                header("refresh:2; url=signin.php");
                            }

                        } else {
                            echo "<h2>Passwords don't match!</h2>";
                        }

                    } else {
                        echo "<h2>Please adhere to maxlength values</h2>";
                    }

                } else {
                    echo "<h2>Please adhere to minlength values</h2>";
                }
            } else {
                echo "<h2>Field(s) cannot be empty</h2>";
            }
        }
        
    }
}

new SignUp();

?>
