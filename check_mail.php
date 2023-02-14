<?php
  require(__DIR__.'/auth-library/resources.php');
  Auth::Route("./user/");
  $url = strval($url);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css" type="text/css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css" type="text/css" />
    <!-- FORM STYLING STYLESHEET -->
    <link rel="stylesheet" href="assets/css/form.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link
      rel="stylesheet"
      href="assets/css/media-queries/main-media-queries.css"
      type="text/css"
    />
    <title>Mail Sent - CDS</title>
  </head>

  <body>
    <div class="form-page-wrapper">
      <header>
        <a href="index.html" class="form-logo-container">
          <div class="form-logo-img-container">
            <img src="assets/images/logo-small.png" alt="Small Logo" />
          </div>
          <div class="form-logo-text-container">
            <span class="logo-text">CDS</span>
            <span>Confidence daily savings</span>
          </div>
        </a>
      </header>
      <section class="form-section">
        <div class="form-container" style="text-align: center;">
            <h1 class="form-title">Check mail</h1>

            <p class="form-text">We've sent you a reset link, please check your email and reset your password.</p>

            <div class="check-icon-container">
                <i class="fa fa-check-circle-o"></i>
            </div>

            <div class="link-container">
                <a href="./login">Click here to be redirected</a>
            </div>
        </div>
      </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  </body>
</html>
