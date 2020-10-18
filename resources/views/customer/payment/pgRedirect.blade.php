<html>

<head>
	<title>Merchant Check Out Page</title>
</head>

<body>
	<center>
		<h1><b>Please do not refresh this page...!</b></h1>
		<h2>Redirecting into Payment Gateway...!</h2>
		<h3>Please Wait...!</h3>
	</center>
	<form method="post" action="<?= PAYTM_TXN_URL; ?>" name="f1">
		@csrf
		<table border="1">
			<tbody>
				<?php
				foreach ($paramList as $name => $value) {
					echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
				}
				?>
				<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>

</html>