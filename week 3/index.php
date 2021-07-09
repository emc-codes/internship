<?php
// Week 3(three) task for SH-IT

// turn off error reporting
error_reporting(0);

// include database connection file
require_once("db_connect.php");

// form validation class
class form_validate extends db_connect{
    private $query;
    private $created;
    private $run_query;
    protected $task;
    private $check_query;
    private $run_check_query;
    protected $formatted_text;
    public $message;
    
    public function __construct() {

        // instantiate parent (db_connect) class
        parent::__construct("localhost", "root", "", "to_do_list");

        // set error message upon failed database connection
        $this->message = parent::connect();

    }

    // validate form input and input into database
    public function add_task() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST["task"])) {
                // trim input
                $this->task = trim($_POST["task"]);

                if (!empty($this->task)) {

                    // validate string length 
                    if (strlen($this->task)  >= 5 && strlen($this->task) <= 1000) {

                        // sql injection protection
                        $this->formatted_text = mysqli_real_escape_string($this->connect , $this->task);

                        // timestamp
                        date_default_timezone_set("Africa/Lagos");
                        $this->created = date("D d M, Y", time());

                        // check if task exists 
                        $this->check_query = "SELECT * FROM tasks WHERE tasks='". $this->formatted_text ."'";
                        $this->run_check_query = mysqli_query($this->connect, $this->check_query);

                        if (mysqli_num_rows($this->run_check_query) == NULL) {

                            // add query 
                            $this->query = "INSERT INTO tasks VALUES('', '"  . $this->formatted_text . "', '" . $this->created . "')";
                            
                            // run add query 
                            $this->run_query = mysqli_query($this->connect, $this->query);

                            if ($this->run_query) {
                                $this->message = "Task added successfully.";
                            } else {
                                $this->message = "Encountered an error while adding task.";
                            }
                        } else {
                            $this->message = "Task already exists!";
                        }

                    } else {
                        $this->message = "Please adhere to maxlength and minlength values.";
                    }
                } else {
                    // set error message
                    $this->message = "No field(s) can be empty!";
                }
            }
        }
    }
}

$action = new form_validate();
$action->add_task();

// delete task class
class del_task extends form_validate{
    private $del_task;
    private $del_query;

    public function __construct() {
        parent::__construct();

        if (isset($_GET["del_task"])){
            $this->del_task = trim(mysqli_real_escape_string($this->connect, $_GET["del_task"]));
        }

        if (isset($this->del_task)) {

            $this->del_query = "DELETE FROM tasks WHERE id=" . $this->del_task;
            mysqli_query($this->connect, $this->del_query);   
            
            header("Location: index.php");
        }
    }
}

// instantiate delete class
new del_task();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="input_form">
        <h5>Add Tasks</h5>
		<input type="text" required minlength="5" maxlength="1000" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
        <?php
if (isset($action->message)) {
?>
        <h4><?php  echo $action->message; ?></h4>
<?php
}
?>
	</form>

    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Tasks</th>
                <th>Created</th>
                <th style="width: 60px;" colspan="2">Actions</th>
            </tr>
        </thead>

	    <tbody>

    <?php
    
    // class for retrieving tasks 
    class retrieve_tasks extends form_validate {
        private $tasks_query;
        private $run_tasks_query;
        private $num_rows;
        private $result;

        public $sn;
        public $task;

        public function __construct() {
            parent::__construct();

            $this->tasks_query = "SELECT * FROM tasks ORDER BY id";
            $this->run_tasks_query = mysqli_query($this->connect, $this->tasks_query);

            $this->sn = 1;

            while ($this->result = mysqli_fetch_array($this->run_tasks_query)) {
                
            ?>

            <tr>
                <td> <?php echo $this->sn . "."; ?> </td>
                <td class="task"> <?php echo $this->result["tasks"]; ?> </td>
                <td class="task"> <?php echo $this->result["date"]; ?> </td>
                <td class="delete"> 
                    <a href="index.php?del_task=<?php echo $this->result["id"]; ?>">delete</a> 
                </td>
                <td class="delete"> 
                    <a href="edit.php?edit_task=<?php echo $this->result["id"]; ?>">edit</a> 
                </td>
            </tr>

            <?php

            $this->sn += 1;
            }
        }
    }

    new retrieve_tasks();

    ?>

        </tbody>
    </table>

</body>
</html>