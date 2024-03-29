<?php
   require_once('./dashbord/database.php');

   require_once('./dashbord/scripts/contactManager.php');

   $contactManager = new ContactManager($conn);

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
       $email = isset($_POST['email']) ? $_POST['email'] : '';
       $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
       $message = isset($_POST['message']) ? $_POST['message'] : '';

       $result = $contactManager->create($message, $email, $phone);
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
          <span class="breadcrumb"><a href="#">Home</a>  /  Contact Us</span>
          <h3>Contact Us</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-page section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading">
            <h6>| Contact Us</h6>
            <h2>Get In Touch With Our Agents</h2>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse.</p>
        </div>
        <div class="col-lg-6">
            <form id="contact-form" method="post" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-lg-12">
                     <fieldset>
                        <label for="email">Email Address</label>
                        <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                     </fieldset>
                  </div>
                  <div class="col-lg-12">
                     <fieldset>
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone ..." required="">
                     </fieldset>
                  </div>
                  <div class="col-lg-12">
                     <fieldset>
                        <label for="message">Message</label>
                        <textarea name="message" id="message" placeholder="Your Message"></textarea>
                     </fieldset>
                  </div>
                  <div class="col-lg-12">
                     <fieldset>
                        <button type="submit" class="orange-button" name="create">Send Message</button>
                     </fieldset>
                  </div>
               </div>
            </form>
         </div>
      </div>
    </div>
  </div>

<?php require('./footer.php') ?>

<script src="js/custom.js"></script>

</body>

</html>