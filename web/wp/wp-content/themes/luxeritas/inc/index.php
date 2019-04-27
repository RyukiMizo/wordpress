<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

$msg = 'Welcom to ' . $_SERVER['SERVER_NAME'] . ' !';
$ttl = '<' . 'title' . '>' . $msg . '</' . 'title' . '>';
?>
<html>
<head>
<meta name="robots" content="noindex,nofollow" />
<?php echo $ttl, "\n"; ?>
</head>
<body>
<p><?php echo $msg ?></p>
<p>But sorry, there is no content on this page.</p>
</body>
</html>
