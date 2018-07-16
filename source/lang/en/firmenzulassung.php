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
 * English strings for firmenzulassung
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_firmenzulassung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'firmenzulassung';
$string['modulenameplural'] = 'firmenzulassung';
$string['modulename_help'] = 'Use the firmenzulassung module for... | The firmenzulassung module allows...';
$string['firmenzulassung:addinstance'] = 'Add a new firmenzulassung';
$string['firmenzulassung:submit'] = 'Submit firmenzulassung';
$string['firmenzulassung:view'] = 'View firmenzulassung';
$string['firmenzulassungfieldset'] = 'Custom example fieldset';
$string['firmenzulassungname'] = 'firmenzulassung name';
$string['firmenzulassungname_help'] = 'This is the content of the help tooltip associated with the firmenzulassungname field. Markdown syntax is supported.';
$string['firmenzulassung'] = 'firmenzulassung';
$string['pluginadministration'] = 'firmenzulassung administration';
$string['pluginname'] = 'firmenzulassung';


$string['title'] = 'Antrag auf Zulassung';

/**
 * Form main strings
 */
$string['responsible'] = 'Verantwortlicher';
$string['status'] = 'Status';
$string['antragsdatum'] = 'Antragsdatum';
$string['studiengang'] = 'Studiengang';

$string['status-3'] = 'abgelehnt durch Studiengangsleiter';
$string['status-2'] = 'abgelehnt durch Dekan';
$string['status-1'] = 'abgelehnt durch Studiengangsleiter';
$string['status0'] = 'neu';
$string['status1'] = 'genehmigt durch Studiengangsleiter';
$string['status2'] = 'genehmigt durch Dekan';
$string['status3'] = 'genehmigt durch Rektorat';

/**
 * Form 1. Angaben zum Angesteller als Unternehmen
 */
$string['subtitle1'] = '1. Angaben zum Antragsteller als Unternehmen';
$string['vorname'] = 'Vorname';
$string['nachname'] = 'Nachname';
$string['email'] = 'E-Mail Adresse';
$string['tel'] = 'Telefonnummer';
$string['fax'] = 'Fax';

/**
 * Form 2. Angaben zum Unternehmen
 */
$string['subtitle2'] = '2. Angaben zum Unternehmen';
$string['name'] = 'Name';
$string['branche'] = 'Branche';
$string['mitgliedKammer'] = 'Mitglied der Kammer';
$string['in'] = 'In';
$string['stadt'] = 'Stadt';
$string['postleitzahl'] = 'Postleitzahl';
$string['anzahlMitarbeiter'] = 'Anzahl der Mitarbeiter';
$string['anzahlKaufmAusb'] = 'Anzahl der kaufm. Ausbildenden';
$string['strasse'] = 'Straße';
$string['nummer'] = 'Nummer';
$string['anzahlTechnischenAusb'] = 'Anzahl der technischen Auszubildenden';
$string['anzahlSonstigerAusb'] = 'Anzahl der sonstiger Auszubildenden';

/**
 * Form 3. Angaben zur Ausbildung
 */
$string['subtitle3'] = '3. Angaben zur Ausbildung';
$string['verguetung'] = 'Höhe der Ausbildungsvergütung';

$string['ausbildungsplanInhalte'] = 'Die Inhalte des Ausbildungsplanes werden...';
$string['vermittelt0'] = 'intern voll vermittelt.';
$string['vermittelt1'] = 'intern nur teilweise vermittelt.';

$string['ausbildungsplanStud'] = 'Ausbildungsplan für Studierende:';

/**
 * Form 4. Antrasbearbeitung
 */
$string['subtitle4'] = '4. Antrasbearbeitung';
$string['aufnahmeText'] = 'Wir bitten um Aufnahme in die Firmenliste für Studienbewerber:';
$string['aufnahme1'] = 'sofort nach Zulassung.';
$string['aufnahme2'] = 'ab dem';
$string['aufnahme3'] = 'überhaupt nicht.';

$string['zulassungStudiengang'] = 'Eine Zulassung liegt bereits den Studiengang:';
$string['zulassungOpt-1'] = 'nicht zutreffend';

$string['kommentar'] = 'Ihre Begründung';


/**
 * Form Final: Zulassungprozess
 */
$string['subtitleFinal'] = 'Zulassungsprozess';

$string['zulassung0'] = 'Studiengangsleiter';
$string['zulassung1'] = 'Dekan';
$string['zulassung2'] = 'Rektorat';
$string['zulassung3'] = 'Abschluss';

$string['besichtigt'] = 'Das Unternehmen wurde von verantwortliche Studiengangsleiter besichtigt.';
$string['datumUNBes'] = 'Datum der Unternehmenbesichtigung';

$string['genehmigen'] = 'Genehmigen';
$string['ablehen'] = 'Ablehen';
$string['drucken'] = 'Drucken';
$string['download'] = 'Download';

$string['speichern'] = 'Speichern';

$string['maincategory'] ='maincategory';






/** 
 * BEGINNING: E-mail content for Übergabe an die Bederfsmeldung 
 */

$string['notifyemailnewdualpartner_partner'] = 'Sehr geehrte Damen und Herren von {$a},

Zur Zeit ist keine Bedarfsmeldungsabgabe möglich, allerdings werden Sie zur nächsten Runde automatisch eingeladen und über den Ablauf frühzeitig informiert.

Mit freundlichen Grüßen 
Sekretariat der Wirtschaftsinformatik (DHBW Mannheim) 


*** Diese Nachricht wurde automatisch verschickt - bitte Antworten Sie nicht auf diese E-Mail. Bei Fragen wenden Sie sich bitte an das Sekretariat der Wirtschaftsinformatik (DHBW Mannheim). ***';

$string['notifyemailnewdualpartner_studiengangsleiter'] = 'Guten Tag {$a->responsibleUser},

Der Duale Partner {$a->enrolledUser} wurde zum aktuellen Bedarfsmeldeprozess hinzugefügt. Bitte informieren Sie den Dualen Partner {$a->enrolledUser} über den Ablauf des Bedarfsmeldeprozesses.

Mit freundlichen Grüßen 
DHBW Moodle 


*** Diese Nachricht wurde automatisch verschickt - bitte Antworten Sie nicht auf diese E-Mail. Bei Fragen wenden Sie sich bitte an das Sekretariat der Wirtschaftsinformatik (DHBW Mannheim). ***';

/** 
 * END: E-mail content for Übergabe an die Bederfsmeldung 
 */