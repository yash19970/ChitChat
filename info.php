<?php 

echo "  User is logged  ";

?>
<?php if($this->session->userdata('username') || $this->session->userdata('userid') )
	{
		$userid= $this->session->userdata('userid');
		//echo $userid;
		?>	<br><br><a href="logout">Logout </a>
			<br> <br><a href="update_info"> Update Info</a>
			<br> <br><a href="send_message"> Message Profile</a>
			<div style=" text-align: right ; padding-right: 200px;"> Online Users: </div>
			<?php 
			$this->load->model('sign_model');
			$online_users = $this->sign_model->check_user($userid);
			echo " <div style= 'text-align: right ; padding-right: 200px;'>";
			foreach($online_users as $key)
			{
				echo "<div style= 'color: green;'><li>".$key['userid']."</li>";
			}
			echo " </div> </div> ";
	}
	else {
			redirect('sign/login_function');
		} ?>
