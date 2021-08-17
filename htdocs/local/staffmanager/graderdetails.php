<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../config.php";
global $USER, $DB, $CFG;

$PAGE->set_url("/local/staffmanager/graderdetails.php");
$PAGE->set_context(context_system::instance());

require_login();

$strpagetitle = get_string("staffmanager","local_staffmanager");
$strpageheading = get_string("searchstaff","local_staffmanager");
$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);

$month = optional_param("month","",PARAM_TEXT);
$year = optional_param("year","",PARAM_TEXT);
$graderid = optional_param("grader","",PARAM_TEXT);

$start = mktime(0,0,0,$month,1,$year);
$end = mktime(23,59,00,$month+1,0,$year);

$grader = $DB->get_record("user",["id"=>$graderid],"firstname,lastname,id,email");
