<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../config.php'; // two folders above

global $USER, $DB, $CFG; // useful global variables -- user, database API, config

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

//convert the month and year numbers into a string of the month name
$obj->monthname = date("F",strtotime("$month/2/$year"));

$strpagetitle = get_string('staffmanager','local_staffmanager'); //relates to language file. 
// for page title --> look for local_staffmanager file and then find the string that is called "staffmanager"
//  then set the title to that

$strpageheading = get_string('staffmanager','local_staffmanager');

$PAGE->set_title($strpagetitle);
$PAGE->set_heading($strpageheading);

// database script

$results = new stdClass();
$start = mktime(0,0,0,$obj->month,1,$obj->year);
$end = mktime(23,59,00,$obj->month + 1,0,$obj->year); // it's a one-month long query (day 0 is the last day of the prev. month)

// the grade_grades table tracks all grades for all users in the system
// one of the columns is usermodified, which holds the id of users who modify the grades for each item (i.e. instructors/admins)
// select all distinct usermodified entities and use shorthand: usermodified as graderid and grade_grades as gg
// left join operates on two tables, a left and a right table. the part of the query after ON is the join-predicate.
// for each row in the left table, the query compares it with all rows in the right table and evaluates the join-predicate each time
// if the join-predicate evaluates to true, the pair of rows is added to the result set
// here, grade_grades is the left table and user is the right table
// the result set is the rows where the userid is the same as tthe graderid (i.e. we're combining the rows to get a more detailed look at the graders' info
// conditions: the usermodified can't be null, the finalgrade can't be 0 (must have been completed by student),
// timemodified must be after start of system and before end of system
$sql = "SELECT DISTINCT(gg.usermodified) AS graderid
    FROM {grade_grades} AS gg
    LEFT JOIN {user} AS grader ON grader.id = gg.usermodified
    WHERE gg.usermodified <> '' AND gg.finalgrade > 0 AND gg.timemodified >= ". $start." AND gg.timemodified <=".$end;
$graders = $DB->get_records_sql($sql);

foreach($graders AS $key => $value)
{
    // interpret the graders table as a dictionary where keys are rows. Each row is an object and contains references to contents of row
    // get the row from the user table where the id is the same as from $graders' row
    // which fields/columns do we want returned from the user table? firstname, lastname, id, email
    // assignment statement --> replace the row in the table with the generated row
    $graders[key] = $DB->get_record("user",["id"=>$graders[$key]->graderid],"firstname,lastname, id, email");
}

$results->data = array_values($graders); //resets the array indexing so data object can be read by mustache template
echo $OUTPUT->header();

// include the template between the header and footer (notice the filepath style, don't need extension)
// notice the data array is empty, can be filled and sent to the template to be used
// the data array is now full with the object we made above
echo $OUTPUT->render_from_template("local_staffmanager/searchbar",$obj);
echo $OUTPUT->render_from_template("local_staffmanager/searchresults",$results);

echo $OUTPUT->footer();
