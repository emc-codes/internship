<?php
// Sidehustle Internship Week 2 (Two) Web Design and Development(Backend) task by Enwerem Melvin Confidence

// start session
session_start();

// login validation class
class signin_check {
    public $current_user;

    public function __construct() {
        // check if user is signed in, else redirect to sign in page
        if (isset($_SESSION["sign_in"]) && !empty($_SESSION["sign_in"])) {
            $this->current_user = $_SESSION["sign_in"];
        } else {
            header("Location: signin.php");
        }

        // sign user out and redirect to sign in page 
        if (isset($_POST["signout"])) {
            unset($_SESSION["sign_in"]);
            header("Location: signin.php");
        }

        // message upon successful sign in and sign out button
        if (isset($this->current_user) && !empty($this->current_user)) {
?>
        <h1>Current User: <?php echo "<em>".$this->current_user."</em>"?></h1>
        
        <form action="" method="POST">
            <input type="hidden" name="signout">
            <input type="submit" value="Sign Out">
        </form>
<?php
        } else {
            header("Location: signin.php");
        }
    }
}

// instantiate class 
new signin_check();

?>
