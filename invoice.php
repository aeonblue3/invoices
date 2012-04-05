<?
error_reporting(E_ALL);
# For testing purposes only
include('../dev/sohoadmin/program/includes/shared_functions.php');
#echo testArray($_POST);
#echo testArray($_POST['activity']);
setlocale(LC_MONETARY, 'en_GB');
function formatMoney($amount, $format)
{
    $format = "/".$format."/";
	$money = preg_replace($format, "", money_format('%i', $amount));
	return $money;
}

/* Takes the tax rate as a whole number and the subtotal of 	*/
/* the order and returns the amount of tax to be paid. Does 	*/
/* not return the subTotal plus tax. 							*/
function getTaxRate($rate, $subTotal)
{
	$tax = (float)$rate / 100;
	$taxRate = (float)$subTotal * (float)$tax;
	return $taxRate;
}

function errorCheck($line)
{
	echo $line;
	exit;
}
function wwwcopy($link,$file) 
{ 
//	$fp = @fopen($link,"r"); 
//	while(!feof($fp)) 
//	{ 
//		$cont.= fread($fp,1024); 
//	} 
//	fclose($fp); 

	$fp2 = @fopen($file,"w"); 
	fwrite($fp2,$link); 
	fclose($fp2); 
}
if ($_POST['process'] == 'todo')

{
	$test = 0;
	if ($test == 1)
	{
		echo testArray($_POST);
		echo testArray($_POST['activity']);
		echo testArray($_POST['quantity']);
		echo testArray($_POST['rate']);
	}
	$invoiceNumber = $_POST['invoiceNumber'];
	$date = $_POST['date'];
	$terms = $_POST['terms'];
	$dueDate = $_POST['dueDate'];
	$taxPercentage = $_POST['taxPercentage'];
	$name = $_POST['name'];
	$address = $_POST['address'];

    # Set the currency symbol
    $currencySymbol = $_POST['currencySymbol'];
	# These are arrays
	$activity = $_POST['activity'];
	$quantity = $_POST['quantity'];
	$rate = $_POST['rate'];
	
	$swift = $_POST['swift'];
	$routing = $_POST['routing'];
	$acctName = $_POST['acctName'];
	$acctNumber = $_POST['acctNumber'];

	$numberOfItems = count($activity);

	$subTotal = 0;
	$invoiceItems = "";
	for ($i = 0; $i < $numberOfItems; $i++)
	{
		$thisAmount = $quantity[$i] * $rate[$i];
		$subTotal = $subTotal + $thisAmount;
		$invoiceItems .= "\t\t<tr>\n";
		$invoiceItems .= "<td>•".$activity[$i]."\t\t\t</td><td class=\"rightText\">".$quantity[$i]."</td>\n\t\t\t<td class=\"rightText\">".formatMoney($rate[$i])."</td>\n\t\t\t<td class=\"rightText\">".formatMoney($thisAmount)."</td>\n";
		$invoiceItems .= "\t\t</tr>\n";
	}
	($taxPercentage == "") ? $taxPercentage = 0 : "";
	$subTotal = formatMoney($subTotal);
	$taxAmount = getTaxRate($taxPercentage, $subTotal);
	$amountDue = $taxAmount + $subTotal;
	$taxAmount = formatMoney($taxAmount);
	$amountDue = formatMoney($amountDue);

	# Soho Bank Info
	$sohoBankInfo = "<p class=\"bankInfo\">Wire Transfer Instructions (In GBP):<br />";
	$sohoBankInfo .= "To: Regions Bank, Birmingham, AL, USA<br />";
	$sohoBankInfo .= "Swift #: ".$swift."<br />";
	$sohoBankInfo .= "ABA Routing: ".$routing."<br />";
	$sohoBankInfo .= "Customer Account Name: ".$acctName."<br />";
	$sohoBankInfo .= "Customer Account Number: ".$acctNumber."</p>";
	
} else {
	exit;
}
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Invoice Creator</title>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-language" content="en">
	<meta http-equiv="Content-Style-Type" content="text/css">
		
	<!-- this one is for iPod / iPhone: forces the content to always fit the window -->
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">  
	<meta name="DC.language" content="en">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="main">
	<h1>Soholaunch.com, Inc.</h1>
	<div id="sohoAddress">
		<p>Soholaunch.com, Inc.<br />
		240 Forrest Lake Drive, NW<br />
		Atlanta, GA 30327</p>
		<p>(678) 261-4030<br />
		sales@soholaunch.com</p>
	</div>
	<div id="invoiceInfo">
		<h2>INVOICE</h2>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<th bgcolor="#cccccc" class="centerText">DATE</th><th bgcolor="#cccccc" class="centerText">INVOICE #</th>
			</tr>
			<tr>
			<td class="centerText"><?php echo $date; ?></td><td class="centerText"><?php echo $invoiceNumber; ?></td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" class="centerText">TERMS</th><th bgcolor="#cccccc" class="centerText">DUE DATE</th>
			</tr>
			<tr>
				<td class="centerText bottomBorder"><?php echo $terms; ?></td><td class="centerText bottomBorder"><?php echo $dueDate; ?></td>
			</tr>
		</table>
	</div>
	<div style="clear: both;"></div>
	<div id="billTo">
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<th bgcolor="#cccccc">BILL TO</th>
			</tr>
			<tr>
				<td class="bottomBorder"><?php echo $name; echo "<pre>".$address."</pre>";?></td>
			</tr>
		</table>
	</div>
	<div id="amountDue">
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<th bgcolor="#cccccc" class="centerText">AMOUNT DUE</th><th bgcolor="#cccccc" class="centerText">ENCLOSED</th>
			</tr>
			<tr>
				<td class="rightText bottomBorder">£<?php echo $amountDue; ?></td><td class="bottomBorder"></td>
			</tr>
		</table>
	</div>
	<div style="clear: both;"></div>
	<div id="orderSep">
		<p class="seperator">Please detach top portion and return with your payment.</p>
	</div>
	<div id="invoiceBody">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td colspan="3" class="null"></td><th bgcolor="#cccccc" class="centerText">Sales Rep</th>
			</tr>
			<tr>
				<td colspan="3" class="null"></td><td class="centerText">House</td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" width="61%" class="centerText">Activity</th><th bgcolor="#cccccc" width="13%" class="centerText">Quantity</th><th bgcolor="#cccccc" width="13%" class="centerText">Rate</th><th bgcolor="#cccccc" width="13%" class="centerText">Amount</th>
			</tr>
			<?php
				echo $invoiceItems;
			?>
			<tr>
				<td rowspan="3" class="null topBorder "><?php echo $sohoBankInfo; ?></td><td colspan="2" class="rightText topBorder bottomBorder">SUBTOTAL</td><td class="rightText topBorder bottomBorder">£<?php echo $subTotal; ?></td>
			</tr>
			<tr>
				<td colspan="2" class="rightText">TAX</td><td class="rightText">£<?php echo $taxAmount; ?></td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" colspan="2" class="rightText bottomBorder">TOTAL</th><th bgcolor="#cccccc" class="rightText bottomBorder">£<?php echo $amountDue; ?></th>
			</tr>
		</table>
	</div>
<?php

	$varOutput = ob_get_contents();
	ob_end_clean();

	echo $varOutput;
	wwwcopy($varOutput, "invoice_".$invoiceNumber.".html");
//	echo "<a href=\"makepdf.php?file=invoice_".$invoiceNumber."\">Make PDF invoice</a>";
?>
