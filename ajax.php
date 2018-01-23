<?php

include_once("config.php");

$response=[];


if (!isset($_REQUEST["action"])) {
  $response=["error"=>"Don't know what to do"];
} else {
  if (!$client->is_logged_in() && $_REQUEST['action']!="login") {
    // client isn't logged in, can't do anything
    $response=["error"=>"You are not logged in"];
  } else {
    switch($_REQUEST['action']) {
      case "logout":
        $client->logout();
        $response=["logged_in"=>0, "message"=>"You have been logged out"];
        break;
      case "login":
        if (!isset($_REQUEST['user_name'], $_REQUEST['password']) || !$client->attempt_login($_REQUEST['user_name'], $_REQUEST['password'])) {
          $response=['error'=>__ ("Either your user name or password is incorrect")];
          break;
        } else {
          $response=["logged_in"=>1, "content_html"=>get_dashboard()];
        }
      case "dashboard":
        $response=["logged_in"=>1, "content_html"=>get_dashboard()];
        break;
      default:
        // no action was provided or we are just logging in, just return dashboard
        $response=["logged_in"=>1, "error"=>__ ("Invalid action")];
    }
  }
}

// $response hasn't been set above, don't know what happened
if (count($response)==0) {
  $response=["error"=>"An unknown error occurred"];
}
print json_encode($response);
exit;


function get_dashboard () {
  return __ ("Welcome back!", [], "confirmation");
}
