<?php
/// Copyright (c) 2004-2007, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)

function getKeywordCount($blogid) {
	global $database;
	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 0';
	return DBQuery::queryCell("SELECT COUNT(*) FROM {$database['prefix']}Entries WHERE blogid = $blogid AND draft = 0 $visibility AND category = -1");
}

function getKeywordNames($blogid) {
	global $database;
	$names = array();
	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 0';
	$names = DBQuery::queryColumn("SELECT title FROM {$database['prefix']}Entries WHERE blogid = $blogid AND draft = 0 $visibility AND category = -1 ORDER BY char_length(title) DESC");
	return $names;
}

function getKeywords($blogid) {
	global $database;
	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 0';
	return DBQuery::queryAll("SELECT * 
		FROM {$database['prefix']}Entries 
		WHERE blogid = $blogid 
			AND draft = 0 $visibility 
			AND category = -1 
		ORDER BY title ASC");
}

function getKeywordsWithPaging($blogid, $search, $page, $count) {
	global $database, $folderURL, $suri;
	$aux = '';
	if (($search !== true) && $search) {
		$search = tc_escape_string($search);
		$aux = "AND (title LIKE '%$search%' OR content LIKE '%$search%')";
	}

	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 0';
	$sql = "SELECT * 
		FROM {$database['prefix']}Entries 
		WHERE blogid = $blogid 
			AND draft = 0 $visibility 
			AND category = -1 $aux 
		ORDER BY published DESC";
	return fetchWithPaging($sql, $page, $count, "$folderURL/{$suri['value']}");
}

function getKeyword($blogid, $keyword) {	
	return getKeylogByTitle($blogid, $keyword);
}

function getKeylogByTitle($blogid, $title) {	
	global $database;
	$title = tc_escape_string($title);
	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 0';
	return DBQuery::queryRow("SELECT * 
			FROM {$database['prefix']}Entries 
			WHERE blogid = $blogid 
				AND draft = 0 $visibility 
				AND category = -1 
				AND title = '$title' 
			ORDER BY published DESC");
}

function getEntriesByKeyword($blogid, $keyword) {	
	global $database;
	$keyword = tc_escape_string($keyword);
	$visibility = doesHaveOwnership() ? '' : 'AND visibility > 1';
	return DBQuery::queryAll("SELECT id, userid, title, category, comments, published 
			FROM {$database['prefix']}Entries 
			WHERE blogid = $blogid 
				AND draft = 0 $visibility 
				AND category >= 0 
				AND (title LIKE '%$keyword%' OR content LIKE '%$keyword%')
			ORDER BY published DESC");
}
?>
