<?php
/// Copyright (c) 2004-2009, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/documents/LICENSE, /documents/COPYRIGHT)
$IV = array(
	'GET' => array(
		'title' => array('string','default' => '')
	)
);
require ROOT . '/library/preprocessor.php';
requireStrictRoute();
if (!empty($_GET['title']) && setBlogTitle(getBlogId(), trim($_GET['title']))) {
	Respond::ResultPage(0);
}
Respond::ResultPage( - 1);
?>
