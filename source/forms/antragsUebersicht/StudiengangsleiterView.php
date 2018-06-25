<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once(dirname(dirname(dirname(__FILE__))).'/backend/DbConnectivity.php');

class StudiengangsleiterView extends moodleform {
    //Add elements to form
    
    public function definition() {
        global $CFG;
        
        $mform = $this->_form;
        $dbConnectivity = new DbConnectivity();
        
        // Verantwortlicher
        $mform->addElement('select', 'responsible', get_string('responsible', 'mod_apsechs'),
            $dbConnectivity->getResponsibles()['name'],
            $dbConnectivity->getResponsibles()['user_id']);
        
        $mform->setDefault('responsible', $dbConnectivity->getCurrentResponsible());
        
        // Status
        $mform->addElement('static', 'status', get_string('status', 'mod_apsechs'), $dbConnectivity->getCurrentStatus());
        
        // Antragsdatum
        $mform->addElement('static', 'requestDate', get_string('antragsdatum', 'mod_apsechs'), $dbConnectivity->getRequestDate());
        
        // Studiengang
        $mform->addElement('select', 'studiengang', get_string('studiengang', 'mod_apsechs'),
            $dbConnectivity->getStudiengangs()['name'],
            $dbConnectivity->getStudiengangs()['id']);
        
        // 1. Angaben zum Unternehmen
        $mform->addElement('header', 'angabenZumAntragstellerAlsUnternehmen', get_string('subtitle1', 'mod_apsechs'));
        
        $mform->addElement('text', 'vorname', get_string('vorname', 'mod_apsechs'));
        $mform->setDefault('vorname', $dbConnectivity->getMetaData()["angesteller"]["vorname"]);
        $mform->setType('vorname', PARAM_TEXT);
        
        $mform->addElement('text', 'nachname', get_string('nachname', 'mod_apsechs'));
        $mform->setDefault('nachname', $dbConnectivity->getMetaData()["angesteller"]["nachname"]);
        $mform->setType('nachname', PARAM_TEXT);
        
        $mform->addElement('text', 'email', get_string('email', 'mod_apsechs'));
        $mform->setDefault('email', $dbConnectivity->getMetaData()["angesteller"]["email"]);
        $mform->setType('email', PARAM_TEXT);
        
        $mform->addElement('text', 'tel', get_string('tel', 'mod_apsechs'));
        $mform->setDefault('tel', $dbConnectivity->getMetaData()["angesteller"]["tel"]);
        $mform->setType('tel', PARAM_TEXT);
        
        $mform->addElement('text', 'fax', get_string('fax', 'mod_apsechs'));
        $mform->setDefault('fax', $dbConnectivity->getMetaData()["angesteller"]["fax"]);
        $mform->setType('fax', PARAM_TEXT);
        
        
        
        // 2. Angaben zum Unternehmen
        $mform->addElement('header', 'angabenZumUnternehmen', get_string('subtitle2', 'mod_apsechs'));
        $mform->closeHeaderBefore('angabenZumUnternehmen');
        
        $mform->addElement('text', 'name', get_string('name', 'mod_apsechs'));
        $mform->setDefault('name', $dbConnectivity->getMetaData()["unternehmen"]["name"]);
        $mform->setType('name', PARAM_TEXT);
        
        $mform->addElement('text', 'branche', get_string('branche', 'mod_apsechs'));
        $mform->setDefault('branche', $dbConnectivity->getMetaData()["unternehmen"]["branche"]);
        $mform->setType('branche', PARAM_TEXT);
        
        $mform->addElement('text', 'mitgliedKammer', get_string('mitgliedKammer', 'mod_apsechs'));
        $mform->setDefault('mitgliedKammer', $dbConnectivity->getMetaData()["unternehmen"]["mitgliedKammer"]);
        $mform->setType('mitgliedKammer', PARAM_TEXT);
        
        $mform->addElement('text', 'in', get_string('in', 'mod_apsechs'));
        $mform->setDefault('in', $dbConnectivity->getMetaData()["unternehmen"]["in"]);
        $mform->setType('in', PARAM_TEXT);
        
        $mform->addElement('text', 'stadt', get_string('stadt', 'mod_apsechs'));
        $mform->setDefault('stadt', $dbConnectivity->getMetaData()["unternehmen"]["stadt"]);
        $mform->setType('stadt', PARAM_TEXT);
        
        $mform->addElement('text', 'postleitzahl', get_string('postleitzahl', 'mod_apsechs'));
        $mform->setDefault('postleitzahl', $dbConnectivity->getMetaData()["unternehmen"]["postleitzahl"]);
        $mform->setType('postleitzahl', PARAM_TEXT);
        
        $mform->addElement('text', 'anzahlMitarbeiter', get_string('anzahlMitarbeiter', 'mod_apsechs'));
        $mform->setDefault('anzahlMitarbeiter', $dbConnectivity->getMetaData()["unternehmen"]["anzahlMitarbeiter"]);
        $mform->setType('anzahlMitarbeiter', PARAM_TEXT);
        
        $mform->addElement('text', 'anzahlKaufmAusbildenden', get_string('anzahlKaufmAusb', 'mod_apsechs'));
        $mform->setDefault('anzahlKaufmAusbildenden', $dbConnectivity->getMetaData()["unternehmen"]["anzahlKaufmAusbildenden"]);
        $mform->setType('anzahlKaufmAusbildenden', PARAM_TEXT);
        
        $mform->addElement('text', 'strasse', get_string('strasse', 'mod_apsechs'));
        $mform->setDefault('strasse', $dbConnectivity->getMetaData()["unternehmen"]["strasse"]);
        $mform->setType('strasse', PARAM_TEXT);
        
        $mform->addElement('text', 'nummer', get_string('nummer', 'mod_apsechs'));
        $mform->setDefault('nummer', $dbConnectivity->getMetaData()["unternehmen"]["nummer"]);
        $mform->setType('nummer', PARAM_TEXT);
        
        $mform->addElement('text', 'anzahlTechnischenAusbildenden', get_string('anzahlTechnischenAusb', 'mod_apsechs'));
        $mform->setDefault('anzahlTechnischenAusbildenden', $dbConnectivity->getMetaData()["unternehmen"]["anzahlTechnischenAusbildenden"]);
        $mform->setType('anzahlTechnischenAusbildenden', PARAM_TEXT);
        
        $mform->addElement('text', 'anzahlSonstigerAusbildenden', get_string('anzahlSonstigerAusb', 'mod_apsechs'));
        $mform->setDefault('anzahlSonstigerAusbildenden', $dbConnectivity->getMetaData()["unternehmen"]["anzahlSonstigerAusbildenden"]);
        $mform->setType('anzahlSonstigerAusbildenden', PARAM_TEXT);
        
        
        
        // 3. Angaben zur Ausbildung
        // TODO: set defaults
        $mform->addElement('header', 'angabenZurAusbildung', get_string('subtitle3', 'mod_apsechs'));
        $mform->closeHeaderBefore('angabenZurAusbildung');
        
        $mform->addElement('text', 'verguetung', get_string('verguetung', 'mod_apsechs'));
        $mform->setDefault('verguetung', $dbConnectivity->getMetaData()["ausbildung"]["verguetung"]);
        $mform->setType('verguetung', PARAM_TEXT);
        
        // radio buttons for inhalte des a.bildungplanes
        $inhalte=array();
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internVollVermittelt', 'mod_apsechs'), 0);
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internTeilVermittelt', 'mod_apsechs'), 1);
        $mform->addGroup($inhalte, 'inhalteGroup', get_string('ausbildungsplanInhalte', 'mod_apsechs'), array(' '), false);
        
        // Download option
        $downloadOption = array();
        $downloadOption[] =& $mform->createElement('static', 'lblForDownload', get_string('ausbildungsplanStud', 'mod_apsechs'));
        $downloadOption[] =& $mform->createElement('button', 'downloadBtn', get_string('download', 'mod_apsechs'));
        $mform->addGroup($downloadOption, 'downloadGroup', '', array(' '), false);
        
        
        // 4. Angaben zur Ausbildung
        $mform->addElement('header', 'antragsbearbeitung', '4. Antragsbearbeitung');
        $mform->closeHeaderBefore('antragsbearbeitung');
        
        // radio buttons for inhalte des a.bildungplanes
        $inhalte=array();
        $inhalte[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme1', 'mod_apsechs'), 0);
        $inhalte[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme2', 'mod_apsechs'), 1);
        $inhalte[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme3', 'mod_apsechs'), 2);
        $mform->addGroup($inhalte, 'aufnahmeRadio', get_string('aufnahmeText', 'mod_apsechs'), array(' '), false);
        
        $mform->addElement('select', 'zulassung', get_string('zulassungStudiengang', 'mod_apsechs'),
                           ["nicht zutreffend"],
                           [0]);
        
        
        
        // Zulassungsprozess
        $mform->addElement('header', 'zulassungsprozess', get_string('subtitleFinal', 'mod_apsechs'));
        $mform->closeHeaderBefore('zulassungsprozess');
        
        $process=array();
        $currentStep = $dbConnectivity->getCurrentStepInApproval();
        for ($i = 1; $i <=4; $i++) {
            if ($i <= $currentStep) {
                $process[] = $mform->createElement('static', 'prozess' . $i, get_string('zulassung' . $i, 'mod_apsechs'));
            } else {
                $process[] = $mform->createElement('static', 'prozess' . $i, get_string('zulassung' . $i, 'mod_apsechs'));
            }
            if ($i < 4) {
                $process[] = $mform->createElement('static', 'prozessDiv' . $i, ' > ');
            }
        }
        $mform->addGroup($currentStep, 'proz', '', array(' '), false);
        
        $mform->addElement('checkbox', 'besichtigt',  get_string('besichtigt', 'mod_apsechs'));
        
        $mform->addElement('date_selector', 'datumUNehmenBes', get_string('datumUNBes', 'mod_apsechs'));

        
        // error_log("TEST FROM INSIDE FORM");
        
        $mainButons=array();
        $mainButons[] =& $mform->createElement('submit', 'genehmigen', get_string('genehmigen', 'mod_apsechs'));
        $mainButons[] =& $mform->createElement('submit', 'ablehen', get_string('ablehen', 'mod_apsechs'));
        $mainButons[] =& $mform->createElement('submit', 'drucken', get_string('drucken', 'mod_apsechs'));
        $mform->addGroup($mainButons, 'mainBtns', '', array(' '), false);
        
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
        
        $mform->closeHeaderBefore('mainBtns');
        // error_log("TEST FROM AFTER SUBMIT IN FORM");
        
    }
    
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}