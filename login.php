<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- IZI TOAST CSS -->
    <link rel="stylesheet" href="auth-library/vendor/dist/css/iziToast.min.css" />
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
    <title>Login - CDS</title>
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
          <form id="login-form">
            <h1 class="form-title">Welcome Back</h1>

            <p class="form-text">
              Begin spending and saving by accessing your account!
            </p>

            <div class="form-groupings">
              <div class="form-group-container">
                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="email">Email address</label>
                  </div>
                </div>

                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="password"
                      name="pwd"
                      id="pwd"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="pwd">Password</label>
                  </div>
                </div>

                <div class="submit-btn-container">
                  <button type="submit">Log In</button>
                </div>
              </div>
            </div>
          </form>

          <div class="existing-account-block">
            Don't have an account?
            <a href="./register"
              >Sign Up <i class="fa fa-arrow-right"></i
            ></a>
          </div>
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
    <!-- IZI TOAST SCRIPT -->
    <script src="auth-library/vendor/dist/js/iziToast.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="assets/js/just-validate/just-validate.js"></script>
    <script>
      //FORM VALIDATION WITH VALIDATE.JS

      const validation = new JustValidate("#login-form", {
        errorFieldCssClass: "is-invalid",
      });

      validation
        .addField("#email", [
          {
            rule: "required",
            errorMessage: "Field is required",
          },
          {
            rule: "email",
            errorMessage: "Email is invalid!",
          },
        ])
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
        .onSuccess((event) => {
          const loginForm = document.getElementById("login-form");

          const formData = new FormData(loginForm);

          formData.append("login", true);

          for ([key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
          }

          $.ajax({
            url: "authentication/login.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
              $(".submit-btn-container button").html("<i class='fa fa-spinner rotate'></i>");
              $(".submit-btn-container button").attr("disabled", true);
            },
            success: function (response) {
              response = JSON.parse(response);

              if (response.success === 1) {
                if (response.redirect === "home-page") {
                  //REDIRECT TO DASH
                  window.location = "./";
                } else {
                  // REDIRECT TO EMAIL VERIFICATION'S PAGE
                  window.location = "authentication/send-code?a=send";
                }
              } else {
                $(".submit-btn-container button").html("Log In");
                $(".submit-btn-container button").attr("disabled", false);

                if (response.error_title === "suspended") {
                  iziToast.error({
                    title:
                      "Your account has been suspended, contact our support.",
                    timeout: 4000,
                    backgroundColor: "red",
                    theme: "dark",
                    position: "topRight",
                  });
                } else if (response.error_title === "incorrect password") {
                  iziToast.error({
                    title: "Your password is incorrect, please try again.",
                    timeout: 4000,
                    backgroundColor: "red",
                    theme: "dark",
                    position: "topRight",
                  });
                } else if (response.error_title === "incorrect details") {
                  iziToast.error({
                    title: "Incorrect email and password, try again.",
                    timeout: 4000,
                    backgroundColor: "red",
                    theme: "dark",
                    position: "topRight",
                  });
                } else {
                  location.reload();
                }
              }
            },
          });
        });
    </script>
  </body>
</html>
