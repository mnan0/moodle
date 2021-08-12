<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../config.php'; // two folders above

global $USER, $DB, $CFG; // useful global variables

$PAGE->set_url('/local/staffmanager/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->requires->js("/local/staffmanager/assets/staffmanager.js");

require_login(); // require certain permissions before viewing this page

// get the month and year parameters from the url to be passed to the template
$month = optional_param("month","",PARAM_TEXT);
$year = optional_param("year", "", PARAM_TEXT);
$obj = new stdClass();
$obj->month = (int)$month;
$obj->year = (int)$year;

$strpagetitle = get_string('staffmanager','local_staffmanager'); //relates to language file. 
// for page title --> look for local_staffmanager file and then find the string that is called "staffmanager"
//  then set the title to that

$strpageheading = get_string('staffmanager','local_staffmanager');

$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);
echo $OUTPUT->header();

// include the template between the header and footer (notice the filepath style, don't need extension)
// notice the data array is empty, can be filled and sent to the template to be used
// the data array is now full with the object we made above
echo $OUTPUT->render_from_template("local_staffmanager/searchbar",$obj);
echo $OUTPUT->render_from_template("local_staffmanager/searchresults",[]);

echo $OUTPUT->footer();
