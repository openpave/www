<?php

/*
 * $OpenPave: www/toc.inc,v 1.1 2006/10/26 23:34:20 reg Exp $
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