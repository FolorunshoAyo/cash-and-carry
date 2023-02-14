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
    <!-- CUSTOM CSS (form) -->
    <link rel="stylesheet" href="assets/css/form.css" type="text/css" />
    <!-- FORM STYLING STYLESHEET -->
    <link rel="stylesheet" href="assets/css/form.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link
      rel="stylesheet"
      href="assets/css/media-queries/main-media-queries.css"
      type="text/css"
    />
    <title>Register and start saving - CDS</title>
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
          <form id="registeration-form">
            <h1 class="form-title">Set up your account</h1>

            <p class="form-text">
              Get started with saving and spending by signing up with confidence
              daily savings
            </p>

            <div class="form-groupings">
              <div class="form-group-container">
                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="text"
                      name="fname"
                      id="fname"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="fname">First name</label>
                  </div>
                </div>

                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="text"
                      name="lname"
                      id="lname"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="lname">Last name</label>
                  </div>
                </div>

                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="text"
                      name="mobileno"
                      id="mobileno"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="mobileno">Mobile number</label>
                  </div>
                </div>

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

                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="text"
                      name="cpwd"
                      id="cpwd"
                      class="form-input"
                      placeholder=" "
                      required
                    />
                    <label for="cpwd">Confirm password</label>
                  </div>
                </div>
                <div class="agreement-container">
                  <label for="agree"
                    ><input type="checkbox" id="agree_to_terms" />Agree to terms
                    and conditions</label
                  >
                </div>

                <div class="submit-btn-container">
                  <button type="submit">Register</button>
                </div>
              </div>
            </div>
          </form>

          <div class="existing-account-block">
            Already have an account?
            <a href="./login"
              >Sign In <i class="fa fa-arrow-right"></i
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
    <!--SWEET ALERT JS -->
    <script src="auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script>
      //FORM VALIDATION WITH VALIDATE.JS

      const validation = new JustValidate("#registeration-form", {
        errorFieldCssClass: "is-invalid",
      });

      validation
        .addField("#fname", [
          {
            rule: "required",
            errorMessage: "Field is required",
          },
          {
            rule: "minLength",
            value: 3,
          },
          {
            rule: "maxLength",
            value: 30,
          },
        ])
        .addField("#lname", [
          {
            rule: "required",
            errorMessage: "Field is required",
          },
          {
            rule: "minLength",
            value: 3,
          },
          {
            rule: "maxLength",
            value: 30,
          },
        ])
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
        .addField("#mobileno", [
          {
            rule: "required",
            errorMessage: "Field is required",
          },
          {
            rule: "minLength",
            value: 11,
          },
          {
            rule: "maxLength",
            value: 11,
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
          const form = document.getElementById("registeration-form");

          // GATHERING FORM DATA
          const formData = new FormData(form);
          formData.append("submit", true);

          //SENDING FORM DATA TO THE SERVER
          $.ajax({
            type: "post",
            url: "authentication/register.php",
            data: formData,
            cache: false,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            dataType: "json",
            beforeSend: function () {
              $(".submit-btn-container button").html("Registering...");
              $(".submit-btn-container button").attr("disabled", true);
            },
            success: function (response) {
              setTimeout(() => {
                if (response.success === 1) {
                  // REDIRECT USER TO THE VERIFICATION PAGE
                  window.location = "authentication/send-code?a=send";
                } else {
                  $(".submit-btn-container button").attr("disabled", false);
                  $(".submit-btn-container button").html("Register");

                  if (response.error_title === "fatal") {
                    // REFRESH CURRENT PAGE
                    location.reload();
                  } else {
                    // ALERT USER
                    Swal.fire({
                      title: response.error_title,
                      icon: "error",
                      text: response.error_message,
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                    });
                  }
                }
              }, 1500);
            },
          });
        });
    </script>
  </body>
</html>
