<?php date_default_timezone_set('Asia/Calcutta'); ?>
<?php 
class Sign extends CI_Controller{
	 var $result="";
	 function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('sign_model');
	}
	public function index(){
		if(!empty($_POST['signup_button_data']))
		{
			$this->form_validation->set_rules('fname','FirstName','required|min_length[4]|maxlength[25]|alpha');
			$this->form_validation->set_rules('lname','LastName','required|min_length[4]|max_length[25]|alpha');
			$this->form_validation->set_rules('username','Username','required|min_length[4]|alpha_numeric|is_unique[user.username]');
			$this->form_validation->set_rules('password','Password','required|min_length[2]');
			$this->form_validation->set_rules('password','Password','required|min_length[2]|matches[password]');
			$this->form_validation->set_rules('email','Email','required|min_length[4]|is_unique[user.email]');
			$config['upload_path'] = 'photo/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			if($this->form_validation->run()==FALSE)
			{
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('sign_up',$error);
			}
			else
			{
				if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '')
				{
					$date = date("ymdhis");
					$config['upload_path'] = 'photo/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					
					$subFileName = explode('.',$_FILES['userfile']['name']);
					$ExtFileName = end($subFileName);
					$config['file_name'] = md5($date.$_FILES['userfile']['name']).'.'.$ExtFileName;
                    
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('userfile'))
					{  
                         $upload_data = $this->upload->data();
						 $userfile = $config['upload_path'].$upload_data['file_name'];
					}else
					{					
						$this->data['err']= $this->upload->display_errors();
					}
				}
				$table_name ='user';
				$file = array('firstname' =>$_POST['fname'], 'lastname'=>$_POST['lname'], 'username'=> $_POST['username'], 'password'=>$_POST['password'], 'email'=>$_POST['email'], 'img_name'=>$config['file_name'] );
				$data = $this->upload->data();
				$result = $this->sign_model->insert_data($table_name,$file);
				$data = array('upload_data' => $this->upload->data());
				$this->upload->display_errors();
				if($result) $this->load->view('success_sign');
			}

		}
		else  $this->load->view('sign_up');
}
	public function login_function()
	{
		if(isset($_POST['login_button_data']))
		{
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');
			if($this->form_validation->run()==FALSE)
			{
				$this->load->view('login_page');
			}
			else
			{
				$username= $_POST['username'];
		 		$password= $_POST['password'];
				$result = $this->sign_model->userlogin_data($username,$password);
				redirect('sign/info');
			}
		}
		else $this->load->view('login_page');
	}
	public function info()
	{
		 $user_data= $this->session->userdata('userid'); 
		if($user_data)
		{
			$result_userid= $this->db->query("SELECT * FROM user WHERE userid='$user_data'");
			foreach($result_userid->result_array() as $row)
			{
				?>
				<img alt="uploaded image" src="<?=base_url().'photo/'.$row['img_name']?>" height="270" width="300">
				<?php
				echo " <br><br>E-mail: ".$row['email']."<br>";
				echo " lastname: ".$row['lastname']."<br>"; 
			} 
			if($user_data);
				echo "User Id: ".$user_data."<br>";
		}	
		$this->load->view('info');		
	}
	public function logout(){
		$userid= $this->session->userdata('username');
		echo "Last user logged out: ".$userid;
		$logout= $this->session->unset_userdata('userid');
		$logout_userid= $this->session->unset_userdata('username');
		if($logout || $logout_userid) ?> <br> <br><a href="index"> Sign In <br> <br> <a href="login_function"> Log In </a><?php 
	} 
	public function update_info()
	{
		$userid= $this->session->userdata('userid');
		$table_name= 'user';
		if(!empty($_POST['update_button_data']))
			{	
				if(isset($_FILES['userfile']['name']) || $_FILES['userfile']['name'] == '')
				{
					$date = date("ymdhis");
					$config['upload_path'] = 'photo/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe';
					
					$subFileName = explode('.',$_FILES['userfile']['name']);
					$ExtFileName = end($subFileName);
					$config['file_name'] = md5($date.$_FILES['userfile']['name']).'.'.$ExtFileName;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('userfile'))
					{  
                         $upload_data = $this->upload->data();
						 $userfile = $config['upload_path'].$upload_data['file_name'];
					}else
					{					
						$this->data['err']= $this->upload->display_errors();
					}
				}
					$updated_user_data = array('firstname' =>$_POST['fname'], 'lastname'=>$_POST['lname'], 'username'=> $_POST['username'], 'password'=>$_POST['password'], 'email'=>$_POST['email'],'img_name'=>$config['file_name']);
					$data = $this->upload->data();
					$result_update_data= $this->sign_model->update_value($table_name,$updated_user_data,$userid);
					$data = array('upload_data' => $this->upload->data());
					$this->upload->display_errors();
					$this->load->view('success_update');
			}
			else 
			{
				$this->load->view('update_view');
			}	
	} 
	public function get_user_by_gmail()
	{ 
		$table_name= 'user';
		$gname= $_POST['gmail_name'];
		$gmail_id= $_POST['gmail_id'];
		$user_gmail_info  = array('gname' =>$_POST['gmail_name'],'email'=>$_POST['gmail_id']);
		$check_var = $this->sign_model->check($gmail_id);
		if($check_var)
		{
			$result = $this->sign_model->insert_gmail_data($table_name,$user_gmail_info);
		}
		else 
		{
			$result = $this->sign_model->update_gmail_data($table_name,$user_gmail_info,$gmail_id);	
		}	
		$this->session->set_userdata('userid',$result);
		if($result) {
			echo '1000'; exit;
		}
		else
		{
			echo '2000';
			exit;
		}
	} 
	public function send_message()
	{
		$time = date('dS F,Y | g:i:s A');
		$userid = $this->session->userdata('userid');
		echo "<b>&nbsp&nbsp&nbsp&nbsp&nbsp Users list:</b><br><br>";
		$userid_from = $this->session->userdata('userid');
		if(!empty($_POST['send_message_to_user']))
		{	
			$this->form_validation->set_rules('email_to_user','Subject','required');
			$this->form_validation->set_rules('message_subject','Subject','required|min_length[2]|maxlength[42]');
			$this->form_validation->set_rules('message_body','Message','required|min_length[4]|max_length[144]');
			if($this->form_validation->run()==TRUE)
			{
				$emailid_to= $_POST['email_to_user'];
				$result=  $this->sign_model->get_userid_by_email($emailid_to);
				foreach($result as $row)
				{
					 $email_id_to = $row['userid'];
				} 
				$table_name= 'message';
				$message_data = array('subject' => $_POST['message_subject'], 'message'=> $_POST['message_body'], 'userid_from'=>$userid_from, 'userid_to'=>$email_id_to,'time'=>$time);
				$result_send_data= $this->sign_model->insert_message_data($table_name,$message_data);
				if($result_send_data)
				{
					redirect('sign/success');				
				}
			}
		}
		 $this->load->view('send');
	}
	public function success()
	{
		$this->load->view('success');
	}
	public function display()
	{
		$this->load->view('inbox_outbox');
	}
	public function search_like_input()
	{
	    $dynamic= $_POST['dynamic'];
	    $userid = $this->session->userdata('userid');
	    $result_get= $this->sign_model->get_email_by_userid($userid);
	    foreach($result_get as $key)
	    {
	    	$email_id_session = $key['email'];
	    }
		$result_search_query = $this->db->query("SELECT * FROM user WHERE email LIKE '%$dynamic%' AND email!= '{$email_id_session}' ");
		if($result_search_query) {
			foreach ($result_search_query->result_array() as $value) {
				$email=$value['email'];
				?>
				<div onClick = "get_one('<?php echo $email;?>');"><?php echo $email; ?></div >
				<?php
			}
			exit;
		}
		else
		{
			echo '2000';
			exit;
		}
	}
	public function delete_message_by_user_in_session_sent()
	{
		$id = $this->uri->segment(3);
		$table_name='message';  
		$delete_message_id =  $_POST['msg_id_sent'];
		$userid = $this->session->userdata('userid'); 
		$explode_id = explode(',', $delete_message_id);

		if($id==1)
		{
			$update_set = array('state_sent'=>1);
			foreach ($explode_id as $value) 
			{
				$this->db->where('userid_to',$value);
				$result_update_data= $this->db->update($table_name,$update_set);
			}
		}
		elseif($id==2)
		{
			$update_set = array('state_inbox'=>1);
			foreach ($explode_id as $value) 
			{
				$this->db->where('userid_from',$value);
				$result_update_data= $this->db->update($table_name,$update_set);
			}
		}
		else { echo "1000"; }		exit;
	}
}

		
		