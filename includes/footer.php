<?php
    $url = strval($url);

?>
<!-- <footer>
    <div class="footer-container">
        <div class="footer-row">
            <div class="footer-group-container">
                <a href="<?php echo $url ?>" class="footer-logo-container">
                    <div class="footer-logo-image-container">
                        <img src="<?php echo $url ?>/assets/images/halfcarry-logo.jpeg" alt="Footer logo">
                    </div>
                    <div class="footer-logo-text"> -->
                        <!-- <span class="logo-title">CODEWEB STORE</span> -->
                        <!-- <span>Making life easy</span>
                    </div>
                </a> -->
                <!-- <p class="footer-message">
                    Codeweb project solutions was founded in 2019, since then we have continued to produce
                    reliable services in all sectors of production and consumption.
                </p> -->
            <!-- </div>

            <div class="footer-group call-container">
                <div class="call-center-container">
                    <div class="call-center-textbox">
                        <span class="call-center-text">Call Center</span>
                        <a href="tel:+2347026790425" class="call-center-no">+234 7026790425</a>
                    </div>
                    <div class="tel-icon-container">
                        <i class="fa fa-phone"></i>
                    </div>
                </div>
                <ul class="social-media-links">
                    <li>
                        <a href="#">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright-message">
            <div>C</div>
            <span>Copyright Codeweb <?php echo date("Y") ?></span>
        </div>
    </div>
</footer> -->
<hr>
<footer class="mt-5 bg-white">
    <div class="container">
        <div class="row mx-auto">


            <div class="col-lg-2 col-md-4 col-7 mx-auto my-4">
                <a href="" class="navbar-brand">
<<<<<<< Updated upstream
                     <img src="<?php echo $link; ?>assets/images/halfcarry-logo.jpeg" alt="Footer logo" width="90px">
=======
                     <img src="<?php echo $link;?>assets/images/halfcarry-logo.jpeg" alt="Footer logo" width="90px">
>>>>>>> Stashed changes
                </a>
                <p style="color:black; font-size:1.5rem;" class="my-4">
                    Making Life Easy...
                </p>
            </div>


             <div class="col-lg-2 col-md-4 col-5 mx-auto  my-4">
             <p class="h3" style="color:#ff5c00;" class="">Categories</p>
             <?php
              $sql = "SELECT * FROM `product_categories` WHERE category_id<10";
                $result= mysqli_query($db,$sql);
                while($row= mysqli_fetch_assoc($result)){
             ?>
             <p class="my-1"><a style="color:black; text-decoration:none; font-size:1.5rem;" href=""><?php echo $row['category_name']; ?></a></p>
           <?php
           }
           ?>
           </div> 
           
           
           <div class="col-lg-2 col-md-4 col-7 mx-auto my-4">
             <p class="h3" style="color:#ff5c00;">Categories</p>
             <?php
              $sql = "SELECT * FROM `product_categories` WHERE category_id>9";
                $result= mysqli_query($db,$sql);
                while($row= mysqli_fetch_assoc($result)){
             ?>
             <p class="my-1"><a style="color:black; text-decoration:none; font-size:1.5rem;" href=""><?php echo $row['category_name']; ?></a></p>
           <?php
           }
           ?>
           </div>  


            <div class="col-lg-2 col-md-4 col-5 my-4">
                <p class="h3" style="color:#ff5c00;">My Account </p>
                <p class="my-1">
                    <a style="color:black; text-decoration:none; font-size:1.5rem;" href="">Personal Information
                    </a>
                </p>
                <p class="my-1">
                    <a style="color:black; text-decoration:none; font-size:1.5rem;" href="">Addresses
                    </a>
                </p>
                <p class="my-1">
                    <a style="color:black; text-decoration:none; font-size:1.5rem;" href="">Wishlist
                    </a>
                </p>
                <p class="my-1">
                    <a style="color:black; text-decoration:none; font-size:1.5rem;" href="">Orders
                    </a>
                </p>
           </div> 


           <div class="col-lg-2 col-md-4 col-6 my-4 my-xs-5">
            <p class="h3" style="color:#ff5c00;">
                Contact
            </p>
            <p style="color:black; font-size:1.5rem;">Call Center 
            <span>
                <i class="fa-solid fa-phone fa-xs" style="color: #ff5c00;">
                </i>
            </span>
            </p>
            <p style="color:black; font-size:1.5rem;">+2347026790425
            </p>

            <p class="h3 mt-5 mb-3" style="color:#ff5c00;">
                Social Link
            </p>
            <p style="color:black; font-size:1.5rem;" class="my-2">
                <span class="me-3" >
                   <a style="text-decoration:none;" href="">
                      <i class="fa-brands fa-square-facebook fa-xl" style="color: #777;"></i>
                   </a>
                </span>
                <span class="mx-3">
                   <a style="text-decoration:none;" href="">
                      <i class="fa-brands fa-square-instagram fa-xl" style="color: #777;"></i>
                   </a>
                </span>
                <span class="mx-3">
                   <a style="text-decoration:none;" href="">
                      <i class="fa-brands fa-square-twitter fa-xl" style="color: #777;"></i>
                   </a>
                </span>
                <!-- <span class="mx-3">
                   <a href="">
                      <i class="fa-solid fa-envelope fa-xl" style="color: #ff5c00;"></i>
                   </a>
                </span> -->
            </p>
           </div>
        </div>
        <hr>

       <div class="row mt-5">
        <div class="col-12">
            <p class="text-center text-dark" style="font-size:1.5rem;">
              Copyright &copy;<span><?php echo date("Y") ?></span> 
               <a style="color:#ff5c00; text-decoration:none; font-size:1.5rem;" href="https://codeweb.ng/">Codeweb
               </a>. All rights reserved.
            </p>
        </div>
       </div>
    </div>
</footer>