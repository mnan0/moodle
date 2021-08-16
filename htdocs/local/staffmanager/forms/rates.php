<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* form based on the form library*/
require_once("$CFG->libdir/formslib.php");

class rates_form extends moodleform{
    //add elements to form -- required for moodle
    public function definition(){
        global $CFG;
        
        $mform = $this->_form; // don't forget the underscore!
        $mform->addElement("html","<h3>Rates form</h3><br><br>");
        
        $month_options = array(
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        
        // add select with name month, description as Month, type int, default month is 1 (i.e. January)
        $mform->addElement("select","month","Month",$month_options); // add elements to your form
        $mform->setType("month",PARAM_INT);
        $mform->setDefault("month",1);
        
        // add text input with name year, description as Year, type int and no default
        $mform->addElement("text","year","Year",' size="100%" ');
        $mform->setType("year",PARAM_INT);
        $mform->setDefault("year", '');
        
        // add text input with name assignmentrate, description Assignment rate for month and year, type number, 0 default
        $mform->addElement("text","assignmentrate","Assignment rate for month and year",' size="100%" ');
        $mform->setType("assignmentrate",PARAM_NUMBER);
        $mform->setDefault("assignmentrate",0);
        
        $mform->addElement("text","quizrate","Quiz rate for month and year", ' size="100%" ');
        $mform->setType("quizrate",PARAM_NUMBER);
        $mform->setDefault("quizrate",0);
        
        // this is the submission process for moodle forms
        $buttonarray=array();
        // create a submit button that  has the word Save on it (description is Submit)
        $buttonarray[] = $mform->createElement("submit","Submit","Save");
        $buttonarray[] = $mform->createElement("cancel");
        // add to form as a group.
        // element $buttonarray, name is buttonar, label is "", separator is " ", we DON'T want the group name to be appended to the form name
        $mform->addGroup($buttonarray,"buttonar",""," ",false);
        
    }
    
    public function validation($data,$files){
        return array();
    }
}