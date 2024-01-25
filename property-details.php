<?php
  require_once('./dashbord/database.php');
  require_once('./dashbord/scripts/productsManger.php');
  require_once('./dashbord/scripts/CategoryManager.php');

  $productsManager= new ProductsManager($conn);
  $content = $productsManager->get();
  $categoryManager= new CategoryManager($conn);
  $categories = $categoryManager->get();


  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $getProduct = $productsManager->getById($id);
  }
  $categoryManager = new CategoryManager($conn);
$getCategory = $categoryManager->getById($getProduct['categoryId']);
$averageRating = $productsManager->getAverageRatingByProductId($id);
$comments = $productsManager->getCommentsByProductId($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addComment'])) {
        $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
        $success = $productsManager->addCommentToProduct($id, $comment);

        $getProduct = $productsManager->getById($id);
        $comments = $productsManager->getCommentsByProductId($id); // Update comments after adding a new one
    } elseif (isset($_POST['addRating'])) {
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

        if ($rating >= 1 && $rating <= 5) {
            $success = $productsManager->addRatingToProduct($id, $rating);

            $getProduct = $productsManager->getById($id);
        } else {

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php require('./header.php') ?>

<div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
        <span class="breadcrumb"><a href="#">Home</a> / <?= $getProduct['title'] ?? ''; ?></span>
                <h3><?= $getProduct['title'] ?? ''; ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="single-property section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="main-image">
            <!-- <img src="images/single-property.jpg" alt=""> -->
            <img src="./dashbord/public/images/thumbnail/<?php echo $getProduct['thumbnail']; ?>">

          </div>
          <!-- <div class="main-content">
            <span class="category">Apparment</span>
            <h4>24 New Street Miami, OR 24560</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.
            
            <br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.</p>
          </div>  -->
          <div class="main-content">
                    <span class="category"><?= $getCategory['categoryName'] ?? ''; ?></span>
                    <h6>$<?= $getProduct['price']; ?></h6>
                    <h4><?= $getProduct['title'] ?? ''; ?></h4>
                    <h6><b>Average Rating: </b><?= number_format($averageRating, 1); ?></h6>
                    <p><?= $getProduct['description'] ?? ''; ?></p>
                </div>
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Best useful links ?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  How does this work ?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Why is NEXAHOMES Agency the best ?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info-table">
            <ul>
              <li>
                <!-- <img src="images/info-icon-01.png" alt="" style="max-width: 52px;"> -->
                <h4>450 m2<br><span>Total Flat Space</span></h4>
              </li>
              <li>
                <!-- <img src="images/info-icon-02.png" alt="" style="max-width: 52px;"> -->
                <h4>Contract<br><span>Contract Ready</span></h4>
              </li>
              <li>
                <!-- <img src="images/info-icon-03.png" alt="" style="max-width: 52px;"> -->
                <h4>Payment<br><span>Payment Process</span></h4>
              </li>
              <li>
                <!-- <img src="images/info-icon-04.png" alt="" style="max-width: 52px;"> -->
                <h4>Safety<br><span>24/7 Under Control</span></h4>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row mt-4">
            <div class="col-lg-12">
                <form id="comment-form" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="comment">Add Comment</label>
                                <textarea class="form-control" name="comment" id="comment" placeholder="Your Comment" required=""></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning" name="addComment">Add Comment</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <form id="rating-form" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="rating">Add Rating (1-5)</label>
                                <input type="number" class="form-control" name="rating" id="rating" min="1" max="5" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" name="addRating">Add Rating</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
        <div class="col-lg-12">
            <h4>Comments:</h4>
            <ul class="list-group">
                <?php foreach ($comments as $comment) : ?>
                    <li class="list-group-item"><?= $comment['comment']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
  </div>

  

<?php require('./footer.php') ?>

<script src="js/custom.js"></script>

</body>

</html>