<?php
/*
 *  dynamic.inc - General functions for dynamic HTML generation
 *
 *  The contents of this file are subject to the Academic Development
 *  and Distribution License Version 1.0 (the "License"); you may not
 *  use this file except in compliance with the License.  You should
 *  have received a copy of the License with this file.  If you did not
 *  then please contact whoever distributed this file too you, since
 *  they may be in violation of the License, and this may affect your
 *  rights under the License.
 *
 *  Software distributed under the License is distributed on an "AS IS"
 *  basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See
 *  the License for the specific language governing rights and
 *  limitations under the License.
 *
 *  The Initial Developer of the Original Software is Jeremy Lea.
 *
 *  Portions Copyright (C) 2006-2009 OpenPave.org.
 *
 *  Contributor(s): Jeremy Lea <reg@openpave.org>.
 */

//require('adodb/adodb.inc.php');
require($depth.'toc.inc');

/*
 * Fix up quoted variables in all the pages if needed.
 */
if (get_magic_quotes_gpc()) {
	foreach ($_GET as $k => $v)
		$_GET[$k] = (is_array($v) ? $v : stripslashes($v));
	foreach ($_POST as $k => $v)
		$_POST[$k] = (is_array($v) ? $v : stripslashes($v));
	foreach ($_COOKIE as $k => $v)
		$_COOKIE[$k] = (is_array($v) ? $v : stripslashes($v));
}

$active = $_SERVER['PHP_SELF'];
$active = substr($active,strrpos($active,'/')+1);
$active = str_replace('.php','',$active);

foreach($toc as $k => $v) {
	foreach($v as $p => $s) {
		if (is_array($s)) {
			foreach(array_keys($s) as $a) {
				if ($a == $active) {
					$section = $k;
					$subsection = $p;
				}
			}
		} else {
			if ($p == $active) {
				$section = $k;
				$subsection = $p;
			}
		}
	}
}
if (!isset($section) || !isset($subsection)) {
	exit("There is a configuration error! Please contact the webmaster.");
}

function make_li_link($k,$v) {
	global $depth, $active;
	
	$k = ($k == $active ? 'active' : $depth.$k.'.php');
	if ($i = strpos($v,'<'))
		$k = substr($v,$i+1,strpos($v,'>')-$i-1);
	$v = trim(preg_replace('/<.*>/','',$v));
	$v = trim(preg_replace('/\[.*\]/','',$v));
	if ($k == 'active')
		return "<li class=\"active\">$v";
	else
		return "<li><a href=\"$k\">$v</a>";
}

function StartHTML($css = array(), $js = array())
{
	global $depth, $toc, $section, $subsection, $active;

	$title = 'OpenPave.org';
	if ($section != 'index')
		$title .= '::'.$toc[$section][$section];
	if ($subsection != $section) {
		if (is_array($toc[$section][$subsection]))
			$title .= '::'.str_replace(array('[',']'),'',
					$toc[$section][$subsection][$active]);
		else
			$title .= '::'.$toc[$section][$subsection];
	}
	$title = preg_replace('/<.*>/','',$title);
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="<?php echo $depth; ?>css/openpave.css" />
<?php
	foreach($css as $v) {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$v\" />";
	}
	foreach($js as $v) {
		echo "<script type=\"text/javascript\" src=\"$v\"></script>";
	}
?>
<title><?php echo $title ?></title>
</head>
<body>
<div id="topbar">
<h1 id="logo">OpenPave.org</h1>
<div id="sitenav">
<h2 class="hide">Site Navigation</h2>
<?php
	echo '<ul>';
	foreach($toc as $k => $v) {
		if ($k != $section)
			echo "<li><a href=\"$depth$k.php\">".$v[$k].'</a></li>';
		else
			echo "<li class=\"active\">".$v[$k].'</li>';
	}
	echo "</ul>\n";
?>
</div>
</div>
<div id="content">

<div id="sectnav">
<h2 class="hide">Section Navigation</h2>
<?php
	echo '<ul>';
	foreach($toc[$section] as $k => $v) {
		if (is_array($v)) {
			echo make_li_link($k,$v[$k])."\n<ul>\n";
			foreach($v as $a => $s) {
				if ($a == $k)
					continue;
				echo " ".make_li_link($a,$s)."</li>\n";
			}
			echo "</ul></li>\n";
		} else {
			echo make_li_link($k,$v)."</li>\n";
		}
	}
	echo "</ul>\n";
?>
</div>
<div id="body">
<?php
}

/*
 * Finish off the page.  No output after this...
 */
function FinaliseHTML($op_cvs)
{
?>
</div>

</div>

<div id="footer">
 <div id="copyright">
 <div id="social">
  <a class="github-button" href="https://github.com/openpave" aria-label="Follow @openpave on GitHub">
     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  height="32" viewBox="0 0 16 16" version="1.1" width="32"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>
     <span>Follow us on GitHub</span></a>
 </div>
  &copy; 2019, Openpave.org.<br>
  <a href="mailto:www@openpave.org">Contact the webmaster.</a>
 </div>
</div>

<!--<p>
<a href="http://validator.w3.org/check?uri=referer"><img
	src="http://www.w3.org/Icons/valid-xhtml10"
	alt="Valid XHTML 1.0!" height="31" width="88"/></a>
<a href="http://jigsaw.w3.org/css-validator/check/referer">
  <img style="border:0;width:88px;height:31px"
       src="http://jigsaw.w3.org/css-validator/images/vcss" 
       alt="Valid CSS!" /></a>
</p>-->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4396026-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>
<?php
}

?>
