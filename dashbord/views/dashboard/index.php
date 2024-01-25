
<?php

  require_once('scripts/CategoryManager.php');

  $categoryManager= new CategoryManager($conn);
  $categoriesCount = $categoryManager->countCategory();
  require_once('scripts/productsManger.php');
  $productsManger= new ProductsManager($conn);
  $productCount = $productsManger->countProducts();

  require_once('scripts/ContactManager.php');
  $contactManger= new ContactManager($conn);
  $contactCount = $contactManger->countContacts();

?>
    <div class="row support">
        <div class="col-sm-6">
            <div class="info-box">
                <div class="row">
                    <div class="col-sm-4 info-icon">
                        <i class="fa fa-cog"></i>
                    </div>
                    <div class="col-sm-8">
                        <a href="dashboard.php?page=category-list">Category</a>
                        <p><?= $categoriesCount; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="info-box">
                <div class="row">
                    <div class="col-sm-4 info-icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <div class="col-sm-8">
                        <a href="dashboard.php?page=products-list"> Products </a>
                        <p><?= $productCount; ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row support">

        <div class="col-sm-6">
            <div class="info-box">
                <div class="row">
                    <div class="col-sm-4 info-icon">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="col-sm-8">
                        <a href="dashboard.php?page=contact-list"> Contacts </a>
                        <p><?= $contactCount; ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
