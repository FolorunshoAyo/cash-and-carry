<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/form.css" />
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css">
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>New Store - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <!-- SPINNER -->
    <div class="spinner-wrapper">
        <div class="spinner-container">
            <img src="<?= $url ?>assets/images/halfcarry-logo.jpeg" alt="Halfcarry Logo">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./stores" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="form-wrapper">
                <h2 class="form-title">New Store</h2>

                <div class="form-container">
                    <form id="agent-upload-form">
                        <div class="form-groupings">
                            <div class="form-group-container">
                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="sname" id="sname" class="form-input" placeholder=" " required />
                                        <label for="sname">Shop name</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="fname" id="fname" class="form-input" placeholder=" " required />
                                        <label for="fname">Shop Owner First Name</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="lname" id="lname" class="form-input" placeholder=" " required />
                                        <label for="lname">Shop Owner Last Name</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="semail" id="semail" class="form-input" placeholder=" " required />
                                        <label for="semail">Shop Owner Email</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="number" name="phoneno" id="phoneno" class="form-input" placeholder=" " required />
                                        <label for="phoneno">Shop Owner Phone</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="reg_no" id="reg_no" class="form-input" placeholder=" " required />
                                        <label for="reg_no">Shop Registeration No</label>
                                    </div>
                                </div>

                                <div class="submit-btn-container">
                                    <button type="submit" class="admin-submit-btn">Create Store</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- METIS MENU JS -->
    <script src="../../assets/js/metismenujs/metismenujs.js"></script>
    <!-- SWEET ALERT PLUGIN -->
    <script src="../../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../../assets/js/just-validate/just-validate.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        //FORM VALIDATION WITH VALIDATE.JS

        const validation = new JustValidate("#agent-upload-form", {
            errorFieldCssClass: "is-invalid",
        });

        validation
            .addField("#sname", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#lname", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#fname", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#semail", [{
                    rule: "required",
                    errorMessage: "Field is required",
                },
                {
                    rule: "email",
                    errorMessage: "Email is invalid!",
                }
            ])
            .addField("#phoneno", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#reg_no", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .onSuccess((event) => {
                const form = document.getElementById("agent-upload-form");

                // GATHERING FORM DATA
                const formData = new FormData(form);
                formData.append("submit", true);
                formData.append("aid", <?php echo $agent_id ?>);


                //SENDING FORM DATA TO THE SERVER
                $.ajax({
                    type: "post",
                    url: "controllers/add_store.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $(".submit-btn-container button").html("Creating...");
                        $(".submit-btn-container button").attr("disabled", true);
                    },
                    success: function(response) {
                        setTimeout(() => {
                            if (response.success === 1) {
                                // ALERT USER UPON SUCCESSFUL UPLOAD
                                Swal.fire({
                                    title: "New Store Added",
                                    icon: "success",
                                    text: `You've created store - ${response.store_name} successfully`,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: '#2366B5',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = "stores";
                                    }
                                })
                            } else {
                                $(".submit-btn-container button").attr("disabled", false);
                                $(".submit-btn-container button").html("Create Store");

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