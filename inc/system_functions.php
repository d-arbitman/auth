<?php
/*
 * __ allows for internationalization and variable interpolation of the format %[variable_name]
 */
function __ ($message, $params=[], $div="") {
  if (function_exists("gettext")) {
    $return=gettext($message);
  } else {
    $return=$message;
  }
  if (count($params)>0) {
    foreach ($params as $key => $value) {
      $return=str_replace("%[" . $key . "]", htmlentities($value), $return);
    }
  }
  if ($div!="") {
    return "<div class='$div'>$return</div>";
  } else {
    return $return;
  }
}


/*
 * function to determine if session has been started yet
 */
function is_session_started() {
  if (php_sapi_name()!== 'cli') {
    if (version_compare(phpversion(), '5.4.0', '>=') ) {
      return (session_status()===PHP_SESSION_ACTIVE)?true:false;
    } else {
      return (session_id()==='')?false:true;
    }
  }
  return false;
}

function get_random_string ($l=10, $str='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/;[]-=~_+{}|:?><!@#$%^&*()') {
  //require_once (INC_PATH . "random_compat" . DS . "lib"  . DS. "random.php");
  $r='';
  for ($i=0; $i<$l; $i++) {
    try {
      $char=random_int(0, strlen($str)-1);
    } catch (TypeError $e) {
      throw new Exception('Well, this is odd');
    } catch (Error $e) {
      throw $e;
    } catch (Exception $e) {
      throw new InternalServerErrorException(
        'Oops, our server is bust and cannot generate any random data.',
        500,
        $e
      );
    }
    $r .= '' . $str[$char];
  }
  return $r;
}

