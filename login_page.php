<html lang="en">
  <head>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="27151892361-q0brpaennoapfc87a94mqjgtotv79d36.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  </head>
  <body>
  <?php echo validation_errors(); ?> 
<form method="POST"> 
<h3> Username</h3>
<input type="text" name="username" value="" size="50">
<h3> Password</h3>
<input type="password" name="password" value="" size="50"><br><br>
<div> <input type="submit" value="submit" name="login_button_data"></div><br><br>
<div><button onclick="FBLogin()">Facebook Login</button></div><br><br>
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log("Name: " + profile.getName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
          
        var gmail_id=profile.getEmail();
        var gmail_name= profile.getName();
         var str = 'gmail_id='+gmail_id+'&gmail_name='+gmail_name;
           $.ajax({
               url:"<?php echo base_url('sign/get_user_by_gmail');?>",
               type:"POST",
               data:str,
               success:function(data)
               {
                 if(data=='1000')
                 { 
                   document.location.href = "<?php echo base_url('sign/info');?>";
                 }
               }
           });
      };
    </script>
  </body>
</html>
 <script>
window.fbAsyncInit = function() {
   FB.init({
   appId      : '540485449441497', // replace your app id here
   status     : true, 
   cookie     : true, 
   xfbml      : true  
   });
};
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "http://connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
}(document));

function getPhoto()
{
FB.api('/me/picture?type=normal', function(response) 
{
  var str="<br/><b>Pic</b> : <img src='"+response.data.url+"'/>";
       document.getElementById("status").innerHTML+=str;
   });
}
function FBLogin(){
 FB.login(function(response){
       if(response.authResponse)
       {
           FB.api('/me?fields=name,email', function(response) { 
           var str = 'email='+response.email+'&full_name='+response.name;
           alert(str);
           $.ajax({
               url:"<?php echo base_url('sign/index/');?>",
               type:"POST",
               data:str,
               success:function(data)
               {

                 if(data == '1000')
                 {

                   document.location.href = "<?php echo base_url('sign/info');?>";
                 }
               }
           });
           });
       }
   }, {scope: 'email,user_likes,user_birthday,user_hometown'});
} </script>
