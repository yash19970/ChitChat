<html>
<head>
<title> </title>
</head>
<body>
<form method="POST">
<?php  $this->session->userdata('userid'); ?> 
<?php echo validation_errors(); ?> 
To:  <?php $email= $_GET['email']; $user_id= $_GET['userid']; echo "<b><u>".$email."</b></u><br><br>";  ?>
<?php $this->load->model('sign_model');
$result= $this->sign_model->get_email_by_userid($user_id);
foreach($result as $row)
{
	$email_id_by_userid=$row['email'];
}
		 ?>
From: <?php echo "<u><b>".$email_id_by_userid."</b></u>"; ?><br><br> 
Subject: <br><textarea name="message_subject" style="margin: 0px; width: 356px; height: 35px;"></textarea><br><br>
Message: <br><textarea name="message_body" rows="5" cols="50" style="margin: 0px; width: 504px; height: 150px;">
</textarea><br><br>
<input type="submit" name="send_message_to_user" value="Send Message!">
<div> <br><br>
<a href="<?php echo base_url('sign/send_message'); ?>"> Go back! </a>
</div>
</form>
</body>
</html>


