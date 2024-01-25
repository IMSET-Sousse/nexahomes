<?php
require_once('scripts/productsManger.php');
$productsManager = new ProductsManager($conn);

require_once('scripts/CategoryManager.php');
$categoryManager = new CategoryManager($conn);
$categories = $categoryManager->get();

$msg = '';
$errMsg = '';
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_POST['create']) || isset($_POST['update'])) {
    $categoryId = $_POST['categoryId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (isset($_POST['create'])) {
        $create = $productsManager->create($categoryId, $title, $description, $price);

        if ($create['success']) {
            $msg = "Product created successfully";
        }
    } elseif (isset($_POST['update'])) {
        $update = $productsManager->updateById($id, $categoryId, $title, $description, $price);

        if ($update['success']) {
            $msg = "Product updated successfully";
        }
    }

    if (isset($create['uploadThumbnail'])) {
        $thumbnailErr = $create['uploadThumbnail'];
    } elseif (isset($update['uploadThumbnail'])) {
        $thumbnailErr = $update['uploadThumbnail'];
    }

    if (isset($create['errMsg'])) {
        $titleErr = $create['errMsg']['title'];
        $categoryIdErr = $create['errMsg']['categoryId'];
        $descriptionErr = $create['errMsg']['description'];
    } elseif (isset($update['errMsg'])) {
        $titleErr = $update['errMsg']['title'];
        $categoryIdErr = $update['errMsg']['categoryId'];
        $descriptionErr = $update['errMsg']['description'];
    }
}

if ($id) {
    $getProduct = $productsManager->getById($id);
}
?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-4">Product Form</h3>
        <?php echo $msg; ?>
    </div>
    <div class="col-sm-6 text-end">
        <a href="dashboard.php?page=products-list" class="btn btn-success">Product List</a>
    </div>
</div>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label>Title</label>
        <input type="text" class="form-control" name="title" value="<?= $getProduct['title'] ?? ''; ?>">
        <p class="text-danger"><?= $titleErr ?? ''; ?></p>

        <label>Description</label>
        <textarea class="form-control" name="description" id="summernote"><?= $getProduct['description'] ?? ''; ?></textarea>
        <p class="text-danger"><?= $descriptionErr ?? ''; ?></p>

        <label>Price</label>
        <input type="text" class="form-control" name="price" value="<?= $getProduct['price'] ?? ''; ?>">

        <select class="form-control" name="categoryId">
            <option value="">Select Category</option>
            <?php
            foreach ($categories as $category) {
                $categoryId = $category['id'];
                $categoryName = $category['categoryName'];
                $selected = isset($getProduct['categoryId']) && $getProduct['categoryId'] == $categoryId ? 'selected' : '';
                echo "<option value='$categoryId' $selected>$categoryName</option>";
            }
            ?>
        </select>
        <p class="text-danger"><?= $categoryIdErr ?? ''; ?></p>

        <label>Thumbnail</label>
        <input type="file" class="form-control" name="thumbnail">
        <?php
        if (isset($getProduct['thumbnail'])) {
        ?>
            <img src="public/images/thumbnail/<?= $getProduct['thumbnail']; ?>" width="100px">
        <?php
        }
        ?>
        <p class="text-danger"><?= $thumbnailErr ?? ''; ?></p>
    </div>

    <button type="submit" class="btn btn-success" name="<?= $id ? 'update' : 'create'; ?>">Save</button>
</form>
