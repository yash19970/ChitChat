<?php echo "Successfully registered";
$userid =$this->db->where('username');
if($userid) {
 ?>
<a href="<?php echo base_url('sign/info/'); ?>"> BACK </a><br><br>
<a href="<?php echo base_url('sign/update_info/'); ?>" > UPDATE AGAIN </a>
<?php } ?>