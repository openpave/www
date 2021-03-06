<?php
/*
 *  about.php - About OpenPave.org
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

$depth = '';
require($depth.'dynamic.inc');
StartHTML();
?>

<h2>About OpenPave.org</h2>

<p>OpenPave.org was started in 2006, by Jeremy Lea, a graduate student
from the University of California, Davis.  Jeremy has been involved in a
number of open source projects, including <a href="http://www.freebsd.org/">
FreeBSD</a> and <a href="http://www.mozilla.org/">Mozilla and
Firefox</a>, and saw the power of open source to create really good
quality code first hand.  OpenPave.org was conceived as a vehicle to
distribute the pavement engineering code which he had written, in the
hopes that the community would participate.  In addition, there are no
programs for Linux/FreeBSD/MacOS X for pavement engineering, and it is
hoped that through OpenPave.org these applications can be developed,
allowing people to use these platforms rather than being forced to use
Windows.</p>

<p>It is encouraging that there are a number of people talking about
trying to open source their pavement engineering code, including some
moves to open source the MEPDG software.</p>

<p>OpenPave.org is currently hosted at UC Davis.</p>

<?php
FinaliseHTML('');
?>