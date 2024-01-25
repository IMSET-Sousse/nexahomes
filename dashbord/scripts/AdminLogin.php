<?php
// Include the 'database.php' file to establish a database connection
require_once('database.php');

class AdminLogin {
    // Private property to store the database connection
    private $conn;
    // Constructor method to initialize the class with a database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Method to handle the login process
    public function login($emailAddress, $pass) {

        $loginErr = null;
        // SQL query to retrieve admin information based on email and password
        $query = "SELECT * FROM admins WHERE emailAddress = ? AND pass = ?";
        $stmt = $this->conn->prepare($query);
        // Bind parameters to the prepared statement
        $stmt->bind_param("ss", $emailAddress, $pass);
        // Execute the  statement
        $stmt->execute();
        // Get statement result
        $result = $stmt->get_result();

        // Check if there is exactly one row in the result (successful login)
        if ($result->num_rows == 1) {
            // Start a new session
            session_start();
            // Set the 'email' session variable to the provided email address
            $_SESSION['email'] = $emailAddress;
            // Redirect the user to the 'dashboard.php' page
            header("Location: dashboard.php");
        } else {
            $loginErr = "Please enter valid admin credential";

        }
        return $loginErr;

    }
    // Method to validate login credentials
    public function validateLogin($emailAddress, $pass) {

        $error = false;
        $emailErr = null;
        $passErr = null;
        $validEmail = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';   // Regular expression pattern for a valid email address

        // Check if email address is empty
        if(empty($emailAddress)) {
            $emailErr = "Email Address is required";
            $error = true;

        } elseif(!preg_match($validEmail,$emailAddress)) {
            // Check if the email address has a valid format using the regex
            $emailErr = "Wrong email address";
            $error = true;
        }

        if(empty($pass)) {
            $passErr = "Password is required";
            $error = true;
        }

        $errorInfo = [
            "error" => $error,
            "emailErr" => $emailErr,
            "passErr" => $passErr
        ];

        return $errorInfo;
    }
}
// Check if the 'login' button is set in the POST data and the request method is POST
if (isset($_POST['login']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email address and password from the POST data
    $emailAddress = $_POST['emailAddress'];
    $pass = $_POST['pass'];
    // Create an instance of the 'AdminLogin' class with the provided database connection
    $loginSystem = new AdminLogin($conn);
    // Validate login credentials
    $validateLogin = $loginSystem->validateLogin($emailAddress, $pass);
    // If there are no validation errors, attempt to perform login
    if (!$validateLogin['error']){

       $login = $loginSystem->login($emailAddress, $pass);
    }
}
?>
