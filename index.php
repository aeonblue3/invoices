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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.css">

	<script type="text/javascript">
	$(document).ready(function(){
		$("#addAnother").click(function(e){
			e.preventDefault();
			var html = '<div class="control-group">\t\n<label class="control-label">Activity:</label><div class="controls"><textarea name="activity[]" type="text" class="input-xlarge" value=""></textarea></div><br /><br />\t\t\n<label class="control-label">Quantity:</label><div class="controls"><input type="text" name="quantity[]" value="" /></div><br /><br />\t\t\n<label class="control-label">Rate:</label><div class="controls"><input type="text" name="rate[]" value="75.00" /></div>\t\n</div>';
			$('#addAnother').before(html);
		});
	});
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="index.php">Invoice Creator</a>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4">
			<h2>Invoices</h2>
<?php
$thisDir = opendir(".");
while ($dirItem = readdir($thisDir))
{
	if (preg_match("/\.html/", $dirItem))
		$dirArray[] = $dirItem;
}
closedir($thisDir);
$dirItem = sort($dirArray);
$index = count($dirArray);
?>
				<table class="table table-striped table-condensed">
<?php
for ($i = 0; $i < $index; $i++)
{
	echo "\t\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t<a href=\"".$dirArray[$i]."\" target=\"_BLANK\">".$dirArray[$i]."</a>\n";
	echo "\t\t\t\t\t\t</td>\n";
	echo "\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t".date("M jS, Y h:i:s", filemtime($dirArray[$i]))."\n";
	echo "\t\t\t\t\t\t</td>\n";
	echo "\t\t\t\t\t</tr>\n";
}
?>
				</table>
			</div>
			<div class="span8">
				<form method="post" action="invoice.php" name="invoiceInsert" class="form-horizontal">
					<input type="hidden" name="process" value="todo" />
					<fieldset>
						<legend>Invoice Data</legend>
						<div class="control-group">
							<label class="control-label" for="invoiceNumber">Invoice Number:</label>
							<div class="controls"><input class="input-xlarge" type="text" name="invoiceNumber" value="" placeholder="Enter Invoice Number" /><br /><br /></div>
							<label class="control-label" for="date">Date:</label>
							<div class="controls"><input class="input-xlarge" type="text" name="date" value="" placeholder="<?php echo date("m/d/Y"); ?>" /><br /><br /></div>
							<label class="control-label" for="terms">Terms:</label>
							<div class="controls"><input class="input-xlarge" type="text" name="terms" value="Due on receipt" /><br /><br /></div>
							<label class="control-label" for="dueDate">Due Date:</label>
							<div class="controls"><input class="input-xlarge" type="text" name="dueDate" value="" placeholder="<?php echo date("m/d/Y"); ?>" /><br /><br /></div>
							<label class="control-label" for="taxPercentage">Tax Rate (Enter a percentage):</label>
							<div class="controls"><input class="input-xlarge" type="text" name="taxPercentage" value="" placeholder="" /> %</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Bill To</legend>
						<div class="control-group">
							<label class="control-label">Name:</label><div class="controls"><input type="text" class="input-xlarge" name="name" value="Simon Collin" /><br /><br /></div>
							<label class="control-label">Address:</label><div class="controls"><textarea name="address" class="input-xlarge" rows="10" cols="25"><?php echo "LexisNexis Butterworths (Reed Elsevier)\n2Addiscombe Road\nCroydon\nCR9 5AF\nGB"; ?></textarea></div>
						</div>
					</fieldset>
					<fieldset id="items">
						<legend>Billable Items</legend>
						<div class="control-group">
							<label class="control-label">Activity:</label>
							<div class="controls"><textarea name="activity[]" class="input-xlarge" type="text" value=""></textarea></div>
							<br /><br />
							<label class="control-label">Quantity:</label>
							<div class="controls"><input type="text" name="quantity[]" class="input-xlarge" value="" /></div>
							<br /><br />
							<label class="control-label">Rate:</label>
							<div class="controls"><input type="text" name="rate[]" class="input-xlarge" value="75.00" /></div>
							<br /><br />
						</div>
						<button id="addAnother" class="btn btn-success">Add Another</button>
					</fieldset>
                    <fieldset>
						<legend>General Options</legend>
						<div class="control-group">
							<label class="control-label">Curreny Symbol:</label>
							<div class="controls">
                                <select name="currencySymbol">
    								<option>USD</option>
    								<option>GBP</option>
                                    <option>AED</option>
									<option>AFN</option>
									<option>ALL</option>
									<option>AMD</option>
									<option>ANG</option>
									<option>AOA</option>
									<option>ARS</option>
									<option>AUD</option>
									<option>AWG</option>
									<option>AZN</option>
									<option>BAM</option>
									<option>BBD</option>
									<option>BDT</option>
									<option>BGN</option>
									<option>BHD</option>
									<option>BIF</option>
									<option>BMD</option>
									<option>BND</option>
									<option>BOB</option>
									<option>BRL</option>
									<option>BSD</option>
									<option>BTN</option>
									<option>BWP</option>
									<option>BYR</option>
									<option>BZD</option>
									<option>CAD</option>
									<option>CDF</option>
									<option>CHF</option>
									<option>CLP</option>
									<option>CNY</option>
									<option>COP</option>
									<option>CRC</option>
									<option>CUC</option>
									<option>CUP</option>
									<option>CVE</option>
									<option>CZK</option>
									<option>DJF</option>
									<option>DKK</option>
									<option>DOP</option>
									<option>DZD</option>
									<option>EGP</option>
									<option>ERN</option>
									<option>ETB</option>
									<option>EUR</option>
									<option>FJD</option>
									<option>FKP</option>
									<option>GEL</option>
									<option>GGP</option>
									<option>GHS</option>
									<option>GIP</option>
									<option>GMD</option>
									<option>GNF</option>
									<option>GTQ</option>
									<option>GYD</option>
									<option>HKD</option>
									<option>HNL</option>
									<option>HRK</option>
									<option>HTG</option>
									<option>HUF</option>
									<option>IDR</option>
									<option>ILS</option>
									<option>IMP</option>
									<option>INR</option>
									<option>IQD</option>
									<option>IRR</option>
									<option>ISK</option>
									<option>JEP</option>
									<option>JMD</option>
									<option>JOD</option>
									<option>JPY</option>
									<option>KES</option>
									<option>KGS</option>
									<option>KHR</option>
									<option>KMF</option>
									<option>KPW</option>
									<option>KRW</option>
									<option>KWD</option>
									<option>KYD</option>
									<option>KZT</option>
									<option>LAK</option>
									<option>LBP</option>
									<option>LKR</option>
									<option>LRD</option>
									<option>LSL</option>
									<option>LTL</option>
									<option>LVL</option>
									<option>LYD</option>
									<option>MAD</option>
									<option>MDL</option>
									<option>MGA</option>
									<option>MKD</option>
									<option>MMK</option>
									<option>MNT</option>
									<option>MOP</option>
									<option>MRO</option>
									<option>MUR</option>
									<option>MVR</option>
									<option>MWK</option>
									<option>MXN</option>
									<option>MYR</option>
									<option>MZN</option>
									<option>NAD</option>
									<option>NGN</option>
									<option>NIO</option>
									<option>NOK</option>
									<option>NPR</option>
									<option>NZD</option>
									<option>OMR</option>
									<option>PAB</option>
									<option>PEN</option>
									<option>PGK</option>
									<option>PHP</option>
									<option>PKR</option>
									<option>PLN</option>
									<option>PYG</option>
									<option>QAR</option>
									<option>RON</option>
									<option>RSD</option>
									<option>RUB</option>
									<option>RWF</option>
									<option>SAR</option>
									<option>SBD</option>
									<option>SCR</option>
									<option>SDG</option>
									<option>SEK</option>
									<option>SGD</option>
									<option>SHP</option>
									<option>SLL</option>
									<option>SOS</option>
									<option>SP</option>
									<option>SRD</option>
									<option>STD</option>
									<option>SVC</option>
									<option>SYP</option>
									<option>SZL</option>
									<option>THB</option>
									<option>TJS</option>
									<option>TMT</option>
									<option>TND</option>
									<option>TOP</option>
									<option>TRY</option>
									<option>TTD</option>
									<option>TVD</option>
									<option>TWD</option>
									<option>TZS</option>
									<option>UAH</option>
									<option>UGX</option>
									<option>UYU</option>
									<option>UZS</option>
									<option>VEF</option>
									<option>VND</option>
									<option>VUV</option>
									<option>WST</option>
									<option>XAF</option>
									<option>XCD</option>
									<option>XDR</option>
									<option>XOF</option>
									<option>XPF</option>
									<option>YER</option>
									<option>ZAR</option>
									<option>ZMK</option>
									<option>ZWD</option>

                                </select>
                            </div>
							<br /><br />
							<label class="control-label">ABA Routing Number:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="routing" value="062005690" /></div>
							<br /><br />
							<label class="control-label">Customer Account Name:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="acctName" value="Soholaunch.com, Inc." /></div>
							<br /><br />
							<label class="control-label">Customer Account Number:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="acctNumber" value="64 1301 9721" /></div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Bank Options</legend>
						<div class="control-group">
							<label class="control-label">Swift#:</label>
							<div class="controls"><input name="swift" class="input-xlarge" type="text" value="UPNBUS44" /></div>
							<br /><br />
							<label class="control-label">ABA Routing Number:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="routing" value="062005690" /></div>
							<br /><br />
							<label class="control-label">Customer Account Name:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="acctName" value="Soholaunch.com, Inc." /></div>
							<br /><br />
							<label class="control-label">Customer Account Number:</label>
							<div class="controls"><input type="text" class="input-xlarge" name="acctNumber" value="64 1301 9721" /></div>
						</div>
					</fieldset>
					<input type="submit" class="btn btn-primary" name="submit" value="submit" />
				</form>
			</div>
		</div>
	</div>
</body>
</html>
