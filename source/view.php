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
require_once(dirname(__FILE__).'/backend/DbConnectivity.php');

$dbanfrage = new DbConnectivity();

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


// Um Tabelle >>antraege<< zu belegen

$record = new stdClass();
$record->firstname          = 'Ragnar';
$record->surname            = 'Lothbrok';
$record->company            = 'Shieldwall Defense';
$record->phone              = '0800123456';
$record->email              = 'SonOfOdin@walhallamail.com';
$record->fax                = '0800123450';
$record->industry           = 'Logistik';
$record->city               = 'Kathegatt';
$record->zipcode            = '98912';
$record->street             = 'Freyastraße';
$record->number             = '1';
$record->count_employees    = '3030';
$record->count_mercantile   = '1';
$record->count_technical    = '0';
$record->count_other        = '0';
$record->chamber_name       = 'Vikings';
$record->chamber_city       = 'Kathegatt';
$record->reward             = '850';
$record->imparting          = '0';
$record->start              = '01.01.930';
$record->major_present      = 'ja';
$record->responsible        = null;
$record->is_visited         = 0;
$record->visit_date         = null;
$record->app_date           = '07.07.2018';
$record->firmenliste_aufnahme = 0;
$record->firmenliste_aufnahme_date = null;


$applicationID = $DB->insert_record('firmenzulassung_antraege', $record, $returnid=true, $bulk=false);

//echo 'MARKER: [INFO] $applicationID = \''.$applicationID.'\'.';

$dbanfrage->insertDefaultApplicationHistoryEntry($applicationID);


/* PAGE belegen*/
$PAGE->set_url('/mod/firmenzulassung/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($firmenzulassung->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('firmenzulassung-'.$somevar);
 */

// Hier beginnt die Ausgabe
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($firmenzulassung->intro) {
    echo $OUTPUT->box(format_module_intro('firmenzulassung', $firmenzulassung, $cm->id), 'generalbox mod_introbox', 'firmenzulassungintro');
}

$strName = "Antrags-Übersicht";
echo $OUTPUT->heading($strName);

$attributes = array();

/*
//TO-DO: remove in productivity
$tableTest = new html_table();
$tableTest->head = array('Entry ID','Application ID', 'Status','Date', 'User', 'Reason');

$statusTableEntries = $DB->get_records('firmenzulassung_status');

foreach ($statusTableEntries as $entry) {
    //echo 'MARKER: [INFO] Entry '.$entry->id.' for Application ID '.$entry->application_id.' with Status '.$entry->status.' and reason \''.$entry->reason.'\'.       || ';

    $id = $entry->id;
    $app_id = $entry->application_id;
    $date = $entry->date;
    $status = $entry->status;
    $user = $entry->user;
    $reason = $entry->reason;

    $tableTest->data[] = array($id, $app_id, $status, $date, $user, $reason);
}
echo html_writer::table($tableTest);
*/

// Alle Datensätze aus der DB-Tabelle >>antrag<< abfragen.
$resource = $DB->get_records('firmenzulassung_antraege');

$table = new html_table();
$table->head = array('ID','Bewerbungsdatum', 'Status','Firma', 'Unternehmensvertreter', 'Verantwortlicher', 'öffnen', 'löschen');

//Für jeden Datensatz
foreach ($resource as $res) {
    $id = $res->id;
    $app_date = $res->app_date;
//$status = get_string('status' . $res->status, 'mod_firmenzulassung');

    $currentStatus = $dbanfrage->getCurrentStatus($id);

    //echo 'MARKER: [INFO] Application '.$res->id.' with $currentStatus = \''.$currentStatus.'\'.';

    $status = get_string('status'.$currentStatus, 'mod_firmenzulassung');
    $company = $res->company;
    $surname = $res->surname;
    $responsible = $dbanfrage->getUserIDToName($res->responsible);


    //Link zum Bearbeiten der aktuellen Ressource in foreach-Schleife setzen
    $htmlLink = html_writer::link(new moodle_url('../firmenzulassung/uebersicht.php', array('id' => $cm->id, 'anfrageid' => $res->id, 'action' => 'view')), 'öffnen', $attributes = null);
    //Analog: Link zum Löschen...
    $htmlLinkDelete = html_writer::link(new moodle_url('../firmenzulassung/delete.php', array('id' => $cm->id, 'anfrageid' => $res->id)), 'löschen', $attributes = null);
    //Analog: Link Vertreter Bearbeiten...
    $htmlLinkResponsible = html_writer::link(new moodle_url('../firmenzulassung/uebersicht.php', array('id' => $cm->id, 'anfrageid' => $res->id, 'action' => 'selectResponsible')), $responsible, $attributes = null);
    //Daten zuweisen an HTML-Tabelle
    $table->data[] = array($id, $app_date, $status, $company, $surname, $htmlLinkResponsible, $htmlLink, $htmlLinkDelete);
}
//Tabelle ausgeben
echo html_writer::table($table);

// Finish the page.
echo $OUTPUT->footer();
