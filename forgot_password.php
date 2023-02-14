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
    <title>Forgot Password - CDS</title>
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
          <form action="./authentication/forgot-password" method="POST">
            <h1 class="form-title">Forgot Password?</h1>

            <p class="form-text">Enter the email you registered with and we'll send you a reset link</p>

            <div class="form-groupings">
                <div class="form-group-container">
                    <div class="form-group animate">
                        <input type="email" name="email" id="email" class="form-input" placeholder=" " required>
                        <label for="email">Email</label>
                    </div>
                </div>

              <div class="submit-btn-container">
                <button type="submit" name="submit">Reset password</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </body>
</html>
<?php
if (isset($_SESSION['success']) && $_SESSION['success'] == 1) {
    alert_msg_url("success", "Reset Link Sent", "A reset link has been sent to your email, Check your mail box or spam folder", "login");
    unset($_SESSION['success']);
}

if (isset($_SESSION['error']) && $_SESSION['error'] == 1) {
    toast_msg("error","Email Error", "Your email is incorrect, please enter the correct email and try again.");
    unset($_SESSION['error']);
}

?>
