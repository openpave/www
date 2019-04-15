<?php
/*
 *  community.php - OpenPave.org Community
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

<h2>The OpenPave.org Community</h2>

<p>Open source software is built by communities, and as such open source
projects need to provide an infrastructure in which that community can
work.  The heart of an open source project is the source code
repository.  OpenPave.org uses <a href="https://github.com/">
GitHub</a>, which is a used by a very large number of projects.  
The OpenPave.org GitHub repositories can be browsed online at
<a href="https://github.com/openpave/">
https://github.com/openpave/</a>, although to use the
code you will need to follow the build instructions or download a 
pre-built application.</p>  GitHub is also used for issue tracking and
other features.

<?php
FinaliseHTML('');
?>