<?php
require(__DIR__.'/auth-library/resources.php');
Auth::Route("login");

if(isset($_GET['auth']) && !empty($_GET['auth'])) {
	$get_token =  $db->real_escape_string($_GET['auth']);
 }else {
    header("Location: ./login");
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
    <title>Reset your password - CDS</title>
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
          <form id="reset-pass-form" action="reset_password?a=new_pass&auth=<?php echo $get_token ?>" method="POST">
            <h1 class="form-title">Reset your Password</h1>

            <p class="form-text">
              Enter a new password. password must be at least 6 characters long.
            </p>

            <div class="form-groupings">
              <div class="password-form-group-container first">
                <div class="password-form-group">
                  <input
                    type="password"
                    name="pwd"
                    id="pwd"
                    class="password-form-input"
                    placeholder=" "
                    required
                  />
                  <label for="pwd">Password</label>
                </div>
                <div class="visibility-container">
                  <i class="fas fa-eye"></i>
                </div>
              </div>

              <div class="password-form-group-container">
                <div class="password-form-group">
                  <input
                    type="password"
                    name="cpwd"
                    id="cpwd"
                    class="password-form-input"
                    placeholder=" "
                    required
                  />
                  <label for="cpwd">Confirm Password</label>
                </div>
                <div class="visibility-container">
                  <i class="fas fa-eye"></i>
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
    <!-- FONT AWESOME JIT SCRIPT-->
    <script
      src="https://kit.fontawesome.com/3ae896f9ec.js"
      crossorigin="anonymous"
    ></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script>
      //FORM VALIDATION WITH VALIDATE.JS

      const validation = new JustValidate("#reset-pass-form", {
        errorFieldCssClass: "is-invalid",
      });

      validation
        .addField("#pwd", [
          {
            rule: "minLength",
            value: 6,
          },
          {
            rule: "required",
            errorMessage: "Please provide a password",
          },
        ])
        .addField("#cpwd", [
          {
            rule: "minLength",
            value: 6,
          },
          {
            rule: "required",
            errorMessage: "Field is required",
          },
          {
            validator: (value, fields) => {
              if (fields["#pwd"] && fields["#pwd"].elem) {
                const repeatPasswordValue = fields["#pwd"].elem.value;

                return value === repeatPasswordValue;
              }

              return true;
            },
            errorMessage: "Passwords should be the same",
          },
        ])
        .onSuccess((event) => {
          console.log("Validation passes and form submitted", event);
        });

      // PASSWORD VISIBILITY TOGGLER
      $(".visibility-container").each(function (index) {
        $(this).on("click", function () {
          const icon = $(this).children()[0];

          if (icon.getAttribute("class") === "fas fa-eye") {
            icon.setAttribute("class", "fas fa-eye-slash");

            $("#pwd")[index].setAttribute("type", "text");
          } else {
            icon.setAttribute("class", "fas fa-eye");

            if (index === 0) {
              $("#pwd")[index].setAttribute("type", "password");
            }
          }
        });
      });
    </script>
  </body>
</html>
<?php
$sql = "SELECT token, user_email FROM reset_tokens WHERE token='{$get_token}'";
$result = $db->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
        $user_email = $row['user_email'];

    $s = $db->query("SELECT * FROM users WHERE email='{$user_email}'");
    $r = $s->fetch_assoc();
    $uname = $r['first_name'];
    
    if (isset($_POST['submit'])) {
    $pass = $db->real_escape_string($_POST['pwd']);
    $conf_pass = $db->real_escape_string($_POST['cpwd']);

       if ($pass != $conf_pass) {
        toast_msg("error" ,"Error", "Password does not match!");   
       }else {
        $hashPass = password_hash($conf_pass, PASSWORD_DEFAULT);
        $sql2 = "UPDATE users SET passkey=? WHERE email='{$user_email}'";
        $statement = $db->prepare($sql2);
        $statement->bind_param("s", $hashPass);
        if ($statement->execute()) {
            $sql3 = "DELETE FROM reset_tokens WHERE token='{$get_token}'";
            $result2 = $db->query($sql3);
            if ($result2) {             
                unset($_SESSION['reset_link']);
                $msg = "<div class='container'>
                        <div class='box'>
                        <b><h2>Hi $uname!</h2></b>
                        <p>You are receiving this email to let you know that your account password has been changed successfully.</p><br>
                        <a href='$url/login'><button style='background-color:#337AB7; color:white; padding:15px; border:0; border-radius:5px;'>Login</button></a>
                        <br><br>
                        </div>
                </div>";
               send_raw_mail($user_email, "StudentExtra Password Changed", $msg);
               alert_msg_url("success", "Password changed successfully!", "Please login with the new password","login");                               
           }
       }			 		 
    }
    }else{
        echo "<script>window.location.replace('./login')</script>";
    }
}else{
    echo "<script>window.location.replace('./login')</script>";
}



?>