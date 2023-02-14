<?php
require(__DIR__.'/auth-library/resources.php');
Auth::Route("login");
$url = strval($url);

if(isset($_SESSION['verify']) && isset($_SESSION['otp_code']) && isset($_SESSION['email'])) {
   // stay on page 
}else{
    //Redirect to login page
    header("location: ./login");
}
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
    <title>Verify Email - CDS</title>
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
        <div class="form-container">
          <form id="verify-email-form" action="./authentication/verify-code" method="POST">
            <h1 class="form-title">Email Verification</h1>
            <?php
              $email = $_SESSION['email'];
              $e = explode('@', $email);
              $email = substr($e[0], 0, 3);
              $domain = $e[1];
            ?>
            <p class="form-text">We just sent your authentication code via email to <b><?php echo $email."*******@".$domain; ?></b>. Kindly check your mailbox or spam folder.</p>

            <div class="form-groupings">
                <div class="form-group-container">
                    <div class="form-group animate">
                        <input type="text" name="otp" id="otp" placeholder=" " class="form-input" required>
                        <label for="otp">Verification code</label>
                    </div>
                </div>

              <div class="submit-btn-container">
                <button type="submit">Reset password</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
    <?php
      if (isset($_SESSION['isverified']) && $_SESSION['isverified'] == false) {
          toast_msg("error", "Verification Error", "Your verification code is incorrect");
          unset($_SESSION['isverified']);
        }
    ?>
  </body>
</html>