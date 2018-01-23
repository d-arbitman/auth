<?php
include_once("header.php");
?>
<noscript><?php print __ ("This page requires Javascript, please <a href='https://www.enable-javascript.com/'>turn it on</a> or <a href='https://browsehappy.com/'>upgrade your browser</a>", [], "error"); ?></noscript>
<div class="main_content" id="main_content">
<div id="ajax_update">&nbsp;</div>
<div class="login_box" id="login_box">
<fieldset><legend>Login</legend>
<div class="loginBox">
<form method="post" name="login_form" id="login_form" action="">
<div class="form_html">
<div class="form-group">
<label for='user_name'>User Name</label><br>
<span class="fa fa-sign-in fa-fw" aria-hidden="true"></span><input type='text' placeholder='User Name' name='user_name' id='user_name' value=''>
</div>
<div class="form-group">
<label for='password'>Password</label><br>
<span class="fa fa-key fa-fw" aria-hidden="true"></span><input class='inline_block' type='password' placeholder='Password' name='password' id='password' value=''>
</div>
<div id="login_buttons" class="form_buttons"><input type="submit" id="login_submit" value="login">&nbsp;&nbsp;<input type="reset" value="reset"></div></div>
</form>
</div>
</fieldset>
</div>
<div class="content" id="content">
<div class="logout_button">Logout</div><br><br>
<div class="content_add" id="content_add"></div>
</div><br><br>
</div>
<?php
include_once("footer.php");
