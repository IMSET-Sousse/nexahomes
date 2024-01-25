<?php
require_once('scripts/productsManger.php');

$productsManager = new ProductsManager($conn);
$content = $productsManager->get();
$productCount = $productsManager->countProducts();
?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-4">Products List</h3>
    </div>
    <div class="col-sm-6 text-end">
        <p>Total Products: <?= $productCount; ?></p>
        <a href="dashboard.php?page=products-form" class="btn btn-success">Add New</a>
    </div>
</div>

<div class="table-responsive-sm">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th colspan="3" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($content)) {
                $sn = 1;
                foreach ($content as $data) {
            ?>
                    <tr>
                        <td><?= $data['id']; ?></td>
                        <td><?= $data['title']; ?></td>
                        <td><?= $data['price']; ?></td>
                        <td class="text-center">
                            <a href="dashboard.php?page=products-form&id=<?= $data['id']; ?>" class="text-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="dashboard.php?page=products-info&id=<?= $data['id']; ?>" class="text-success">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0)" onclick="confirmContentDelete(<?= $data['id']; ?>)" class="text-danger">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
            <?php
                    $sn++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="4">No products Found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="public/js/ajax/delete-content.js"></script>
