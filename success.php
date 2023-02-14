<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="icon" href="assets/images/logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Custom CSS (HOME)) -->
    <link rel="stylesheet" href="assets/css/success.css" type="text/css">
    <!-- MEDIA QUERIES (MAIN) -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Registeration successful - CDS</title>
</head>
<body>
    <div class="success-wrapper">
        <div class="success-container">
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            <h2 class="success-title">Nice! Welcome to <span>CDS!</span></h2>
            <p class="success-text">Please wait, you will be redirected soon</p>
        </div>
    </div>
     <!-- FONT AWESOME JIT SCRIPT-->
     <script
     src="https://kit.fontawesome.com/3ae896f9ec.js"
     crossorigin="anonymous"
   ></script>
   <script>
        setTimeout(()=> {
            window.location.replace("login");
        }, 3500);
   </script>
</body>
</html>