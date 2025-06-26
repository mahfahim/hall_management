<?php 
session_start();
$defaultAmount = '100.00'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Pay with bKash</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f5f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .payment-box {
      background: #fff;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 350px;
      text-align: center;
    }
    h2 {
      color: #d10057;
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-weight: bold;
      margin-top: 15px;
      margin-bottom: 5px;
      text-align: left;
    }
    input[type="text"], select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f9fafb;
    }
    button {
      margin-top: 20px;
      background-color: #d10057;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }
    button:hover {
      background-color: #b8004a;
    }
  </style>
</head>
<body>

<div class="payment-box">
  <h2>Pay with bKash</h2>
  <form action="bkash/checkout.php" method="post">
    
    <!-- Editable Amount Field -->
    <label for="amount">Amount (BDT)</label>
    <input 
        type="text" 
        id="amount" 
        name="amount" 
        value="<?= htmlspecialchars($defaultAmount) ?>" 
        required 
        pattern="\d+(\.\d{1,2})?" 
        title="Enter a valid amount"
        onfocus="if(this.value=='<?= $defaultAmount ?>') this.value='';"
    >

    <!-- Payment Type Dropdown -->
    <label for="payment_type">Payment Type</label>
    <select id="payment_type" name="payment_type" required>
      <option value="room_rent">Room Rent</option>
      <option value="meal">Meal Charges</option>
      <option value="admission">Admission Fee</option>
      <option value="security_deposit">Security Deposit</option>
      <option value="fine">Fine</option>
      <option value="utility">Utility Bill</option>
      <option value="event">Event Participation</option>
      <option value="maintenance">Maintenance Charges</option>
      <option value="room_transfer">Room Transfer Fee</option>
      <option value="other">Other</option>
    </select>

    <button type="submit">Proceed to Payment</button>
  </form>
</div>

</body>
</html>
