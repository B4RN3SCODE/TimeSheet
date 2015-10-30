<?php
/**
 * Created by PhpStorm.
 * User: Chris Schaefer
 * Date: 10/2/15
 * Time: 9:04 AM
 */

function nav_menu($pages,$return=false,$module=null) {
  if(!isset($module)) {
    $module = $GLOBALS["APP"]["MODULE_MAP"][$GLOBALS["APP"]["INSTANCE"]->GetController()->GetModule()];
  } else {
    $module = $module;
  }
  $view = $GLOBALS["APP"]["INSTANCE"]->GetController()->GetView();
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
//  return $GLOBALS["APP"]["INSTANCE"]->_authService->isLoggedIn();
  return (isset($_SESSION["User"]) && ($_SESSION["User"]->getId() > 0));
}