<?php
require(dirname(__DIR__).'/auth-library/resources.php');
Auth::Route("./user/");
$url = strval($url);

if(isset($_POST['submit'])) {
	$email = $db->real_escape_string($_POST['email']);

	$result = $db->query("SELECT * FROM users WHERE email='{$email}'");
    if($result->num_rows == 1) {
      $otp = rand(100000, 999999);
      $token = md5($otp);
      $row = $result->fetch_assoc();
      $uname = $row['first_name'];

      $sql = "INSERT INTO reset_tokens(user_email, token) VALUES(?,?)";
      $statement = $db->prepare($sql);
      $statement->bind_param("ss", $email, $token);
      if ($statement->execute()) {
        $subject = "CDS Reset Password";
        $link = $url . "reset_password?a=new_pass&auth=".$token;
        $_SESSION['reset_link'] = $link;
        $msg = "<div class='container'>
                      <div class='box'>
                        <b><h2>Hello $uname!</h2></b>
                        <p>Kindly click on the button below to reset your password</p>
                        <a href='$link'><button style='background-color:green; color:white; padding:15px; border:0; border-radius:5px;'>Reset Password</button></a>
                        <p>If the button does not work, kindly click the link below</p>
                        <a href='$link'>$link</a>
                        <br><br>
                        <p class='warn'>If you did not initate this action, just delete this email or ignore</p>
                      </div>
    			</div>";
        $_SESSION['success'] = 1;
        send_raw_mail($email, $subject, $msg);
		    header("location: ".$url."check_mail");
      }
      
    }else {
      $_SESSION['error'] = 1;      
      header("location: ".$url."forgot_password");
    }
	

}else{
	header("location: ".$url);
}
?>