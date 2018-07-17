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
 * Prints a particular instance of apeins
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_apeins
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace apeins with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... apeins instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('apeins', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $apeins  = $DB->get_record('apeins', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $apeins  = $DB->get_record('apeins', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $apeins->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('apeins', $apeins->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_apeins\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $apeins);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/apeins/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($apeins->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('apeins-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($apeins->intro) {
    echo $OUTPUT->box(format_module_intro('apeins', $apeins, $cm->id), 'generalbox mod_introbox', 'apeinsintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Antrag auf Zulassung als Ausbildungsstätte');

// Implement form for user
require_once(dirname(__FILE__).'/forms/simpleform.php');


// if it has been submited, then process it
if (isset($_POST['btnSubmit'])) {
	try {
		if (isset($_POST['internVollVermittelt'])) {
			$vermittelung = 0;
		} else if (isset($_POST['internNurTeilweiseVermittelt'])) {
			$vermittelung = 1;
		} else {
			$vermittelung = "";
		}
		
		$id = $DB->insert_record('antraege', [
			"app_date" => date("d.m.Y"),
			"firstname" => $_POST['vorname'],
			"surname" => $_POST['nachname'],
			"phone" => $_POST['telefonnummer'],
			"email" => $_POST['email'],
			"fax" => $_POST['fax'],
			"company" => $_POST['name'],
			"industry" => $_POST['branche'],
			"city" => $_POST['stadt'],
			"zipcode" => $_POST['postleitzahl'],
			"street" => $_POST['strasse'],
			"number" => $_POST['nummer'],
			"count_technical" => $_POST['anzahlDerTechnischenAuszubildenden'],
			"count_other" => $_POST['anzahlSontigerAuszubildenden'],
			"chamber_name" => $_POST['mitgliedDerKammer'],
			"chamber_city" => $_POST['in'],
			"reward" => $_POST['hoeheDerAusbildungsverguetung'],
			"" => $_POST['userfile'],
			"inhalteDesAusbildungsplanes" => $vermittelung,
			"" => $_POST['sofortNachZulassung'],
			"" => $_POST['ueberHauptNicht'],
			"responsible" => $_POST['zulassung']
		], $return_id=true, $bulk=false);
		
		/*$DB->insert_record('status', [		
			"application_id" => $id,
			"date" => date("d.m.Y"),
			"user" => "guest",
			"status" => 0		
		], $return_id=false, $bulk=false);*/
		
		echo $OUTPUT->heading('Your request has been successfully submitted.');
	} catch (Exception $e) { 
		echo $e;
		echo $OUTPUT->heading('Ooops. Something went wrong.');
	}
	//catch
	
	
	

} else {
	$mform = new simplehtml_form();
}
//otherwise, create the form:

// $mform->render();

// error_log("TEST FROM BEFORE DISPLAY");

//Form processing and displaying is done here
if (isset($mform)) {
	if ($mform->is_cancelled()) {
		//Handle form cancel operation, if cancel button is present on form
	} /*/else if ($fromform = $mform->get_data()) {
		$value1 = $fromform->nachname;
		$value2 = $fromform->email;
		$value3 = $fromform->vorname;
		$value4 = $fromform->telefonnummer;
		$value5 = $fromform->fax;
		$value6 = $fromform->studiengang;
		
		echo $value1;
		error_log($value1);

	  //In this case you process validated data. $mform->get_data() returns data posted in form.
	  //Creating instance of relevant API modules
	  create_api_instances();
	  $process_definition_id = apeins_get_process_definition_id("testttest");
	  error_log("PROCESS DEFINITION ID IS: " . $process_definition_id);
	  $process_instance_id = apeins_start_process($process_definition_id, "test_key");
	  error_log("PROCESS INSTANCE ID IS: " . $process_instance_id);
	  sleep(2);
	  error_log("WAKEY WAKEY, BOYS AND GIRLS");
	  $taskid = apeins_check_for_input_required($process_instance_id);
	  error_log("TASK ID IS: " . $taskid);
	  if ($taskid != null) {
		error_log("EXECUTION OF TASK RESPONSE");
		$value1 = $fromform->email;
		$value2 = $fromform->nachname;
		$value3 = $fromform->vorname;
		$value4 = $fromform->telefonnummer;
		$value5 = $fromform->fax;
		$value6 = $fromform->studiengang;
		$result = apeins_answer_input_required($taskid, $process_definition_id, $value1, $value2);
		error_log("INPUT SEND RESULT IS: " . $result);
	  }
	}*/ else {
	  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
	  // or on the first display of the form.
	 
	  // Set default data (if any)
	  // Required for module not to crash as a course id is always needed
	  $formdata = array('id' => $id);
	  $mform->set_data($formdata);
	  //displays the form
	  $mform->display();

	  error_log("TEST FROM AFTER DISPLAY");
	}
}

// Finish the page.
echo $OUTPUT->footer();