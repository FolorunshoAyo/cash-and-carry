<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];
$user_id = $_GET['uid'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="savings_request.php?uid=<?=$user_id?>" method="POST">
  <label for="type_of_savings">Type of Savings:</label>
  <select id="type_of_savings" name="type_of_savings">
    <option value="1">Normal Savings</option>
    <option value="2">Half Savings</option>
  </select>

  <label for="installment_type">Installment Type:</label>
  <select id="installment_type" name="installment_type">
    <option value="1">Daily</option>
    <option value="2">Weekly</option>
    <option value="3">Monthly</option>
  </select>

  <label for="duration_of_savings">Duration of Savings:</label>
  <select id="duration_of_savings" name="duration_of_savings">
    <option value="days">Days</option>
    <option value="weeks">Weeks</option>
    <option value="months">Months</option>
  </select>

  <label for="installment_amount">Installment Amount:</label>
  <input type="text" id="installment_amount" name="installment_amount">

  <label for="target_amount">Target Amount:</label>
  <input type="text" id="target_amount" name="target_amount">

  <input type="submit" name="savings_request" value="REQUEST SAVINGS">
</form>

</body>
</html>