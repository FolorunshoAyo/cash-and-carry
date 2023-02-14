<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  Auth::User("../login");

  $user_id = $_SESSION['user_id'];

  $user_details_sql = $db->query("SELECT * FROM users WHERE user_id={$user_id}");
  $user_details = $user_details_sql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
      crossorigin="anonymous"
    />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
    <!-- CDS FORMS STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- USER DASHBOARD STYLESHEET -->
    <link
      rel="stylesheet"
      href="../assets/css/dashboard/user-dash/profile.css"
    />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link
      rel="stylesheet"
      href="../assets/css/media-queries/user-dash-mediaqueries.css"
    />
    <title>Edit Profile - CDS</title>
  </head>
  <body>
    <div class="mobile-backdrop"></div>
    <aside class="mobile-menu">
      <div class="cross-icon-wrapper">
        <div class="cross-icon-container">
          <i class="fa fa-times"></i>
        </div>
      </div>
      <div class="nav-link-container">
        <ul class="nav-links">
          <li class="nav-link-item">
            <a href="#" class="nav-link active"> Dashboard </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link"> Items picked </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link"> Address </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link"> Account details </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link logout"> Logout </a>
          </li>
        </ul>
      </div>
    </aside>
    <header>
      <div class="dash-header-container">
        <div class="menu-icon-container">
          <i class="fa fa-bars"></i>
        </div>
        <div class="header-navigation-container">
          <div class="dropdown">
            <a
              href="#"
              class="btn btn-secondary-outline dropdown-toggle header-link"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Browse
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
          <div>
            <a class="header-link" href="#">Homepage</a>
          </div>
          <div>
            <a class="header-link" href="#">Help</a>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="main-container">
        <div class="dashboard-links-wrapper">
          <div class="dashboard-links">
            <ul class="dashboard-nav-links">
              <li class="title">My Profile</li>
              <li class="dashboard-nav-link active">
                <a href="#">Dashboard</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="#">Items-picked</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="#">Address</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="#">Account details</a>
              </li>
              <li class="dashboard-nav-link logout">
                <a href="#">Logout</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="dashboard-main-section">
          <div class="dashboard-main-container">
            <h1 class="dashboard-main-title">Edit Profile</h1>

            <p class="dashboard-main-text">
              Here you can edit and view your profile and change your password.
              <b>
                Please make sure the information provided below is accurate
              </b>
            </p>

            <div id="form-container-1" class="edit-profile-form-container active animate__animated animate__backInRight">
              <form id="edit-form">
                <h2 class="form-header">Personal Information</h2>
                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="text"
                      name="fname"
                      id="fname"
                      class="form-input"
                      placeholder=" "
                      value="<?php echo($user_details['first_name']) ?>"
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
                      value="<?php echo($user_details['last_name']) ?>"
                      required
                    />
                    <label for="lname">Last name</label>
                  </div>
                </div>
                <div class="form-group-container">
                  <h3 class="static-label">Email</h3>
                  <span class="static-value"><?php echo($user_details['email']) ?></span>
                </div>
                <div class="form-group-container">
                  <div class="form-group animate">
                    <input
                      type="number"
                      name="mobileno"
                      id="mobileno"
                      class="form-input"
                      value="<?php echo($user_details['phone_no']) ?>"
                      placeholder=" "
                      required
                    />
                    <label for="mobileno">Mobile number</label>
                  </div>
                </div>
                <div class="submit-btn-container">
                  <button type="submit" id="profile-submit-btn">Save Changes</button>
                  <button type="button" class="change-password-btn">
                    Change Password <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
              </form>
              </div>

              <div id="form-container-2" class="edit-profile-form-container">
                <form id="change-pass-form">
                  <h2 class="form-header">Change password</h2>

                  <div class="form-groupings">
                    <div class="password-form-group-container first">
                      <div class="password-form-group">
                        <input
                          type="password"
                          name="oldpwd"
                          id="oldpwd"
                          class="password-form-input"
                          placeholder=" "
                          required
                        />
                        <label for="oldpwd">Old password</label>
                      </div>
                      <div class="visibility-container">
                        <i class="fas fa-eye"></i>
                      </div>
                    </div>

                    <div class="password-form-group-container first">
                      <div class="password-form-group">
                        <input
                          type="password"
                          name="newpwd"
                          id="newpwd"
                          class="password-form-input"
                          placeholder=" "
                          required
                        />
                        <label for="newpwd">New Password</label>
                      </div>
                      <div class="visibility-container">
                        <i class="fas fa-eye"></i>
                      </div>
                    </div>

                    <div class="password-form-group-container">
                      <div class="password-form-group">
                        <input
                          type="password"
                          name="cnewpwd"
                          id="cnewpwd"
                          class="password-form-input"
                          placeholder=" "
                          required
                        />
                        <label for="cnewpwd">Retype New Password</label>
                      </div>
                      <div class="visibility-container">
                        <i class="fas fa-eye"></i>
                      </div>
                    </div>

                    <div class="submit-btn-container">
                      <button type="button" class="personal-info-btn">
                        <i class="fa fa-arrow-left"></i> Personal Information
                      </button>
                      <button type="submit" id="change-pass-submit-button">Change password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script
      src="https://kit.fontawesome.com/3ae896f9ec.js"
      crossorigin="anonymous"
    ></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- JAVASCRIPT BUNDLER WITH POPPER -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
    <!-- SWEET ALERT PLUGIN -->
    <script src="../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../assets/js/just-validate/just-validate.js"></script>
    <!-- CUSTOM DASHBOARD SCRIPT -->
    <script src="../assets/js/user-dash.js"></script>
    <script>
      const firstFormContainer = $("#form-container-1");
      const secondFormContainer = $("#form-container-2");
      const changePasswordBtn = $(".change-password-btn");
      const personalInfoBtn = $(".personal-info-btn");

      changePasswordBtn.on("click", function(){
        firstFormContainer.removeClass("active animate__animated animate__backInRight");
        secondFormContainer.addClass("active animate__animated animate__backInRight");
      });

      personalInfoBtn.on("click", function(){
        secondFormContainer.removeClass("active animate__animated animate__backInRight");
        firstFormContainer.addClass("active animate__animated animate__backInRight");
      });

      // PASSWORD VISIBILITY TOGGLER
      $(".visibility-container").each(function(index) {
          $(this).on("click", function() {
              const icon = $(this).children()[0]

              if (icon.getAttribute("class") === "fas fa-eye") {
                  icon.setAttribute("class", "fas fa-eye-slash");

                  $(".password-form-input")[index].setAttribute("type", "text");
              } else {
                icon.setAttribute("class", "fas fa-eye");
                  
                $(".password-form-input")[index].setAttribute("type", "password");
              }
          });
      });

      // VALIDATIONS WITH JUST VALIDATE JS

      const editFormValidation = new JustValidate('#edit-form', {
        errorFieldCssClass: 'is-invalid',
      });

      editFormValidation
      .addField('#fname', [
        {
          rule: 'required',
          errorMessage: "Field is required"
        },
        {
          rule: 'minLength',
          value: 3,
        },
        {
          rule: 'maxLength',
          value: 30,
        },
      ])
        .addField('#lname', [
          {
            rule: 'required',
            errorMessage: "Field is required"
          },
          {
            rule: 'minLength',
            value: 3,
          },
          {
            rule: 'maxLength',
            value: 30,
          },
        ])
        .addField('#mobileno', [
          {
            rule: 'required',
            errorMessage: "Field is required"
          },
          {
            rule: 'minLength',
            value: 11,
          },
          {
            rule: 'maxLength',
            value: 11,
          },
        ])
        .onSuccess(() => {
          const form = document.getElementById('edit-form');

          // GATHERING FORM DATA
          const formData = new FormData(form);
          formData.append("submit", true);
          formData.append("user_id", <?php echo($user_details['user_id']) ?>)
              
          //SENDING FORM DATA TO THE SERVER
          $.ajax({
            type: "post",
            url: 'controllers/updateProfile.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
              $("#profile-submit-btn").html("Updating...");
              $("#profile-submit-btn").attr("disabled", true);
            },
            success: function (response) {
              if (response.success === 1) {
                // ALERT USER UPON SUCCESSFUL UPDATE
                Swal.fire({
                  title: "Updated Successfully",
                  icon: "success",
                  text: "Profile changes where made successfully",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                });
              } else {
                $("#profile-submit-btn").attr("disabled", false);
                $("#profile-submit-btn").html("Save Changes");
                    
                if(response.error_title === "fatal"){
                  // REFRESH CURRENT PAGE
                  location.reload();
                }else{
                  // ALERT USER UPON FAILED OPERATION
                  Swal.fire({
                    title: response.error_title,
                    icon: "error",
                    text: response.error_message,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                  });
                }
              }
            },
          });
        });

        const changePassValidation = new JustValidate('#change-pass-form', {
          errorFieldCssClass: 'is-invalid',
        });

          changePassValidation
          .addField('#oldpwd', [
              {
                rule: 'required',
                errorMessage: "Please enter old password"
              },
              {
                rule: 'minLength',
                value: 6,
              }
          ])
          .addField('#newpwd', [
              {
                rule: 'minLength',
                value: 6,
              },
              {
                rule: 'required',
                errorMessage: "Please provide a password"
              }
          ])
          .addField('#cnewpwd', [
              {
                  rule: 'minLength',
                  value: 6,
              },
              {
                  rule: 'required',
                  errorMessage: "Field is required"
              },
              {
                validator: (value, fields) => {
                  if (fields['#newpwd'] && fields['#newpwd'].elem) {
                    const repeatPasswordValue = fields['#newpwd'].elem.value;

                    return value === repeatPasswordValue;
                  }

                  return true;
                  },
                  errorMessage: 'Passwords should be the same',
              }
          ])
          .onSuccess(() => {
              const form = document.getElementById('change-pass-form');

              // GATHERING FORM DATA
              const formData = new FormData(form);
              formData.append("submit", true);
              
              //SENDING FORM DATA TO THE SERVER
              $.ajax({
                type: "post",
                url: 'controllers/changePass.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $("#change-pass-submit-btn").html("Updating...");
                    $("#change-pass-submit-btn").attr("disabled", true);
                },
                success: function (response) {
                  if (response.success === 1) {
                    // ALERT USER UPON SUCCESSFUL PASSWORD CHANGE
                    Swal.fire({
                      title: "Change Successful",
                      icon: "success",
                      text: "Password has been changed successfully.",
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                    });
                  } else {
                    $("#change-pass-submit-btn").attr("disabled", false);
                    $("#change-pass-submit-btn").html("Change Password");
                    
                    if(response.error_title === "fatal"){
                      // REFRESH CURRENT PAGE
                      location.reload();
                    }else{
                      // ALERT USER UPON FAILED OPERATION
                      Swal.fire({
                        title: response.error_title,
                        icon: "error",
                        text: response.error_message,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                      });
                    }
                  }
                },
            });
        });

    </script>
  </body>
</html>
