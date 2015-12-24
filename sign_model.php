<?php date_default_timezone_set('Asia/Calcutta'); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sign_model extends CI_Model{
	public function insert_data($table_name,$file)
	{	 
		$result = $this->db->insert($table_name,$file);	
		return $result;
	}  
	public function check($gmail_id)
	{
		$query_check= $this->db->query("SELECT * FROM user WHERE email='$gmail_id'");
		if($query_check->num_rows()==0) {
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function update_gmail_data($table_name,$user_gmail_info,$gmail_id)
	{	
		$user_session =$this->db->where('email',$gmail_id);
		$result_update_data= $this->db->update($table_name,$user_gmail_info);
		$query_user= $this->db->query("SELECT * FROM user WHERE email= '{$gmail_id}'");
		foreach($query_user->result_array() as $row)
				{
					 $user_id= $row['userid'];
				}
				return $user_id;
	}
	public function insert_gmail_data($table_name,$user_gmail_info)
	{
			$result= $this->db->insert($table_name,$user_gmail_info);
			$user_id= $this->db->insert_id($result);
			return $user_id; 
	}
	public function userlogin_data($username,$password)
	{		  
	     $result_query_login= $this->db->query("SELECT * FROM user WHERE username='$username' AND password='$password'");
			if($result_query_login->num_rows()==1){
				foreach($result_query_login->result_array() as $row)
				{
					 $userid= $row['userid'];
				}
				$session_id = $this->session->userdata('session_id');
				$this->db->delete('ci_sessions',array('userid' => $userid));
				$this->db->where('session_id', $session_id);
				$r= $this->db->update('ci_sessions', array('userid' => $userid));				
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('userid',$userid);
				$user_data= $this->session->userdata('username',$userid); 
				$user_data2= $this->session->userdata('userid',$userid2);
				}
			else
			{
				die("Invalid username/password");
			}	
	} 
	public function update_value($table_name,$updated_user_data,$userid)
	{
		$user_session =$this->db->where('userid',$userid);
		$result_update_data= $this->db->update($table_name,$updated_user_data);
	}
	public function insert_message_data($table_name,$message_data)
	{
		$result_query= $this->db->insert($table_name,$message_data);
		return $result_query;
	}
	public function get_userid_by_email($email)
	{
		$query_userid= $this->db->query("SELECT * FROM user WHERE email= '{$email}' ");
		$result= $query_userid->result_array();
		return $result;
	}
	public function get_email_by_userid($user_id)
	{
		$query_userid= $this->db->query("SELECT * FROM user WHERE userid= '{$user_id}' ");
		$result= $query_userid->result_array();
		return $result;
	}
	public function display_all_message_sent($userid)
	{
		$query_display= $this->db->query("SELECT * FROM message WHERE state_sent='0' AND userid_from ='{$userid}' ");
		$result= $query_display->result_array();
		return $result;
	}
	public function display_all_message_inbox($userid)
	{
		$query_display= $this->db->query("SELECT * FROM message WHERE userid_to='{$userid}' AND state_inbox='0' ");
		$result= $query_display->result_array();
		return $result;
	}
	public function check_user($userid)
	{
		$query_check_online_user= $this->db->query("SELECT * FROM ci_sessions WHERE userid!= '{$userid}' ");
		$result = $query_check_online_user->result_array();
		//print_r($result);
		return $result;
	}
}