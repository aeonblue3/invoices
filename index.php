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
