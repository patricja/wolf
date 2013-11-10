<?php
/**
* All requests routed through here. This is an overview of what actaully happens during
* a request.
*
* @package WolfCore
*/

// ---------------------------------------------------------------------------------------
//
// PHASE: BOOTSTRAP
//
define('WOLF_INSTALL_PATH', dirname(__FILE__));
define('WOLF_SITE_PATH', WOLF_INSTALL_PATH . '/site');

require(WOLF_INSTALL_PATH.'/src/bootstrap.php');

$wo = CWolf::Instance();


// ---------------------------------------------------------------------------------------
//
// PHASE: FRONTCONTROLLER ROUTE
//
$wo->FrontControllerRoute();


// ---------------------------------------------------------------------------------------
//
// PHASE: THEME ENGINE RENDER
//
$wo->ThemeEngineRender();
