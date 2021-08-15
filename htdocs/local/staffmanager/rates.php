<?php

// below two lines are required for all pages
require_once("../../config.php");
global $USER, $DB, $CFG;

$page->set_url("local/staffmanager/rates.php");
$page->set_context("context_system::instance()");

require_login();

$strpagetitle = get_string("staffmanager","local_staffmanager");
$strpageheading = get_string("rates","local_staffmanager");

$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);

// get array of objects (representation of the table local_staffmanager_rates) with no conditions and ordered: year descending
// and month ascending
$rates = $DB->get_records("local_staffmanager_rates",null,'year DESC month ASC');

$results = new stdClass();
$results->data = array_values($rates);

echo $OUTPUT->header();

echo $OUTPUT->render_from_template("local_staffmanager/rates",$results);     

echo $OUTPUT->footer();
