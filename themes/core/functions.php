<?php
/**
* Helpers for the template file.
*/


/**
* Login menu. Creates a menu which reflects if user is logged in or not.
*/
function login_menu() {
  $wo = CWolf::Instance();
  if($wo->user['isAuthenticated']) {
    $items = "<a href='" . create_url('user/profile') . "'><img class='gravatar' src='" . get_gravatar(20) . "' alt='' />" . $lt->user['username'] . "</a> ";
    if($wo->user['hasRoleAdministrator']) {
      $items .= "<a href='" . create_url('acp') . "'>Admin-panel</a> ";
    }
    $items .= "<a href='" . create_url('user/logout') . "'>Log out</a> ";
  } else {
    $items = "<a href='" . create_url('user/login') . "'>Login</a> ";
  }
  return "<nav>$items</nav>";
}
