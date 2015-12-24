<html>
<head>
<title>
</title> </head>
<body> <form method="POST">
<?php $userid= $this->session->userdata('userid');
$this->load->model('sign_model');
 $result= $this->sign_model->get_email_by_userid($userid);
foreach($result as $row)
{
	$email_id_by_userid=$row['email'];
}
 ?> 
To:  <input type="text" class="cdsfdf" name="email_to_user" id="dynamic" onKeyup="get_value(); autocomplete='off' "><br><br> 
<div id="dfc"></div>
From: <?php echo "<u><b>".$email_id_by_userid."</b></u>"; ?><br><br>
Subject: <br><textarea name="message_subject" style="margin: 0px; width: 356px; height: 35px;"></textarea><br><br>
Message: <br><textarea name="message_body" rows="5" cols="50" style="margin: 0px; width: 504px; height: 150px;">
</textarea><br><br>
<input type="submit" name="send_message_to_user" value="Send Message!">
</form>
<div> <br><br>
<a href="<?php echo base_url('sign/info'); ?>"> Go Back to Profile!
 </a>
</div><br><br>
<div> <br><br>
<a href="<?php echo base_url('sign/display'); ?>"> Inbox/Outbox </a>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script> 
function get_value()
{ 
	var one = $('#dynamic').val();
	var str = 'dynamic='+one;
	 $.ajax({
               url:"<?php echo base_url('sign/search_like_input');?>",
               type:"POST",
               data:str,
               success:function(data)
               {
               	$('#dfc').html(data);
               }
           });
}
	function get_one(email)
	{
		$('.cdsfdf').val(email);
		$('#dfc').hide();	
	} 
</script>