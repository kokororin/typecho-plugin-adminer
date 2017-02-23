<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, http://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/

include __DIR__ . "/./include/bootstrap.inc.php";
include __DIR__ . "/./include/tmpfile.inc.php";

$enum_length = "'(?:''|[^'\\\\]|\\\\.)*'";
$inout = "IN|OUT|INOUT";

if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
	$_GET["edit"] = $_GET["select"];
}
if (isset($_GET["callf"])) {
	$_GET["call"] = $_GET["callf"];
}
if (isset($_GET["function"])) {
	$_GET["procedure"] = $_GET["function"];
}

if (isset($_GET["download"])) {
	include __DIR__ . "/./download.inc.php";
} elseif (isset($_GET["table"])) {
	include __DIR__ . "/./table.inc.php";
} elseif (isset($_GET["schema"])) {
	include __DIR__ . "/./schema.inc.php";
} elseif (isset($_GET["dump"])) {
	include __DIR__ . "/./dump.inc.php";
} elseif (isset($_GET["privileges"])) {
	include __DIR__ . "/./privileges.inc.php";
} elseif (isset($_GET["sql"])) {
	include __DIR__ . "/./sql.inc.php";
} elseif (isset($_GET["edit"])) {
	include __DIR__ . "/./edit.inc.php";
} elseif (isset($_GET["create"])) {
	include __DIR__ . "/./create.inc.php";
} elseif (isset($_GET["indexes"])) {
	include __DIR__ . "/./indexes.inc.php";
} elseif (isset($_GET["database"])) {
	include __DIR__ . "/./database.inc.php";
} elseif (isset($_GET["scheme"])) {
	include __DIR__ . "/./scheme.inc.php";
} elseif (isset($_GET["call"])) {
	include __DIR__ . "/./call.inc.php";
} elseif (isset($_GET["foreign"])) {
	include __DIR__ . "/./foreign.inc.php";
} elseif (isset($_GET["view"])) {
	include __DIR__ . "/./view.inc.php";
} elseif (isset($_GET["event"])) {
	include __DIR__ . "/./event.inc.php";
} elseif (isset($_GET["procedure"])) {
	include __DIR__ . "/./procedure.inc.php";
} elseif (isset($_GET["sequence"])) {
	include __DIR__ . "/./sequence.inc.php";
} elseif (isset($_GET["type"])) {
	include __DIR__ . "/./type.inc.php";
} elseif (isset($_GET["trigger"])) {
	include __DIR__ . "/./trigger.inc.php";
} elseif (isset($_GET["user"])) {
	include __DIR__ . "/./user.inc.php";
} elseif (isset($_GET["processlist"])) {
	include __DIR__ . "/./processlist.inc.php";
} elseif (isset($_GET["select"])) {
	include __DIR__ . "/./select.inc.php";
} elseif (isset($_GET["variables"])) {
	include __DIR__ . "/./variables.inc.php";
} elseif (isset($_GET["script"])) {
	include __DIR__ . "/./script.inc.php";
} else {
	include __DIR__ . "/./db.inc.php";
}

// each page calls its own page_header(), if the footer should not be called then the page exits
page_footer();
