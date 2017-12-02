<?
function pull_back_the_curtain($debugging_text) {
	//print "<P><font color=red>".$debugging_text."</font></p>";
}

function error_debug($link) {
	$error = $link->error;
	if ($error != "" || $error != NULL) {
		pull_back_the_curtain("Error: ".$error);
	}
}

function getData($query) {
	Global $link;
	pull_back_the_curtain($query);
	$query_resource = $link->query($query);
	error_debug($link);
	return $query_resource;
}

function getUserID($google_id, $display_name) {
	Global $link;
	// see if user is in database
	$query   = "select pal_id as UID from pal_usr_tbl where pal_ggl_id = ".$google_id;
	$results = getData($query);

	// if results are empty, user does not exist, and we should create a user record for it, returning ID

	if ($results->num_rows == 0) {
		return createUser($google_id, $display_name, $_SESSION['refresh_token']);
	}
	$row = $results->fetch_array(MYSQLI_ASSOC);
	return $row['UID'];
}

function getUserRefreshToken($pal_id) {
	Global $link;
	$query = "select pal_ggl_rfr as REFRESH_TOKEN from pal_usr_tbl where pal_id = '".$pal_id."'";
	pull_back_the_curtain($query);
	$results = $link->query($query);
	error_debug($link);

	// if results are empty, return 0. there is separate logic to determine if we should create a user
	if ($results->num_rows == 0) {
		return 0;
	}
	// otherwise, return the refresh token.
	$row = $results->fetch_array(MYSQLI_ASSOC);
	return $row['REFRESH_TOKEN'];
}

function setUserRefreshToken($pal_id, $refresh_token) {
	Global $link;
	$query = "update pal_usr_tbl set pal_ggl_rfr = ".$refresh_token." where pal_id = '".$pal_id."'";
	pull_back_the_curtain($query);
	$results = $link->query($query);
	error_debug($link);

	return 1;
}

function createUserDriveID($google_id, $display_name) {
	Global $link;
	$query = "insert into pal_usr_tbl (pal_usr_nme, pal_ggl_rfr, pal_ggl_id) ".
	"values (".
	"'".$display_name."', ".
	"'".$_SESSION['refresh_token']."', ".
	"'".$google_id."' ".
	")";
	pull_back_the_curtain($query);
	$query_resource = $link->query($query);
	error_debug($link);

	return $link->insert_id;
}

function createUser($google_id, $display_name, $refresh) {
	Global $link;
	$query = "insert into pal_usr_tbl (pal_usr_nme, pal_ggl_rfr, pal_ggl_id) ".
	"values (".
	"'".$display_name."', ".
	"'".$refresh."', ".
	"'".$google_id."' ".
	")";
	pull_back_the_curtain($query);
	$query_resource = $link->query($query);
	error_debug($link);
	return $link->insert_id;
}

function signMeUpSQL($pid, $uid) {
	Global $link;
	$query = "insert into puz_chk_out (puz_id, usr_id) values (".$pid.", ".$uid.")";
	$link->query($query);
	if ($link->error == "") {
		return "You are now signed up for this puzzle.";
	} else {
		return $link->error." (".$query.")";
	}
}

function iQuitSQL($pid, $uid) {
	Global $link;
	$query = "update puz_chk_out set chk_in = current_timestamp where puz_id = ".$pid." and usr_id = ".$uid;
	$link->query($query);
	if ($link->error == "") {
		return "You are no longer working on this puzzle.";
	} else {
		return $link->error." (".$query.")";
	}
}
