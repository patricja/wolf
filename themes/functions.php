<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/
 

/**
* Print debuginformation from the framework.
*/
function get_debug() {
  // Only if debug is wanted.
  $wo = CWolf::Instance();
  if(empty($wo->config['debug'])) {
    return;
  }
  
  // Get the debug output
  $html = null;
  if(isset($wo->config['debug']['db-num-queries']) && $wo->config['debug']['db-num-queries'] && isset($wo->db)) {
    $flash = $wo->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<p>Database made $flash" . $wo->db->GetNumQueries() . " queries.</p>";
  }
  if(isset($wo->config['debug']['db-queries']) && $wo->config['debug']['db-queries'] && isset($wo->db)) {
    $flash = $wo->session->GetFlash('database_queries');
    $queries = $wo->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }
    $html .= "<p>Database made the following queries:</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }
  if(isset($wo->config['debug']['timer']) && $wo->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $wo->timer['first'], 5)*1000 . " msecs.</p>";
  }
  if(isset($wo->config['debug']['wolf']) && $wo->config['debug']['wolf']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CWolf:</p><pre>" . htmlent(print_r($wo, true)) . "</pre>";
  }
  if(isset($wo->config['debug']['session']) && $wo->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of CWolf->session:</p><pre>" . htmlent(print_r($wo->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }
  return $html;
}


/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() {
  $messages = CWolf::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}


/**
* Prepend the base_url.
*/
function base_url($url=null) {
  return CWolf::Instance()->request->base_url . trim($url, '/');
}


/**
* Create a url to an internal resource.
*
* @param string the whole url or the controller. Leave empty for current controller.
* @param string the method when specifying controller as first argument, else leave empty.
* @param string the extra arguments to the method, leave empty if not using method.
*/
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CWolf::Instance()->request->CreateUrl($urlOrController, $method, $arguments);
}

/**
* Prepend the theme_url, which is the url to the current theme directory.
*
* @param $url string the url-part to prepend.
* @returns string the absolute url.
*/
function theme_url($url) {
  return create_url(CWolf::Instance()->themeUrl . "/{$url}");
}

/**
* Prepend the theme_parent_url, which is the url to the parent theme directory.
*
* @param $url string the url-part to prepend.
* @returns string the absolute url.
*/
function theme_parent_url($url) {
  return create_url(CWolf::Instance()->themeParentUrl . "/{$url}");
}


/**
* Return the current url.
*/
function current_url() {
  return CWolf::Instance()->request->current_url;
}


/**
* Render all views.
*
* @param $region string the region to draw the content in.
*/
function render_views($region='default') {
  return CWolf::Instance()->views->Render($region);
}


/**
* Check if region has views. Accepts variable amount of arguments as regions.
*
* @param $region string the region to draw the content in.
*/
function region_has_content($region='default' /*...*/) {
  return CWolf::Instance()->views->RegionHasView(func_get_args());
}

/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CWolf::Instance()->user['email']))) . '.jpg?' . ($size ? "s=$size" : null);
}


/**
* Escape data to make it safe to write in the browser.
*/
function esc($str) {
  return htmlEnt($str);
}


/**
* Filter data according to a filter. Uses CMContent::Filter()
*
* @param $data string the data-string to filter.
* @param $filter string the filter to use.
* @returns string the filtered string.
*/
function filter_data($data, $filter) {
  return CMContent::Filter($data, $filter);
}



/**
* Display diff of time between now and a datetime.
*
* @param $start datetime|string
* @returns string
*/
function time_diff($start) {
  return formatDateTimeDiff($start);
}
