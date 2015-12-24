<html>
<head>
<title>Upload Form</title>
</head>
<body>
 
<h3>Your file was successfully uploaded!</h3>
 
<p>The uploaded Image:</p>
 
<img alt="uploaded image" src="<?=base_url(). 'images/'.$upload_data['raw_name'].$upload_data['file_ext'];?>">
<p><?php echo anchor('upload', 'Upload Another File!'); ?></p>
 
</body>
</html>