<?php
/*
 *  projects.php - OpenPave.org Projects
 *
 *  $OpenPave: www/projects.php,v 1.3 2008/01/08 23:47:59 reg Exp $
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
 *  Portions Copyright (C) 2006 OpenPave.org.
 *
 *  Contributor(s): Jeremy Lea <reg@openpave.org>.
 */

$depth = '';
require($depth.'dynamic.inc');
StartHTML();
?>

<h2>OpenPave.org Projects</h2>

<p>OpenPave.org hosts any open source project which is related to pavement
engineering, and is released under either the ADDL license or another open
source license which is compatible with the ADDL.

<p>The following projects have been released under the OpenPave.org banner
and can be found in CVS or downloaded.

<dl>
<dt>OpenPave.org Core Libraries</dt>
	<dd>A n-layer, n-load, n-point multi-layer elastic half space
    calculation, written in C++.</dd>
</dl>

<?php
FinaliseHTML('$OpenPave: www/projects.php,v 1.3 2008/01/08 23:47:59 reg Exp $');
?>