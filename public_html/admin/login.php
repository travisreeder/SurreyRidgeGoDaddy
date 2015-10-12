<?php
require_once("../../sr_includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  // Check database to see if username/password exist.
  $found_user = User::authenticate($username, $password);
	
  if ($found_user) {
    $session->login($found_user);
		log_action('Login', "{$found_user->username} logged in.");
    redirect_to("index.php");
  } else {
    // username/password combo was not found in the database
    $message = "Username/password combination incorrect.";
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
}

?>
<?php include_layout_template('login_header.php'); ?>
<header>
    <div id="headline" class="gradient">
        <h3 class="gradient opposite">Welcome to SRHOA Administration Site</h3>
    </div>
</header>

<div class="container-fluid" id="container">
    <div class="display_content">
        <form action="" method="post" name="Login_Form" class="form-signin">       
            
		    <div class="form-signin-heading">
                <?php echo "<h4>".output_message($message)."</h4>"; ?>
                <h3>Welcome Back! Please Sign In</h3>
            </div>
            
            <hr class="thicker-hr gradient">
			  
            <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" value="<?php echo htmlentities($username); ?>"/>
            <input type="password" class="form-control" name="password" placeholder="Password" required="" value="<?php echo htmlentities($password); ?>" />     		  
			 
            <input class="btn btn-info btn-block" type="submit" name="submit" value="Login" />	  			
		</form>
    </div>
</div>

