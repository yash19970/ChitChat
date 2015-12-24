<html>
<head>
<title> </title>
</head>
<body> 
<?php echo validation_errors(); ?>
<?php $user_data= $this->session->userdata('userid');
$result_userid= $this->db->query("SELECT * FROM user WHERE userid='$user_data'");
		foreach($result_userid->result_array() as $row)
		{

 ?> 
<form method="POST" enctype="multipart/form-data"> 
<h3> FirstName</h3>
<input type="text" name="fname" value="<?php echo $row['firstname']?>" size="50">
<h3>LastName</h3>
<input type="text" name="lname" value="<?php echo $row['lastname']?>" size="50">
<h3>UserName</h3>
<input type="text" name="username" value="<?php echo $row['username']?>" size="50">
<h3> PASSWORD</h3>
<input type="password" name="password" value="<?php echo $row['password']?>" size="50">
<h3> EMAIL</h3>
<input type="text" name="email" value="<?php echo $row['email']?> " size="50"><br><br>
<input type="file" name="userfile" size="20" />
<div> <input type="submit" value="Update" name="update_button_data"></div>
<div> <br><br>
<br><br>
<?php  } ?>
<a href="<?php echo base_url('sign/info/'); ?>"> BACK </a>
</div>
</form>
</body>
</html>
