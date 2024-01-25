<?php

class ProductsManager {
    // Private properties to store the database connection, product table name, and category table name
    private $conn;
    private $productTable = 'product';
    private $categoryTable = 'categories';
    // Constructor that initializes the class with a database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Method to validate product data
    public function validate($categoryId, $title, $description, $price) {

        $error = false;
        $errMsg = null;
        $categoryIdErr = '';
        $titleErr = '';
        $descriptionErr = '';
        $priceErr = '';

        if (empty($categoryId)) {
            $categoryIdErr = "Category is required";
            $error = true;
        }
        if (empty($title)) {
            $titleErr = "Title is required";
            $error = true;
        }
        if (empty(trim($description))) {
            $descriptionErr = "Description is required";
            $error = true;
        }
        if (empty($price)) {
            $priceErr = "Price is required";
            $error = true;
        }

        $errorInfo = [
            "error" => $error,
            "errMsg" => [
                "title" => $titleErr,
                "description" => $descriptionErr,
                "categoryId" => $categoryIdErr,
                "price" => $priceErr
            ]
        ];

        return $errorInfo;
    }
    // Method to upload product thumbnail
    public function uploadThumbnail($id = null) {

        $error = false;
        $thumbnailErr = '';
        $uploadTo = "public/images/thumbnail/";
        $allowFileType = array('jpg', 'png', 'jpeg');
        $fileName = $_FILES['thumbnail']['name'];
        // If no new thumbnail is provided and an ID is present, retrieve the existing thumbnail
        if (empty($fileName) && null !== $id) {
            $get = $this->getById($id);
            if (isset($get['thumbnail'])) {
                $fileName = $get['thumbnail'];
            }
        } else {
            $tempPath = $_FILES["thumbnail"]["tmp_name"];
            $basename = basename($fileName);
            $originalPath = $uploadTo . $basename;
            $fileType = pathinfo($originalPath, PATHINFO_EXTENSION);
            // Check if the file type is allowed
            if (!empty($fileName)) {
                if (in_array($fileType, $allowFileType)) {
                // Move the uploaded file to the specified directory
                    if (!move_uploaded_file($tempPath, $originalPath)) {
                        $thumbnailErr = 'Thumbnail Not uploaded! Try again';
                        $error = true;
                    }
                } else {
                    $thumbnailErr = 'Thumbnail type is not allowed';
                    $error = true;
                }
            } else {
                $thumbnailErr = 'Thumbnail is required';
                $error = true;
            }
        }
        $thumbnailInfo = [
            "error" => $error,
            "thumbnailErr" => $thumbnailErr,
            "thumbnailName" => $fileName
        ];

        return  $thumbnailInfo;
    }
    // Method to create a new product
    public function create($categoryId, $title, $description, $price) {

        $validate = $this->validate($categoryId, $title, $description, $price);
        $success = false;
        // If validation passes, proceed to upload the thumbnail
        if (!$validate['error']) {
            $uploadThumbnail = $this->uploadThumbnail();
            if (!$uploadThumbnail['error']) {
                $query = "INSERT INTO ";
                $query .= $this->productTable;
                $query .= " (categoryId, title, description, price, thumbnail) ";
                $query .= " VALUES (?, ?, ?, ?, ?) ";
                // Prepare the SQL statement
                $stmt = $this->conn->prepare($query);
                // Bind the parameters to the statement
                $stmt->bind_param("sssss", $categoryId, $title, $description, $price, $uploadThumbnail['thumbnailName']);

                if ($stmt->execute()) {
                    $success = true;
                    $stmt->close();
                }
            }
        }

        $data = [
            'errMsg' => $validate['errMsg'],
            'uploadThumbnail' => $uploadThumbnail['thumbnailErr'] ?? 'Unable to upload thumbnail due to other fields facing errors',
            'success' => $success
        ];

        return $data;
    }
    // Method to retrieve all products from the database
    public function get() {
        $data = [];
        $query = "SELECT id, categoryId, title, description, price, thumbnail FROM ";
        $query .= $this->productTable;
        $result = $this->conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }

        return $data;
    }
    // Method to retrieve a product by its ID from the database
    public function getById($id) {
        $data = [];
        $query = "SELECT id, categoryId, title, description, price, thumbnail FROM ";
        $query .= $this->productTable;
        $query .= " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
        }

        return $data;
    }
    // Method to retrieve product data from multiple tables by product ID with join with category table
    public function getFromMultipleTables($id) {
        $data = [];
        $query = "SELECT t1.title, t1.description, t1.thumbnail, t1.price, t2.categoryName FROM ";
        $query .= $this->productTable;
        $query .= " AS t1 ";
        $query .= "INNER JOIN ";
        $query .= $this->categoryTable;
        $query .= " AS t2";
        $query .= " ON t1.categoryId = t2.id";
        $query .= " WHERE t1.id = ?";
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id);
        // Execute the statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
        }
        return $data;
    }
    // Method to update a product by its ID in the database
    public function updateById($id, $categoryId, $title, $description, $price) {
        $validate = $this->validate($categoryId, $title, $description, $price);
        $success = false;

        if (!$validate['error']) {
            $uploadThumbnail = $this->uploadThumbnail($id);
            if (!$uploadThumbnail['error']) {
                $query = "UPDATE ";
                $query .= $this->productTable;
                $query .= " SET categoryId = ?, title = ?, description = ?, price = ?, thumbnail = ? ";
                $query .= " WHERE id = ?";

                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("issssi", $categoryId, $title, $description, $price, $uploadThumbnail['thumbnailName'], $id);

                if ($stmt->execute()) {
                    $success = true;
                    $stmt->close();
                }
            }
        }

        $data = [
            'errMsg' => $validate['errMsg'],
            'uploadThumbnail' => $uploadThumbnail['thumbnailErr'] ?? 'Unable to upload thumbnail due to other fields facing errors',
            'success' => $success
        ];

        return $data;
    }
    // Method to delete a product by its ID from the database
    public function deleteById($id) {
        $query = "DELETE FROM ";
        $query .= $this->productTable;
        $query .= " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    // Method to count the total number of products in the database
    public function countProducts() {
        $count = 0;
        $query = "SELECT COUNT(id) as count FROM ";
        $query .= $this->productTable;
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $result->free();
        }

        return $count;
    }
    // Method to retrieve comments by product ID from the database
    public function getCommentsByProductId($productId) {
        $data = [];
        $query = "SELECT id, comment, created_at FROM comments WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
        }

        return $data;
    }
    // Method to retrieve the average rating by product ID from the database
    public function getAverageRatingByProductId($productId) {
        $averageRating = 0;

        $query = "SELECT AVG(rating) AS averageRating FROM ratings WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $averageRating = $row['averageRating'];
            $stmt->close();
        }

        return $averageRating;
    }
    // Method to add a comment to a product in the database
    public function addCommentToProduct($productId, $comment) {
        $success = false;

        $query = "INSERT INTO comments (product_id, comment, created_at, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP(6), CURRENT_DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $productId, $comment);

        if ($stmt->execute()) {
            $success = true;
            $stmt->close();
        }

        return $success;
    }
    // Method to get ratings ofproduct in the database
    public function getAllRatingsByProductId($productId) {
        $data = [];
        $query = "SELECT id, rating, created_at FROM ratings WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
        }

        return $data;
    }

    public function addRatingToProduct($productId, $rating) {
        $success = false;

        if ($rating >= 1 && $rating <= 5) {
            $query = "INSERT INTO ratings (product_id, rating, created_at, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP(6), CURRENT_DATE)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $productId, $rating);

            if ($stmt->execute()) {
                $success = true;
                $stmt->close();
            }
        }

        return $success;
    }

}
?>
