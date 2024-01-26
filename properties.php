<?php
  require_once('./dashbord/database.php');
  require_once('./dashbord/scripts/productsManger.php');
  require_once('./dashbord/scripts/CategoryManager.php');

  $productsManger= new ProductsManager($conn);
  $content = $productsManger->get();
  $categoryManager= new CategoryManager($conn);
  $categories = $categoryManager->get();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
        integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
        integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"
        integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            .row-2 {
                justify-content: space-between;
                margin: 20px auto 20px 74%;
                display: flex;
                align-items: center;
                flex-wrap: wrap;
            }
            .row {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                justify-content: space-around;
            }
        </style>
</head>

<body>
    <?php require('./header.php') ?>
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="breadcrumb"><a href="#">Home</a> / Properties</span>
                    <h3>Properties</h3>
                </div>
            </div>
        </div>
    </div>

    <?php
    $name = "";
    $filtre = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["title"])) {
            $name = $_POST['title'];
            $filtre = " and title like '%" . $name . "%'";
        }
    }
    
    ?>

    <div class="section properties">
    <div class=" row-2">
        <form method="POST" action="">
			<div class="col-md-12 row">
				<div class="col-md-8">
					<input name="name" class="" value="<?php echo $name; ?>">
				</div>
				<div class="col-md-4" style="margin-left:10px">
					<button type="submit" class="btn" name="search">Search</button>
				</div>						
			</div>
		</form>
	</div>

        <div class="container">
            <!-- <ul class="properties-filter">
            <li>
            <a class="is_active" href="#!" data-filter="*">Show All</a>
            </li>
            <li>
            <a href="#!" data-filter=".adv">Apartment</a>
            </li>
            <li>
            <a href="#!" data-filter=".str">Villa House</a>
            </li>
            <li>
            <a href="#!" data-filter=".rac">Penthouse</a>
            </li>
        </ul> -->
            <ul class="properties-filter">
                <li>
                    <a class="is_active" href="#!" data-filter="*">Show All</a>
                </li>
                <?php   foreach($categories as $data){ ?>
                <li>
                    <a href="#!" data-filter=".catId<?= $data['id']; ?>"><?= $data['categoryName']; ?></a>
                </li>
                <?php
                }?>
            </ul>
            <!-- <div class="row properties-box">
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 adv">
            <div class="item">
                <a href="property-details.html"><img src="images/property-01.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$2.264.000</h6>
                <h4><a href="property-details.html">18 Old Street Miami, OR 97219</a></h4>
                <ul>
                <li>Bedrooms: <span>8</span></li>
                <li>Bathrooms: <span>8</span></li>
                <li>Area: <span>545m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>6 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 str">
            <div class="item">
                <a href="property-details.html"><img src="images/property-02.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$1.180.000</h6>
                <h4><a href="property-details.html">54 New Street Florida, OR 27001</a></h4>
                <ul>
                <li>Bedrooms: <span>6</span></li>
                <li>Bathrooms: <span>5</span></li>
                <li>Area: <span>450m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>8 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 adv rac">
            <div class="item">
                <a href="property-details.html"><img src="images/property-03.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$1.460.000</h6>
                <h4><a href="property-details.html">26 Mid Street Portland, OR 38540</a></h4>
                <ul>
                <li>Bedrooms: <span>5</span></li>
                <li>Bathrooms: <span>4</span></li>
                <li>Area: <span>225m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>10 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 str">
            <div class="item">
                <a href="property-details.html"><img src="images/property-04.jpg" alt=""></a>
                <span class="category">Apartment</span>
                <h6>$584.500</h6>
                <h4><a href="property-details.html">12 Hope Street Portland, OR 12650</a></h4>
                <ul>
                <li>Bedrooms: <span>4</span></li>
                <li>Bathrooms: <span>3</span></li>
                <li>Area: <span>125m2</span></li>
                <li>Floor: <span>25th</span></li>
                <li>Parking: <span>2 cars</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 rac str">
            <div class="item">
                <a href="property-details.html"><img src="images/property-05.jpg" alt=""></a>
                <span class="category">Penthouse</span>
                <h6>$925.600</h6>
                <h4><a href="property-details.html">34 Hope Street Portland, OR 42680</a></h4>
                <ul>
                <li>Bedrooms: <span>4</span></li>
                <li>Bathrooms: <span>4</span></li>
                <li>Area: <span>180m2</span></li>
                <li>Floor: <span>38th</span></li>
                <li>Parking: <span>2 cars</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 rac adv">
            <div class="item">
                <a href="property-details.html"><img src="images/property-06.jpg" alt=""></a>
                <span class="category">Modern Condo</span>
                <h6>$450.000</h6>
                <h4><a href="property-details.html">22 Hope Street Portland, OR 16540</a></h4>
                <ul>
                <li>Bedrooms: <span>3</span></li>
                <li>Bathrooms: <span>2</span></li>
                <li>Area: <span>165m2</span></li>
                <li>Floor: <span>26th</span></li>
                <li>Parking: <span>3 cars</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 rac str">
            <div class="item">
                <a href="property-details.html"><img src="images/property-03.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$980.000</h6>
                <h4><a href="property-details.html">14 Mid Street Miami, OR 36450</a></h4>
                <ul>
                <li>Bedrooms: <span>8</span></li>
                <li>Bathrooms: <span>8</span></li>
                <li>Area: <span>550m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>12 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 rac adv">
            <div class="item">
                <a href="property-details.html"><img src="images/property-02.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$1.520.000</h6>
                <h4><a href="property-details.html">26 Old Street Miami, OR 12870</a></h4>
                <ul>
                <li>Bedrooms: <span>12</span></li>
                <li>Bathrooms: <span>15</span></li>
                <li>Area: <span>380m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>14 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 rac adv">
            <div class="item">
                <a href="property-details.html"><img src="images/property-01.jpg" alt=""></a>
                <span class="category">Luxury Villa</span>
                <h6>$3.145.000</h6>
                <h4><a href="property-details.html">34 New Street Miami, OR 24650</a></h4>
                <ul>
                <li>Bedrooms: <span>10</span></li>
                <li>Bathrooms: <span>12</span></li>
                <li>Area: <span>860m2</span></li>
                <li>Floor: <span>3</span></li>
                <li>Parking: <span>10 spots</span></li>
                </ul>
                <div class="main-button">
                <a href="property-details.html">Schedule a visit</a>
                </div>
            </div>
            </div>
        </div> -->

            <?php   foreach($content as $data){ ?>
            <div class="row properties-box">
                <div
                    class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 catId<?= $data['categoryId']; ?>">
                    <div class="item">
                        <a href="property-details.php?id=<?= $data['id']; ?>"> <img
                                src="./dashbord/public/images/thumbnail/<?php echo $data ['thumbnail']; ?>"></a>
                        <span class="category"><?= $data['title']; ?></span>
                        <h6>$<?= $data['price']; ?></h6>
                        <h4><a href="property-details.php?id=<?= $data['id']; ?>"><?= $data['description']; ?></a></h4>

                        <div class="main-button">
                            <li><a href="property-details.php?id=<?= $data['id']; ?>">Details</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <?php require('./footer.php') ?>

    <script src="js/custom.js"></script>

</body>

</html>