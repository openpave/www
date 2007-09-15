<?php
/*
 *  building.php - OpenPave.org Documentation
 *
 *  $OpenPave: www/building.php,v 1.1 2007/09/15 01:50:35 reg Exp $
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

<h2>Building OpenPave.org Code</h2>

<p>Building OpenPave.org projects require little more than just downloading
and building them, expect on Windows, where you will need to get a working
building environment up and running first.  OpenPave.org's build system is
based on that used by Mozilla.</p>

<h3>Setting up a Windows build environment</h3>

<p>The build system makes use of a number of Unix utilities, and the best
way to install these is with <a href="http://www.cygwin.com/">Cygwin</a>. 
Download <a href="http://www.cygwin.com/setup.exe">setup.exe</a> and run it. 
Make sure to install the make, diffutils, patchutils and cvs packages, along
with the normal defaults.</p>

<p>If you don't already have a working Visual C++ installation, then first,
download and install Visual C++ Express Edition (after selling your soul for
a Microsoft Passport).  At the moment the code does not work with Visual C++
6.0, although this will be fixed at some point.</p>

<h3>Setting up a Unix build environment</h3>

<p>Openpave.org builds have been tested on FreeBSD, Linux and Mac OS X. 
These all come with the tools needed (except FreeBSD where you'll need the
gmake port installed - cd /usr/ports/devel/gmake && make install clean).</p>

<h3>Doing an initial checkout of the source code</h3>

<p>Once you have a working build environment then you can start.  First,
check out the makefile which controls the entire process, using CVS:</p>
<pre>
cvs -d:pserver:anonymous@cvs.openpave.org:/home/cvs co openpave/openpave.mk 
</pre>

<p>At this point you could download all projects and build them by just
running:</p>
<pre>
cd openpave && gmake -f openpave.mk
</pre>

<h3>Setting up an OPCONFIG file</h3>

<p>If you are planning on doing anything more serious than but browsing the
code, you should create an opconfig file.  Particularly, this allows you to
control which of the projects are checkout and built.  You can copy and
paste the example below, saving it either in the directory where you run the
checkout command above, the openpave directory it created, or in your home
directoy.  The file should be named "opconfig". If you wish to name it
something else set the enironment variable OPCONFIG to the full path and
filename of the file.</p>

<pre>
# Options for openpave.mk.
mk_add_options OP_PROJECTS=test,libop,fem3d
mk_add_options OP_MAKE_ARGS="--no-print-directory"
mk_add_options OP_OBJDIR=@TOPSRCDIR@/op-dbg

# Options for 'configure' (same as command-line options).
ac_add_options --disable-debug
ac_add_options --enable-optimize="-O3 -march=pentium3"
</pre>

<p>The following <strong>mk_add_options</strong> are available:</p>

<dl>
<dt>OP_PROJECTS</dt>
	<dd>Comma seperated list of projects to build.  See the top of
	openpave.mk for options.</dd>
<dt>OP_CVS_ARGS</dt>
	<dd>Additional arguements for CVS.</dd>
<dt>OP_CO_ARGS</dt>
	<dd>Additional arguements for CVS checkout (default is -P).</dd>
<dt>OP_CO_DATE</dt>
	<dd>Check out at a particular date.</dd>
<dt>OP_CO_TAG</dt>
	<dd>Check out files with a particular tag.</dd>
<dt>OP_OBJDIR</dt>
	<dd>A directory to build in rather than muck up the source tree.</dd>
<dt>OP_AUTOCONF</dt>
	<dd>If set, run autoconf locally.  For when you're planning on
	editing configure.in</dd>
<dt>OP_MAKE_ARGS</dt>
	<dd>Additional arguements to pass to make.</dd>
</dl>

<p>The following <strong>ac_add_options</strong> are available, along with a
number of options normally available for a autoconf build (see configure
--help):</p>

<dl>
<dt><em>--enable-debug</em>=flags / --disable-debug</dt>
	<dd>Enable or disable debug, or set special debug compiler
	flags.</dd>
<dt>--enable-debug-rtl</dt>
	<dd>Enable linking with Microsoft debug runtime libraries (for
	easier debuging on Windows).</dd>
<dt>--enable-optimize=flags / <em>--disable-debug</em></dt>
	<dd>Enable or disable optimization, or set special compiler
	flags.</dd>
</dl>

<p>In addition, the following environment variables affect the build:</p>

<dl>
<dt>OPCONFIG</dt>
	<dd>Controls the path and filename used for opconfig.</dd>
<dt>CVSROOT</dt>
	<dd>Controls the CVS root used for checkouts.  If you have an
	OpenPave.org account you can set this to
	:ext:<em>reg</em>@cvs.openpave.org:/home/cvs once you have set up
	SSH access.</dd>
<dt>AUTOCONF</dt>
	<dd>Sets the name of autoconf.  OpenPave.org requires autoconf 2.13,
	which is called autoconf-2.13 on FreeBSD and Cygwin.  This is only
	used if OP_AUTOCONF is set.</dd>
<dt>CC and CXX</dt>
	<dd>Set the names of the C and C++ compilers respectively.</dd>
</dl>

<h3>Building projects</h3>

<p>Finally, the commands to checkout the source code and build it are:</p>

<pre>
cd openpave && gmake -f openpave.mk checkout

cd openpave && gmake -f openpave.mk build
</pre>

<p>These will automatically pick up the options you set, and should result
in working output.  At the moment, the build system does not support
installing the built projects, but will soon.</p>

<h3>Example scripts</h3>

<p>Below are some example scripts and batch files which might help.  The
first two are for Unix, and the second two for Windows.</p>

<pre>
#!/bin/sh
# save me as op-checkout.sh and chmod +x me.
export CVSROOT=:ext:reg@cvs.openpave.org:/home/cvs
export OPCONFIG=$PWD/opconfig
if [ ! -f openpave/openpave.mk ]; then
	cvs co openpave/openpave.mk
fi;
cd openpave
gmake -f openpave.mk checkout
</pre>

<pre>
#!/bin/sh
# save me as op-build.sh and chmod +x me.
export OPCONFIG=$PWD/opconfig
cd openpave
gmake -f openpave.mk build
</pre>

<pre>
rem save me as op-co.bat
cd C:\source

"c:\Program Files\PuTTY\pageant.exe" "C:\Documents and Settings\Jeremy Lea\.ssh\id_dsa.ppk"

set CVSROOT=:ext:reg@cvs.openpave.org:/home/cvs
set HOME=C:\source
set PATH=C:\source\cygwin\bin;
set OPCONFIG=C:\source\opconfig

cvs checkout openpave/openpave.mk
cd openpave
make -f openpave.mk checkout
cd ..
</pre>

<pre>
rem save me as op-build.bat
cd C:\Source

set HOME=C:\source
set PATH=C:\source\cygwin\bin;
set OPCONFIG=C:\source\opconfig
set AUTOCONF=autoconf-2.13
rem call "C:\Program Files\Microsoft Visual Studio\VC98\Bin\vcvars32.bat"
call "C:\Program Files\Microsoft Visual Studio 8\VC\vcvarsall.bat" x86

cd openpave
make -f openpave.mk build
cd ..
</pre>

<?php
FinaliseHTML('$OpenPave: www/building.php,v 1.1 2007/09/15 01:50:35 reg Exp $');
?>