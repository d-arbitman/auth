<?php
include_once("config.php");

$user_name="newUserName";
$pass_word="newPassWord";

if (!$client->create_client ($user_name, $pass_word)) {
  print "Could not create client\n";
  print $db->get_instance()->error;
} else {
  print "Created client";
}
