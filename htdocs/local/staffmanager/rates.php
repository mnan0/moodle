<?php

// below two lines are required for all pages
require_once("../../config.php");
global $USER, $DB, $CFG;

$PAGE->set_url('/local/staffmanager/rates.php');
$PAGE->set_context(context_system::instance());

require_login();

$strpagetitle = get_string("staffmanager","local_staffmanager");
$strpageheading = get_string("rates","local_staffmanager");

$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);

// get array of objects (representation of the table local_staffmanager_rates) with no conditions and ordered: year descending
// and month ascending
$rates = $DB->get_records("local_staffmanager_rates",null,"year DESC, month ASC");

foreach ($rates as $key => $value){
    // convert month to string
    $rates[$key]->monthname = date("F",mktime(0,0,0,$rates[$key]->month,10));
}

$results = new stdClass();
$results->data = array_values($rates);

echo $OUTPUT->header();

echo $OUTPUT->render_from_template("local_staffmanager/rates",$results);     

echo $OUTPUT->footer();
