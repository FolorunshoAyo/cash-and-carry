<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  Auth::User("./login");
  
  if(isset($_GET['aid']) && !empty($_GET['aid'])){
    $aid = $_GET['aid'];

    $sql_address = $db->query("SELECT * FROM addresses WHERE address_id={$aid}");
    
    $address_details = $sql_address->fetch_assoc();
  }else{
    header("Location: ./addresses");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" />
  <!-- DASHBOARD MENU CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
  <!-- CDS FORMS STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/form.css" />
  <!-- USER DASHBOARD STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash/edit-address.css" />
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
  <title>Edit address - CDS</title>
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
          <a href="./" class="nav-link"> Dashboard </a>
        </li>
        <li class="nav-link-item">
          <a href="#" class="nav-link"> Items picked </a>
        </li>
        <li class="nav-link-item">
          <a href="./orders">Orders</a>
        </li>
        <li class="nav-link-item active">
          <a href="./addresses" class="nav-link"> Address </a>
        </li>
        <li class="nav-link-item">
          <a href="./profile" class="nav-link"> My profile </a>
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
          <a href="#" class="btn btn-secondary-outline dropdown-toggle header-link" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Browse
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </div>
        <div>
          <a class="header-link" href="../">Homepage</a>
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
            <li class="dashboard-nav-link">
              <a href="./">Dashboard</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="#">Items-picked</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="./orders">Orders</a>
            </li>
            <li class="dashboard-nav-link active">
              <a href="./address">Address</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="./profile">My profile</a>
            </li>
            <li class="dashboard-nav-link logout">
              <a href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="dashboard-main-section">
        <div class="dashboard-main-container">
          <h1 class="dashboard-main-title">Edit Address</h1>

          <p class="dashboard-main-text">
            Here you can edit your address.
            <b>
              Please make sure the information provided below is accurate
            </b>
          </p>


          <div class="edit-address-form-container">
            <form id="edit-form">
              <h2 class="form-header">Address Information</h2>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="text" name="rname" id="rname" class="form-input" placeholder=" "
                    value="<?php echo $address_details['recipient_name'] ?>" required />
                  <label for="rname">Recipient's full name</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="number" name="rphoneno" id="rphoneno" class="form-input" placeholder=" "
                    value="<?php echo $address_details['recipient_phone_no'] ?>" required />
                  <label for="rphoneno">Recipient's phone number</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="text" name="daddress" id="daddress" class="form-input" value="<?php echo $address_details['delivery_address'] ?>"
                    placeholder=" " required />
                  <label for="address">Delivery address</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="text" name="ainfo" id="ainfo" class="form-input" value="<?php echo $address_details['additional_info'] ?>" placeholder=" "
                    required />
                  <label for="ainfo">Additional info</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="text" name="city" id="city" class="form-input" value="<?php echo $address_details['city_name'] ?>" placeholder=" "
                    required />
                  <label for="Ikorodu">City</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <input type="text" name="pcode" id="pcode" class="form-input" value="<?php echo $address_details['address_postalcode'] ?>" placeholder=" "
                    required />
                  <label for="pcode">Zip/Postal code</label>
                </div>
              </div>
              <div class="form-group-container">
                <div class="form-group animate">
                  <select name="state" id="state">
                    <option value="">Choose State</option>
                    <?php
                      $sql_states = $db->query("SELECT * FROM states");

                      while($state = $sql_states->fetch_assoc()){
                        if($state['state_name'] === $address_details['address_state']){
                    ?>
                    <option selected><?php echo $state['state_name'] ?></option>
                    <?php
                        }else{
                    ?>
                    <option><?php echo $state['state_name'] ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                  <label for="state">State</label>
                </div>
              </div>
              <div class="submit-btn-container">
                <button type="submit">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FONT AWESOME JIT SCRIPT-->
  <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  <!-- JQUERY SCRIPT -->
  <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
  <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
  <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
  <!-- JAVASCRIPT BUNDLER WITH POPPER -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
    crossorigin="anonymous"></script>
  <!-- SWEET ALERT PLUGIN -->
  <script src="../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
   <!-- JUST VALIDATE LIBRARY -->
   <script src="../assets/js/just-validate/just-validate.js"></script>
  <!-- CUSTOM DASHBOARD SCRIPT -->
  <script src="../assets/js/user-dash.js"></script>
  <script>
    //FORM VALIDATION WITH VALIDATE.JS

    const validation = new JustValidate("#edit-form", {
      errorFieldCssClass: "is-invalid",
    });

    validation
      .addField("#rname", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#rphoneno", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#daddress", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#ainfo", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#city", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#pcode", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .addField("#state", [
        {
          rule: "required",
          errorMessage: "Field is required",
        },
      ])
      .onSuccess((event) => {
        const form = document.getElementById("edit-form");

        // GATHERING FORM DATA
        const formData = new FormData(form);
        formData.append("submit", true);
        formData.append("aid", <?php echo $aid ?>)

        for (let [key, value] of formData.entries()) {
          console.log(`${key}: ${value}`);
        }

        //SENDING FORM DATA TO THE SERVER
        $.ajax({
          type: "post",
          url: "controllers/edit-address.php",
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          beforeSend: function () {
            $(".submit-btn-container button").html("Editing...");
            $(".submit-btn-container button").attr("disabled", true);
          },
          success: function (response) {
            setTimeout(() => {
              if (response.success === 1) {
                // ALERT USER UPON SUCCESSFUL UPLOAD
                Swal.fire({
                  title: "Address Edited",
                  icon: "success",
                  text: `You've edited your address successfully`,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  confirmButtonColor: '#2366B5',
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.href = "addresses"
                  }
                })
              } else {
                $(".submit-btn-container button").attr("disabled", false);
                $(".submit-btn-container button").html("Save Changes");

                if (response.error_title === "fatal") {
                  // REFRESH CURRENT PAGE
                  location.reload();
                } else {
                  // ALERT USER
                  Swal.fire({
                    title: response.error_title,
                    icon: "error",
                    text: response.error_msg,
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