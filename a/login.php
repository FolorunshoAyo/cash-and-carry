<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  AdminAuth::Route("a/admin/");
  AgentAuth::Route("a/agent/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="favicon" href="../assets/images/logo-small.png" />
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" type="text/css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" type="text/css" />
  <!-- FORM STYLING STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/form.css" type="text/css" />
  <!-- ADMIN LOGIN CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/admin-dash/login.css">
  <!-- MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/admin-dash-mediaqueries.css" type="text/css" />
  <title>Admin Login - CDS</title>
</head>

<body>
  <section class="login-wrapper">
    <div class="login-container">
      <h1 class="login-title">
        <i class="fa fa-home"></i>
        CDS ADMIN
      </h1>
      <div class="login-form-container">
        <form id="admin-login-form">
          <div class="radio-group-container">
            <div class="radio-group">
              <label for="admin" class="active">Admin</label>
              <input type="radio" name="admin_type" id="admin" value="admin" checked />
            </div>
            <div class="radio-group">
              <label for="agent">Agent</label>
              <input type="radio" name="admin_type" id="agent" value="agent" />
            </div>
          </div>
          <div class="form-groupings">
            <div class="form-group-container">
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="email" name="email" id="email" class="form-input" placeholder=" " required />
                  <label for="email">Email address</label>
                </div>
              </div>

              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="password" name="pwd" id="pwd" class="form-input" placeholder=" " required />
                  <label for="pwd">Password</label>
                </div>
              </div>

              <div class="submit-btn-container">
                <button type="submit">Log In</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- FONT AWESOME JIT SCRIPT-->
  <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  <!-- JQUERY SCRIPT -->
  <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
  <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
  <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
  <!-- SWEET ALERT PLUGIN -->
  <script src="../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
  <!-- JUST VALIDATE LIBRARY -->
  <script src="../assets/js/just-validate/just-validate.js"></script>
  <script>
    const radioInputs = $("input[type='radio']");

    // ADMIN/OFFICE TAG
    radioInputs.each(function (index) {
      const targetInput = $(this);
      targetInput.on("change", function (e) {

        radioInputs.each(function () { $(this).siblings("label").removeAttr("class") });

        if (e.target.checked) {
          targetInput.siblings("label").addClass("active");
        }
      });
    });

    //FORM VALIDATION WITH VALIDATE.JS

    const validation = new JustValidate('#admin-login-form', {
      errorFieldCssClass: 'is-invalid',
    });

    validation
      .addField('#email', [
        {
          rule: 'required',
          errorMessage: 'Field is required',
        },
        {
          rule: 'email',
          errorMessage: 'Email is invalid!',
        },
      ])
      .addField('#pwd', [
        {
          rule: 'minLength',
          value: 6,
        },
        {
          rule: 'required',
          errorMessage: "Please provide a password"
        }
      ])
      .onSuccess(() => {
        const form = document.getElementById('admin-login-form');

        // GATHERING FORM DATA
        const formData = new FormData(form);
        formData.append("login", true);

        //SENDING FORM DATA TO THE SERVER
        $.ajax({
          type: "post",
          url: 'authentication/login.php',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          beforeSend: function () {
            $(".submit-btn-container button").html("<i class='fa fa-spinner rotate'></i>");
            $(".submit-btn-container button").attr("disabled", true);
          },
          success: function (response) {
            setTimeout(() => {
              if (response.success === 1) {
                if(response.admin_type === "admin"){
                  location.replace("./admin/");
                }
                
                if(response.admin_type === "agent"){
                  location.replace("./agent/");
                }

              } else {
                if (response.error_title === "fatal") {
                  Swal.fire({
                    title: response.error_title,
                    icon: "error",
                    text: response.error_msg,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                  });

                  // REFRESH CURRENT PAGE
                  setTimeout(() => location.reload(), 1500);
                } else {
                  // ALERT USER
                  Swal.fire({
                    title: response.error_title,
                    icon: "error",
                    text: response.error_msg,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                  });

                  $(".submit-btn-container button").html("Log in");
                  $(".submit-btn-container button").attr("disabled", false);
                }
              }
            }, 1500);
          },
        });
      });
  </script>
</body>

</html>