<?php
/**
 * Created by PhpStorm.
 * User: Chris Schaefer
 * Date: 10/2/15
 * Time: 9:04 AM
 */

function nav_menu($pages,$return=false,$module=null) {
  if(!isset($module)) {
    $module = $GLOBALS["APP"]["MODULE_MAP"][strtolower($GLOBALS["APP"]["INSTANCE"]->_requested["Module"])];
  } else {
    $module = $module;
  }
  $view = $GLOBALS["APP"]["INSTANCE"]->_requested["View"];
  $menu = '';
  foreach($pages as $title => $name) {
    $class = '';
    if(!is_array($name) && strtolower($name) == strtolower($view) && strtolower($module) == strtolower($GLOBALS["APP"]["MODULE_MAP"][$GLOBALS["APP"]["INSTANCE"]->GetController()->GetModule()])) {
      $class = ' class="active"';
    }
    $sr = ($name == $view) ? '<span class="sr-only">(current)</span>' : '';
    $menu_item = '';
    if(is_array($name)) {
      $menu_item .= '<li class="dropdown">';
      $menu_item .= '  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $title . ' <span class="caret"></span></a>';
      $menu_item .= '  <ul class="dropdown-menu">';
      $menu_item .= nav_menu($name, true, $module);
      $menu_item .= '  </ul>';
      $menu_item .= '</li>';
    } else {
      $menu_item = "<li$class><a href=\"/$module/$name\">$title$sr</a></li>";
    }
    $menu .= $menu_item;
  }
  if($return) {
    return $menu;
  } else {
    echo $menu;
  }
}

function module_menu($pages,$return=false) {
  $module = $GLOBALS["APP"]["INSTANCE"]->GetController()->GetModule();
  $menu = '';
  foreach($pages as $title => $name) {
    if(is_string($name) && strtolower($name) == "ajax") { continue; }
    if (!is_array($name) && strtolower($name) == strtolower($module)) {
      $class = ' class="active"';
      $sr = '<span class="sr-only">(current)</span>';
    } else {
      $class = $sr = '';
    }
    $menu_item = '';
    if(is_array($name)) {
      $menu_item .= '<li class="dropdown">';
      $menu_item .= '  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . ucfirst($title) . ' <span class="caret"></span></a>';
      $menu_item .= '  <ul class="dropdown-menu">';
      $menu_item .= module_menu($name, true);
      $menu_item .= '  </ul>';
      $menu_item .= '</li>';
    } else {
      $menu_item = "<li$class><a href=\"/$name\">" . ucfirst($name) . "$sr</a></li>";
    }
    $menu .= $menu_item;
  }
  if($return) {
    return $menu;
  } else {
    echo $menu;
  }
}

function user_options_menu() {
  if(is_logged_in()) {
    nav_menu(array("Account" => array("Edit Account" => "Edit", "Logout" => "Logout")),false,"User");
  } else {
    nav_menu(array("Login"=>"Login"),false,"User");
  }
}

function sidebar($name) {
  $module = $GLOBALS["APP"]["MODULE_MAP"][strtolower($GLOBALS["APP"]["INSTANCE"]->_controller->GetModule())];
  if(file_exists("modules/$module/views/sidebar/$name.php")) {
    include_once "modules/$module/views/sidebar/$name.php";
  } else {
    if(file_exists("sidebar/$name.php")) {
      include_once "sidebar/$name.php";
    }
  }
}

function is_logged_in() {
  return (isset($GLOBALS["valid_login"])) ? $GLOBALS["valid_login"] : false;
}

/**
 * Check if a date is in a billing cycle range
 * @param $start_date
 * @param $end_date
 * @param $date_from_user
 * @return bool
 */
function check_in_range($start_date, $end_date, $date_from_user)
{
  // Subtract a day from our end date because it is actually
  // the first day of the next cycle.
//  $end_date = date_sub(new DateTime($end_date),new DateInterval("P1D"))->format("Y-m-d");

//  $tmp_date = new DateTime($end_date);
//  $tmp_date->sub(new DateInterval('P1D'));
//  $end_date = $tmp_date->format("Y-m-d");

  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}