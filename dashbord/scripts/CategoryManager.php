<?php
class CategoryManager {
    // Private properties to store the database connection and the category table name
    private $conn;
    private $categoryTable = "categories";
    // Constructor that initializes the class with a database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Method to validate category data
    public function validate($categoryName) {

        $error = false;
        $errMsg = null;

        if(empty($categoryName)) {
            $errMsg = "Category is required";
            $error = true;
        }

        $errorInfo = [
            "error" => $error,
            "errMsg" => $errMsg
        ];

        return $errorInfo;
    }
    // Method to create a new category
    public function create($categoryName) {

        $validate = $this->validate($categoryName);
        $success = false;
        // If validation passes, proceed to create the category
        if (!$validate['error']){

            $query = "INSERT INTO ";
            $query .= $this->categoryTable;
            $query .= " (categoryName) ";
            $query .= " VALUES (?)";
            // Prepare the SQL statement
            $stmt = $this->conn->prepare($query);
            // Bind the parameters to the statement
            $stmt->bind_param("s", $categoryName);
            // Execute the statement
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
    // Method to retrieve all categories from the database
    public function get() {

        $data = [];
        // SQL query to select all categories from the database
        $query = "SELECT id, categoryName FROM ";
        $query .= $this->categoryTable;
        // Execute the query
        $result = $this->conn->query($query);
        // If the query is successful, fetch the results and store them in an array
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }

        return $data;
    }
    // Method to retrieve a category by its ID from the database
    public function getById($id) {

        $data = [];
        // SQL query to select a category by ID from the database
        $query = "SELECT categoryName FROM ";
        $query .= $this->categoryTable;
        $query .= " WHERE id=?";
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);
        // Bind the parameter to the statement
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data= $result->fetch_assoc();
            $stmt->close();
        }
        // Return the array containing category data
        return $data;
    }
    // Method to update a category by its ID in the database
    public function updateById($id, $categoryName) {

        $validate = $this->validate($categoryName);
        $success = false;

        if (!$validate['error']){

            $query = "UPDATE ";
            $query .= $this->categoryTable;
            $query .= " SET categoryName = ? WHERE id = ?";
            // Prepare the SQL statement
            $stmt = $this->conn->prepare($query);
            // Bind the parameters to the statement
            $stmt->bind_param("si", $categoryName, $id);

            if ($stmt->execute()) {
                $success = true;
                $stmt->close();
            }
        }

         $data = [
            'errMsg' => $validate['errMsg'],
            'success' => $success
         ];
        // Return the operation information
         return $data;
    }
    // Method to delete a category by its ID from the database
    public function deleteById($id) {
        // SQL query to delete a category by ID from the database
        $query = "DELETE FROM ";
        $query .= $this->categoryTable;
        $query .= " WHERE id = ?";
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);
        // Bind the parameter to the statement
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            $stmt->close();
        }
        $stmt->close();
    }
    // Method to count the total number of categories in the database
    public function countCategory() {
        $count = 0;
        // SQL query to count the number of categories in the database
        $query = "SELECT COUNT(id) as count FROM ";
        $query .= $this->categoryTable;
        // Execute the query
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $result->free();
        }
        // Return the total count of categories
        return $count;
    }

}



?>
