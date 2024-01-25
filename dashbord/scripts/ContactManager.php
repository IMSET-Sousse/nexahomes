<?php

class ContactManager {
    // Private properties to store the database connection and the contact table name
    private $conn;
    private $contactTable = "contact";
    // Constructor that initializes the class with a database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Method to validate contact data
    public function validate($message, $email, $phoneNumber) {
        $error = false;
        $errMsg = null;

        if (empty($message) || empty($email) || empty($phoneNumber)) {
            $errMsg = "Message, email, and phone number are required";
            $error = true;
        }

        $errorInfo = [
            "error" => $error,
            "errMsg" => $errMsg
        ];

        return $errorInfo;
    }
    // Method to create a new contact
    public function create($message, $email, $phoneNumber) {
        $validate = $this->validate($message, $email, $phoneNumber);
        $success = false;

        if (!$validate['error']) {
            $query = "INSERT INTO ";
            $query .= $this->contactTable;
            $query .= " (message, email, phoneNumber) ";
            $query .= " VALUES (?, ?, ?)";
            // Prepare the SQL statement
            $stmt = $this->conn->prepare($query);
            // Bind the parameters to the statement
            $stmt->bind_param("sss", $message, $email, $phoneNumber);

            if ($stmt->execute()) {
                $success = true;
                $stmt->close();
            }
        }

        $data = [
            'errMsg' => $validate['errMsg'],
            'success' => $success
        ];

        return $data;
    }
    // Method to retrieve all contacts from the database
    public function getContacts() {
        $data = [];
        // SQL query to select all contacts from the database
        $query = "SELECT id, message, email, phoneNumber, created_at FROM ";
        $query .= $this->contactTable;
        // Execute the query
        $result = $this->conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }
        // Return the array containing contact data
        return $data;
    }
    // Method to retrieve a contact by its ID from the database
    public function getContactById($id) {
        $data = [];

        $query = "SELECT message, email, phoneNumber, created_at FROM ";
        $query .= $this->contactTable;
        $query .= " WHERE id = ?";
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);
        // Bind the parameter to the statement
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
        }

        return $data;
    }
    // Method to count the total number of contacts in the database
    public function countContacts() {
        $count = 0;
        // SQL query to count the number of contacts in the database
        $query = "SELECT COUNT(id) as count FROM ";
        $query .= $this->contactTable;
        // Execute the query
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $result->free();
        }
        // Return the total count of contacts
        return $count;
    }
}
?>
