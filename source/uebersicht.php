<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of firmenzulassung
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_firmenzulassung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace firmenzulassung with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... firmenzulassung instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('firmenzulassung', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $firmenzulassung  = $DB->get_record('firmenzulassung', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $firmenzulassung  = $DB->get_record('firmenzulassung', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $firmenzulassung->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('firmenzulassung', $firmenzulassung->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_firmenzulassung\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $firmenzulassung);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/firmenzulassung/uebersicht.php', array('id' => $cm->id, 'anfrageid' => $_GET['anfrageid']));
$PAGE->set_title(format_string($firmenzulassung->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('firmenzulassung-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($firmenzulassung->intro) {
    echo $OUTPUT->box(format_module_intro('firmenzulassung', $firmenzulassung, $cm->id), 'generalbox mod_introbox', 'firmenzulassungintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading(get_string('title', 'mod_firmenzulassung'));

// Implement form for user
// TODO: connect with activity, and decide which form should be shown
require_once(dirname(__FILE__).'/forms/antragsUebersicht/Uebersicht.php');
$mform = new Uebersicht();

require_once(dirname(__FILE__).'/backend/DbConnectivity.php');
$dbConnectivity = new DbConnectivity();

// $mform->render();

// error_log("TEST FROM BEFORE DISPLAY");

//Form processing and displaying is done here
if ($fromform = $mform->get_data()) {
    
    if (!empty($fromform->genehmigen)) {
        $genehmigt = true;
    } elseif (!empty($fromform->ablehen)) {
        $genehmigt = false;
    }

    //TODO: Save changes (Besichtigungstermin etc.)
    //...

    //TODO: Testing
    if ($genehmigt && !isset($fromform->besichtigt)) {
        //approval is only allowed if the Studiengangsleiter has visited the company
        //TODO: Error Message goes here 'Der Antrag kann erst nach einem Besuch beim Unternehmen genehmigt werden!'
        error_log('Der Antrag kann erst nach einem Besuch beim Unternehmen genehmigt werden!');

    } else {

        try {
            // the magic trick to update the application status and check if user is allowed to perfom this action
            processApplication($_GET['anfrageid'], $genehmigt, $fromform->comment);

        } catch (Exception $e) {
            error_log($e->getTraceAsString());

            //TODO: Handle error messages...
            // The exception message should be visible for the user
        }

    }
    //$PAGE->set_url('/mod/firmenzulassung/view.php', array('id' => $cm->id));
    $PAGE->set_url('/mod/firmenzulassung/uebersicht.php', array('id' => $cm->id, 'anfrageid' => $_GET['anfrageid']));


    //$value1 = $fromform->email;
    //$value2 = $fromform->name;

    //echo $value1;
    //error_log($value1);

  //In this case you process validated data. $mform->get_data() returns data posted in form.
  //Creating instance of relevant API modules
 /* create_api_instances();
  $process_definition_id = firmenzulassung_get_process_definition_id("testttest");
  error_log("PROCESS DEFINITION ID IS: " . $process_definition_id);
  $process_instance_id = firmenzulassung_start_process($process_definition_id, "test_key");
  error_log("PROCESS INSTANCE ID IS: " . $process_instance_id);
  sleep(2);
  error_log("WAKEY WAKEY, BOYS AND GIRLS");
  $taskid = firmenzulassung_check_for_input_required($process_instance_id);
  error_log("TASK ID IS: " . $taskid);
  if ($taskid != null) {
    error_log("EXECUTION OF TASK RESPONSE");
    $value1 = $fromform->email;
    $value2 = $fromform->name;
    $result = firmenzulassung_answer_input_required($taskid, $process_definition_id, $value1, $value2);
    error_log("INPUT SEND RESULT IS: " . $result);
  }*/
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.
 
  // Set default data (if any)
  // Required for module not to crash as a course id is always needed
  $formdata = array('id' => $id, 'anfrageid' => $_GET['anfrageid']);
  $mform->set_data($formdata);
  //displays the form
  $mform->display();

  error_log("TEST FROM AFTER DISPLAY");
}

// Finish the page.
echo $OUTPUT->footer();

/*
function saveChanges() {
    if ($fromform->aufnahme == 1) {
        $aufnahme = [
            "aufnahme" => $fromform->aufnahme,
            "datum" => $fromform->inhaltOpt2DS
        ];
    } else {
        $aufnahme = [
            "aufnahme" => $fromform->aufnahme,
            "datum" => NULL
        ];
    }

    if (isset($fromform->besichtigt)) {
        $besichtigung = $fromform->datumUNehmenBes;
    } else {
        $besichtigung = NULL;
    }

    $dbConnectivity->changeStatus([
        "genehmigt" => $genehmigt,
        "generell" => [
            "verantwortlicher" => $fromform->responsible,
            "studiengang" => $fromform->studiengang
        ],
        "antragsbearbeitung" => [
            "aufnahme" => $aufnahme
        ],
        "zulassungprozess" => [
            "besichtigung" => $besichtigung
        ]
    ]);
}
*/