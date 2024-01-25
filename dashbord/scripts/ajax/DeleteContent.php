<?php

require_once('../../database.php');
require_once('../productsManger.php');

if (isset($_POST['productId'])) {
    $id = $_POST['productId'];
    $productsManager = new ProductsManager($conn);
    $delete = $productsManager->deleteById($id);

    echo ($delete) ? 'true' : 'false';
}

?>
