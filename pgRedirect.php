<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");



$checkSum = "";
$paramList = array();

$ORDER_ID = $_POST["ORDER_ID"];
$CUST_ID = $_POST["CUST_ID"];
$TXN_AMOUNT = $_POST["TXN_AMOUNT"];

// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $_POST["INDUSTRY_TYPE_ID"];
$paramList["CHANNEL_ID"] = $_POST["CHANNEL_ID"];
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

// This is the actual URL on your website where you want to receive the callback after payment
// Make sure this matches your actual domain and path
$paramList["CALLBACK_URL"] = "http://localhost/proj/pgResponse.php";

/*
$paramList["CALLBACK_URL"] = "http://localhost:3308/PaytmKit/pgResponse.php";
$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
$paramList["EMAIL"] = $EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //

*/

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Processing Payment...</title>
	<style>
		body { 
			font-family: Arial, sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			background-color: #f5f5f5;
		}
		.container {
			text-align: center;
			padding: 20px;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		.spinner {
			width: 50px;
			height: 50px;
			border: 5px solid #f3f3f3;
			border-top: 5px solid #3498db;
			border-radius: 50%;
			animation: spin 1s linear infinite;
			margin: 20px auto;
		}
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>Please wait...</h2>
		<div class="spinner"></div>
		<p>Redirecting to payment gateway</p>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
		</form>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</div>
</body>
</html>