<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("../../config.php");
global $USER,$DB,$CFG;

$PAGE->set_url("/local/staffmanager/rates.php");
$PAGE->set_context(context_system::instance());

// get the id from the form
$id = optional_param("id",'',PARAM_TEXT);

require_login();

require_once("forms/rates.php");

$strpagetitle = get_string("staffmanager","local_staffmanager");
$strpageheading= get_string("rates","local_staffmanager");

$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);

$mform = new rates_form(); //available bc of require once forms/rates.php
$toform = [];


if ($mform->is_cancelled()){
    // handle form cancel operation, if cancel button is present on form
    // delay of 10 seconds before redirect
    redirect("/moodle/local/staffmanager/rates.php",'',10);
}
elseif ($fromform = $mform->get_data()){
    // otherwise, if the form actually submitted data (now stored in fromform)
    
    // only update if there is an id that came back from the form (existing entry)
    if ($id){
        $obj = $DB->get_record("local_staffmanager_rates",["id"=>$id]);
        $obj->month = $fromform->month;
        $obj->year = $fromform->year;
        $obj->assignmentrate = $fromform->assignmentrate;
        $obj->quizrate = $fromform->quizrate;
        $DB->update_record("local_staffmanager_rates",$obj);
    }
    else{
        // if no id exists, then add the data to the form as new record
        $obj = new stdClass();
        $obj->month = $fromform->month;
        $obj->year = $fromform->year;
        $obj->assignmentrate = $fromform->assignmentrate;
        $obj->quizrate = $fromform->quizrate;
        $orgid = $DB->insert_record("local_staffmanager_rates",$obj,true,false);
    }
    // when db is modified, return to rates page and display success notification
    redirect("/moodle/local/staffmanager/rates.php","Changes saved",10, \core\output\notification::NOTIFY_SUCCESS);
}
else{
    // if the form isn't cancelled and isn't submitted, then the form is just waiting for data to be entered in (i.e edit mode)
    if ($id){
        $toform = $DB->get_record("local_staffmanager_rates",["id"=>$id]);
    }
    
    // set default data (if any)
    $mform->set_data($toform);
    
    echo $OUTPUT->header();
    $mform->display();
    
    echo $OUTPUT->footer();
}