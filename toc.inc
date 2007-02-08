<?php
/*
 *  toc.inc - Master Table of Contents for website
 *
 *  $OpenPave: www/toc.inc,v 1.2 2007/02/08 19:18:04 reg Exp $
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
 *
 * This file is the master index for the website.  If contains a
 * multi-level array, where each leaf node key must be unique, and have
 * the same name as the php script for that page.  The values are
 * given by a string of the form "text [not in menu] <url>".
 */

$toc = array(
  'index' => array(
    'index' => 'Home',
    'about' => 'About',
    'license' => 'License',
  ),
  'projects' => array(
    'projects' => 'Projects'
  ),
  'documents' => array(
    'documents' => 'Documentation'
  ),
  'community' => array(
    'community' => 'Community',
    'mail' => 'Mailing Lists </mailman/listinfo/>',
    'cvs' => 'CVS Repository </cgi-bin/cvsweb.cgi/>',
    'bugs' => 'Issue Tracker </cgi-bin/roundup.cgi/roundup/>'
  ),
);

?>