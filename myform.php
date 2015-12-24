<html>
<head>
<title> </title>
</head>
<body> 
<?php echo validation_errors(); ?> 
<form method="POST"> 
<h3> USERNAME</h3>
<input type="text" name="username" value="" size="50">
<h3> PASSWORD</h3>
<input type="text" name="password" value="" size="50">
<h3>PASSWORD CONFIRM</h3>
<input type="text" name="passconf" value="" size="50">
<h3> EMAIL</h3>
<input type="text" name="email" value="" size="50">
<div> <input type="submit" value="submit" name="button"> </div>
</body>
</html>
