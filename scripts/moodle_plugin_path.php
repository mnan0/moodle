<?php                                                                                                        
 define('CLI_SCRIPT', true);
 error_reporting(E_ALL ^ E_NOTICE);
 require('C:/xampp/apps/moodle/htdocs/config.php'); // global moodle config file.
 $moodle_path = get_plugin_types();
 foreach ($moodle_path as $key => $val){
    $lon = strlen($val);
    $pos = strpos($val, 'htdocs');
    $pos2 = $pos+7;
    $moodle_dir = substr($val, $pos2, $lon);
    echo "$moodle_dir\n";
    }