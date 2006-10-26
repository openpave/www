<?php
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
FinaliseHTML('$OpenPave: www/community.php,v 1.1 2006/10/26 23:34:20 reg Exp $');
?>