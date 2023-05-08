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
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css">
    <!-- SUMMERNOTE TEXT EDITOR CSS -->
    <link rel="stylesheet" href="../../assets/css/summernote-lite.min.css" />
    <!-- ADMIN PRODUCTS CSS -->
    <!-- <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/add-product.css"> -->
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Add a new product - Halfcarry Agent</title>
    <style>
        .summer-note-container.textarea{
            all: revert;
        }

        .summer-note-container.textarea label[for="pdesc"]{
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.5rem;
            display: inline-block;
        }

        .note-editable *, .note-editable *:hover{
            all: revert !important;
        }

        .note-editable{
            background-color: var(--white);
            font-size: 1.5rem;
        }

    </style>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./products" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="form-wrapper">
                <h2 class="form-title">Add a New Product</h2>

                <div class="form-container">
                    <form id="product-upload-form">
                        <div class="form-groupings">
                            <div class="form-group-container">
                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="pname" id="pname" class="form-input" placeholder=" " required />
                                        <label for="pname">Product Name</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="file" multiple name="pimages[]" id="pimages" class="form-input" placeholder=" " required />
                                        <label for="pimages">Upload media</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="pprice" id="pprice" class="form-input format" placeholder=" " required />
                                        <label for="pprice">Price</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select name="duration" id="duration" class="form-input">
                                            <option value="">Choose Option</option>
                                            <option vallue="3">3 Months</option>
                                            <option value="4">4 Months</option>
                                        </select>
                                        <label for="duration">Duration of installmental payments in months</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="summer-note-container textarea">
                                        <label for="pdesc">Enter product details here</label>
                                        <textarea name="pdesc" id="pdesc" class="form-input" placeholder=" " required>
                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select id="category" name="category" id="category">
                                            <option value="">Choose option</option>
                                            <?php
                                            $sql_categories = $db->query("SELECT * FROM product_categories");
                                            while ($row_category = $sql_categories->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo ($row_category['category_id']); ?>"><?php echo ($row_category['category_name']); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="category">Category</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select name="visible" id="visible">
                                            <option value="">Choose option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <label for="visible">Visibile</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select name="sid" id="sid">
                                            <option value="">Choose option</option>
                                            <?php
                                                $get_stores = $db->query("SELECT * FROM stores WHERE agent_id={$agent_id}");

                                                while($store_details = $get_stores->fetch_assoc()){
                                            ?>
                                            <option value="<?= $store_details['id']?>"><?= $store_details['name'] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <label for="sid">Store Owner</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="in_stock" id="in_stock" class="form-input format" placeholder=" " required />
                                        <label for="in_stock">Number of Items in stock</label>
                                    </div>
                                </div>

                                <div class="submit-btn-container">
                                    <button type="submit" class="admin-submit-btn">Add product</button>
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
    <!-- SUMMER NOTE JS -->
    <script src="../../assets/js/summernote-lite.min.js"></script>
    <!-- SUMMER NOTE LANG -->
    <script src="../../assets/js/summernote-es-ES.min.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $('#pdesc').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });


        // COVERT NUMBER TO READABLE FORM
        $('input.format').keyup(function(event) {
            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });


        //RESET TEXTAREA CURSOR
        function setSelectionRange(input, selectionStart, selectionEnd) {
            if (input.setSelectionRange) {
                input.focus();
                input.setSelectionRange(selectionStart, selectionEnd);
            } else if (input.createTextRange) {
                var range = input.createTextRange();
                range.collapse(true);
                range.moveEnd('character', selectionEnd);
                range.moveStart('character', selectionStart);
                range.select();
            }
        }

        function setCaretToPos(input, pos) {
            setSelectionRange(input, pos, pos);
        }

        $("#pdesc").on("click", function() {
            if ($("#pdesc").val().trim().length === 0) {
                setCaretToPos(document.getElementById("pdesc"));
            }
        });

        //FORM VALIDATION WITH VALIDATE.JS

        const validation = new JustValidate("#product-upload-form", {
            errorFieldCssClass: "is-invalid",
        });

        validation
            .addField("#pname", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#pprice", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#duration", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#category", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#in_stock", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#sid", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#visible", [{
                rule: "required",
                errorMessage: "Field is required",
            }, ])
            .addField("#pimages", [{
                    rule: 'minFilesCount',
                    value: 1,
                },
                {
                    rule: 'maxFilesCount',
                    value: 5,
                },
                {
                    rule: 'files',
                    value: {
                        files: {
                            extensions: ['jpeg', 'png', 'jpg'],
                            maxSize: 3000000,
                            minSize: 1000,
                            types: ['image/jpeg', 'image/png'],
                        },
                    },
                },
            ])
            .onSuccess((event) => {
                const pdesc = $(".note-editable").html().trim();
                if(pdesc.length === 0) { alert("Please provide a product description"); return; }
                const form = document.getElementById("product-upload-form");

                // GATHERING FORM DATA
                const formData = new FormData(form);
                formData.append("submit", true);
                formData.set("pdesc", pdesc);

                // CONVERTING FORMATTED(HUMAN READABLE) FIELDS BACK TO NUMBER 
                const formatedFields = [];

                for (let [key, value] of formData.entries()) {
                    if (key === "pprice" || key === "in_stock") {
                        formatedFields.push(value);
                    }
                }

                const modifiedFormatedFields = formatedFields.map(value => value.replace(/,/g, ""));
                formData.set("pprice", modifiedFormatedFields[0]);
                formData.set("in_stock", modifiedFormatedFields[1]);

                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                //SENDING FORM DATA TO THE SERVER
                $.ajax({
                    type: "post",
                    url: "controllers/add_product.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    enctype: "multipart/form-data",
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $(".submit-btn-container button").html("Adding...");
                        $(".submit-btn-container button").attr("disabled", true);
                    },
                    success: function(response) {
                        setTimeout(() => {
                            if (response.success === 1) {
                                // ALERT USER UPON SUCCESSFUL UPLOAD
                                Swal.fire({
                                    title: "Product Added",
                                    icon: "success",
                                    text: `You've added ${response.product_name} successfully`,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: '#2366B5',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = "products"
                                    }
                                })
                            } else {
                                $(".submit-btn-container button").attr("disabled", false);
                                $(".submit-btn-container button").html("Add product");

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