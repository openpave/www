<?php
/*
 *  index.php - The OpenPave.org homepage
 *
 *  $OpenPave: www/index.php,v 1.8 2013/11/01 18:09:59 reg Exp $
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

<h2>Welcome</h2>

<p>Welcome to OpenPave.org, the home of open source pavement engineering
software.  Open source software allows you, the user, to access the source
code for your software so that you can both see how it works and change it
to better perform the tasks for which you are using it.  This is
particularly valuable in engineering where you often need specialized
software for particular tasks.  Ordinarily this would mean having to code
your application from scratch, hence the proliferation of small programs
which are essentially the same.  With open source you can benefit from
building on a tested base, and all for free!</p>

<div class="note"><p>A 64-bit version is now available!  This should work
with Office from Office XP through Office 2013 on both 32-bit and 64-bit
versions.  This also includes some fixes and speed improvements.  The
spreadsheet has also been updated with more error checking. <a
href="http://www.openpave.org/downloads/openpave-20131101.zip">You should
check out the Excel spreadsheet</a>, or join a <a
href="http://www.openpave.org/mailman/listinfo/">mailing list.</a></p>
</div>

<p>For you, the developer, open source gives you the ability to implement
your ideas without building from scratch, and to benefit from the changes of
other developers.  This is particularly valuable for students wishing to
explore new algorithms, and for researchers looking to calibrate models
without the expense of developing from scratch.</p>

<p>At the moment there is not a lot of code available through OpenPave.org,
but it is hoped that this will change quickly!  OpenPave.org code is not
intended to compete with commercial offerings, and currently only includes
the calculation 'engines', and no user interface code.</p>

<p>OpenPave.org code is distributed under the Academic Development and
Distribution License, which is similar to the Mozilla Public License (which
is used by the Firefox webbrowser), with an added clause requiring that code
used for academic publications be distributed.</p>

<br clear="both" />

<?php
FinaliseHTML('$OpenPave: www/index.php,v 1.8 2013/11/01 18:09:59 reg Exp $');
?>