<?php
date_default_timezone_set('Europe/Zagreb');
session_start();
$ses_id = session_id();
$cses_id = '';
if (isset($_COOKIE['PHPSESSID'])) {
    $cses_id = $_COOKIE['PHPSESSID'];
}
//
//
//SETTINGS
$ver = '1.0.0'; // Software "Evolve" version number
$min = false;  // emable minifed versions keep this true in production version
$developing = true;
$bridge_cody_chat = false;
$domain = 'http://localhost/EvolveManager';

$portals = array(
    new Portal('1', 'http://localhost/EvolveManager', 'hr'),
    new Portal('2', 'http://localhost/2', 'en')
);

// /SETTINGS
//
//


//GLOBAL VARIABLES 
$time = date('H:i');
define('ROOT_PATH', realpath(__DIR__ . '/..'));
define('SYSTEM_PATH', realpath(__DIR__));
define('ADMIN_PATH', realpath(__DIR__ . '/..') . '/admin/');
define('FRONTEND_PATH', realpath(__DIR__ . '/..') . '/');

if ($bridge_cody_chat) {
    require(FRONTEND_PATH . 'system/inc/config_bridge_cody_chat.php');
} else {
    require(FRONTEND_PATH . 'system/inc/config_query.php');

}

if (defined('ADMIN')) {
    //ADMIN
    include(ADMIN_PATH . 'language/interno.php');
    require(ADMIN_PATH . 'system/functions.php');
    // /ADMIN
} elseif (defined('FRONTEND')) {
    //FRONTEND

    //include(ADMIN_PATH.'language/interno.php');
    $level_1_seo = '';
    $level_2_seo = '';
    $lang_seo = '';
    $keyword_seo = '';
    if (isset($_GET["level_1_seo"])) {
        $level_1_seo = $_GET["level_1_seo"];
    }
    if (isset($_GET["level_2_seo"])) {
        $level_2_seo = $_GET["level_2_seo"];
    }
    if (isset($_GET["lang"])) {
        $lang_seo = $_GET["lang"];
    }
    if (isset($_GET["keyword"])) {
        $keyword_seo = $_GET["keyword"];
    }

    require(FRONTEND_PATH . 'system/functions.php');
    require(FRONTEND_PATH . 'system/functions_main.php');
    // /FRONTEND
}

require(FRONTEND_PATH . 'system/inc/insert.php');//Insert

define('ADMIN_URL', $domain . '/admin/');

if (isset($portal_ID)) { //FRONTEND

    $portal_array =  array_filter(
        $portals,
        function ($item) use ($portal_ID) {
            return $item->id == $portal_ID;
        }
    );
    // $portal = new stdClass();
    $portal = $portal_array[0];

     define('FRONTEND_URL', $portal->url . '/');

    define('CHAT_URL', $portal->url . '/chat/');
    $language = $portal->lang;

}// /FRONTEND

if ($developing == 1) {
    $ver = strtotime('timestamp');
}
if ($min) {
    $min = '.min';
} else {
    $min = '';
}

/////REGENERATE SESSION
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {//1800 = 30min
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}
///// /REGENERATE SESSION


class Portal {
    public $id;
    public $url;
    public $lang;

    public function __construct($id, $url, $lang)
    {
        $this->id = $id;
        $this->url = $url;
        $this->lang = $lang;
    }
}
