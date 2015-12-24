<html>
<head>
<title> </title>
</head>
<body> 
<?php echo validation_errors(); ?> 
<form method="POST" enctype="multipart/form-data"> 
<h3> FirstName</h3>
<input type="text" name="fname" value="" size="50">
<h3>LastName</h3>
<input type="text" name="lname" value="" size="50">
<h3>UserName</h3>
<input type="text" name="username" value="" size="50">
<h3> PASSWORD</h3>
<input type="password" name="password" value="" size="50">
<h3> CONFIRM PASSWORD</h3>
<input type="password" name="confpasssword" value="" size="50">
<h3> EMAIL</h3>
<input type="text" name="email" value="" size="50"><br><br>
<input type="file" name="userfile" size="20" />
<div> <input type="submit" value="submit" name="signup_button_data"></div>
<div> <br><br>
<br><br>
<a href="<?php echo base_url('sign/login_function/'); ?>"> LOGIN </a>
</div>
</form>
</body>
</html>
