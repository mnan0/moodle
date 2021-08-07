<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../config.php'; // two folders above

global $USER, $DB, $CFG; // useful global variables

$PAGE->set_url('local/staffmanager/index.php');
$PAGE->set_context(context_system::instance());

require_login(); // require certain permissions before viewing this page

$strpagetitle = get_string('staffmanager','local_staffmanager'); //relates to language file. 
// for page title --> look for local_staffmanager file and then find the string that is called "staffmanager"
//  then set the title to that

$PAGE->set_title($strpagetitle);
echo $OUTPUT->header();
echo $OUTPUT->footer();
