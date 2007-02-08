<?php
/*
 *  community.php - OpenPave.org Community
 *
 *  $OpenPave: www/community.php,v 1.2 2007/02/08 19:18:04 reg Exp $
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
 *  The Original Code is OpenPave.org Web pages.
 *
 *  The Initial Developer of the Original Code is OpenPave.org.
 *
 *  Portions Copyright (C) 2006 OpenPave.org.
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
repository.  OpenPave.org uses <a href="http://www.nongnu.org/cvs/">
CVS</a>, which is a used by a very large number of projects.  It was
chosen because of its good <a href="http://www.wincvs.org/">Windows
support</a>.  The OpenPave.org CVS Repository can be browsed online at
<a href="/cgi-bin/cvsweb.cgi/">
http://www.openpave.org/cgi-bin/cvsweb.cgi/</a>, although to use the
code you will need a CVS client.  If you are using Windows,
<a href="http://www.wincvs.org/">WinCVS</a> is the best solution.  Other
operating systems normally include CVS.  The CVS can be accessed
anonymously via these commands.</p>

<p><pre>
cvs -d:pserver:anonymous@cvs.openpave.org:/home/cvs login

cvs -d:pserver:anonymous@cvs.openpave.org:/home/cvs co <i>module</i> 
</pre></p>

<p>The other major component of community is mailing lists, which
provide the forum for discussion.  There are a number of OpenPave.org
mailing lists which you can join.  These are available via the 
<a href="/mailman/listinfo">Mailman interface</a>.</p>

<p>Finally, there is also a need to track bugs, feature requests and
other issues.  OpenPave.org makes use of Roundup for this task, and this
can be accessed via at <a href="/cgi-bin/roundup.cgi/roundup/">
http://www.openpave.org/cgi-bin/roundup.cgi/roundup/</a>.</p>

<?php
FinaliseHTML('$OpenPave: www/community.php,v 1.2 2007/02/08 19:18:04 reg Exp $');
?>