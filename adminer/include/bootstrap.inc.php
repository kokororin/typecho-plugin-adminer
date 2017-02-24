<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
error_reporting(6135); // errors and warnings

include __DIR__ . "/coverage.inc.php";

// disable filter.default
$filter = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($filter || ini_get("filter.default_flags")) {
	foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $val) {
		$unsafe = filter_input_array(constant("INPUT$val"), FILTER_UNSAFE_RAW);
		if ($unsafe) {
			$$val = $unsafe;
		}
	}
}

if (function_exists("mb_internal_encoding")) {
	mb_internal_encoding("8bit");
}

// used only in compiled file
if (isset($_GET["file"])) {
	include __DIR__ . "/../adminer/file.inc.php";
}

include __DIR__ . "/functions.inc.php";

global $adminer, $connection, $drivers, $edit_functions, $enum_length, $error, $functions, $grouping, $HTTPS, $inout, $jush, $LANG, $langs, $on_actions, $permanent, $structured_types, $has_token, $token, $translations, $types, $unsigned, $VERSION; // allows including Adminer inside a function

if (!$_SERVER["REQUEST_URI"]) { // IIS 5 compatibility
	$_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
}
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") { // IIS 7 compatibility
	$_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
}
$HTTPS = $_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off");

@ini_set("session.use_trans_sid", false); // protect links in export, @ - may be disabled
session_cache_limiter(""); // to allow restarting session and to not send Cache-Control: no-store
if (!defined("SID")) {
	session_name("adminer_sid"); // use specific session name to get own namespace
	$params = array(0, preg_replace('~\\?.*~', '', $_SERVER["REQUEST_URI"]), "", $HTTPS);
	if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
		$params[] = true; // HttpOnly
	}
	call_user_func_array('session_set_cookie_params', $params); // ini_set() may be disabled
	session_start();
}

// disable magic quotes to be able to use database escaping function
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $filter);
if (get_magic_quotes_runtime()) {
	set_magic_quotes_runtime(false);
}
@set_time_limit(0); // @ - can be disabled
@ini_set("zend.ze1_compatibility_mode", false); // @ - deprecated
@ini_set("precision", 20); // @ - can be disabled

include __DIR__ . "/lang.inc.php";
include __DIR__ . "/../lang/$LANG.inc.php";
include __DIR__ . "/pdo.inc.php";
include __DIR__ . "/driver.inc.php";
include __DIR__ . "/../drivers/sqlite.inc.php";
include __DIR__ . "/../drivers/pgsql.inc.php";
include __DIR__ . "/../drivers/oracle.inc.php";
include __DIR__ . "/../drivers/mssql.inc.php";
include __DIR__ . "/../drivers/firebird.inc.php";
include __DIR__ . "/../drivers/simpledb.inc.php";
include __DIR__ . "/../drivers/mongo.inc.php";
include __DIR__ . "/../drivers/elastic.inc.php";
include __DIR__ . "/../drivers/mysql.inc.php"; // must be included as last driver

define("SERVER", $_GET[DRIVER]); // read from pgsql=localhost
define("DB", $_GET["db"]); // for the sake of speed and size
define("ME", preg_replace('~^[^?]*/([^?]*).*~', '\\1', $_SERVER["REQUEST_URI"]) . '?'
	. (isset($_GET["panel"]) ? "panel=" . urlencode($_GET["panel"]) . '&' : '')
	. (sid() ? SID . '&' : '')
	. (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '')
	. (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '')
	. (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : '')
);

include __DIR__ . "/version.inc.php";
include __DIR__ . "/adminer.inc.php";
include __DIR__ . "/design.inc.php";
include __DIR__ . "/xxtea.inc.php";
include __DIR__ . "/auth.inc.php";

if (!ini_bool("session.use_cookies") || @ini_set("session.use_cookies", false) !== false) { // @ - may be disabled
	session_write_close(); // improves concurrency if a user opens several pages at once, may be restarted later
}

include __DIR__ . "/editing.inc.php";
include __DIR__ . "/connect.inc.php";

$on_actions = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT"; ///< @var string used in foreign_keys()
