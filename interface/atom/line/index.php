<?php
/// Copyright (c) 2004-2009, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/documents/LICENSE, /documents/COPYRIGHT)
define('NO_SESSION', true);
define('__TEXTCUBE_LOGIN__',true);

require ROOT . '/library/preprocessor.php';
requireModel("blog.feed");

requireStrictBlogURL();

$children = array();
$cache = new pageCache;

$cache->name = 'linesATOM';
if(!$cache->load()) {
	$result = getLinesFeed(getBlogId(),'public','atom');
	if($result !== false) {
		$cache->contents = $result;
		$cache->update();
	}
}
header('Content-Type: application/atom+xml; charset=utf-8');
fireEvent('FeedOBStart');
echo fireEvent('ViewLinesATOM', $cache->contents);
fireEvent('FeedOBEnd');
?>
