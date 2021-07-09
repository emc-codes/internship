<?php
// include database connection file
require_once("db_connect.php");

// turn off error reporting
error_reporting(0);

// edit task class
class edit_task extends db_connect{
    public $text;
    public $message; 

    public $edit_task; 
    private $edit_query;
    private $run_edit_query;

    public function __construct() {
        // call parent construct function
        parent::__construct("localhost", "root", "", "to_do_list");

        // call parent connect function
        parent::connect();

        // sql injection guard
        if (isset($_GET["edit_task"])) {        
            $this->edit_task = mysqli_real_escape_string($this->connect, trim($_GET["edit_task"]));
        }

        if (isset($this->edit_task)) {
            $query = "SELECT * FROM tasks WHERE id='" . $this->edit_task . "'";
            $run_query = mysqli_query($this->connect, $query);

            while ($result = mysqli_fetch_assoc($run_query)) {
                $this->text = $result["tasks"];
            }
        }
        
    }

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["task"]) && isset(($_POST["id"]))) {
                if (!empty($_POST["task"]) && !empty($_POST["id"])) {

                    if (strlen($_POST["task"]) >= 5 && strlen($_POST["task"]) <= 1000) {

                        $this->edit_query = "UPDATE tasks SET tasks='". $_POST["task"] ."' WHERE id='". $_POST["id"] ."'";
                        $this->run_edit_query = mysqli_query($this->connect, $this->edit_query);

                        if ($this->run_edit_query) {
                            $this->message = "Task edited successfully!";
                            header("refresh:2; url=index.php");
                        } else {
                            $this->message = "Error encountered while updating task: ".mysqli_error($this->connect);
                        }
                    } else {
                        $this->message = "Please adhere to max and min length values!";
                    }

                } else {
                    $this->message = "Field can't be empty";
                }
            }
        }
    }
}

$run = new edit_task();
$run->update();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="input_form">
        <a href="index.php">Cancel</a>
        <h5>Update Task</h5>
		<input type="text" required minlength="5" value="<?php if (isset($run->text)) { echo $run->text; }?>" maxlength="1000" name="task" class="task_input">
        <input name="id" type="hidden" value="<?php if(isset($run->edit_task)) { echo $run->edit_task; }?>">
        <button type="submit" name="submit" class="add_btn">Update</button>
<?php
if (isset($run->message)) {
?>
        <h4><?php  echo $run->message; ?></h4>
<?php
}
?>
        
	</form>

    </body>
</html>