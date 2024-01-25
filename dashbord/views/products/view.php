<?php
require_once('scripts/productsManger.php');

$productsManager = new ProductsManager($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $getProduct = $productsManager->getFromMultipleTables($id);
    $comments = $productsManager->getCommentsByProductId($id);
    $averageRating = $productsManager->getAverageRatingByProductId($id);
    $ratings = $productsManager->getAllRatingsByProductId($id); // Retrieve all ratings for the product
}

?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-4">View Product</h3>
    </div>
    <div class="col-sm-6 text-end">
        <a href="dashboard.php?page=products-list" class="btn btn-success">Products List</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h1><?= isset($getProduct['title']) ? $getProduct['title'] : ''; ?></h1>
        <?php if ($averageRating > 0) { ?>
            <p><b>Average Rating: </b><?= number_format($averageRating, 1); ?></p>
        <?php } ?>
        <p><b>Category: </b><?= isset($getProduct['categoryName']) ? $getProduct['categoryName'] : ''; ?></p>
        <p><b>Price: </b><?= isset($getProduct['price']) ? $getProduct['price'] : ''; ?></p>
        <?php
        if (isset($getProduct['thumbnail'])) {
        ?>
            <img src="public/images/thumbnail/<?php echo $getProduct['thumbnail']; ?>" width="200px">
        <?php } ?>
        <div class="content">
            <?= isset($getProduct['description']) ? $getProduct['description'] : ''; ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-sm-12">
        <h3>Comments</h3>
        <ul>
            <?php foreach ($comments as $comment) { ?>
                <li><?= $comment['comment']; ?> - <?= $comment['created_at']; ?></li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="row mt-4">
    <div class="col-sm-12">
        <h3>Ratings</h3>
        <ul>
            <?php foreach ($ratings as $rating) { ?>
                <li><?= $rating['rating']; ?> - <?= $rating['created_at']; ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
