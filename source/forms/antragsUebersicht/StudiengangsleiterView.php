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
        
        $mform->addElement('static', 'vorname', get_string('vorname', 'mod_apsechs'), $dbConnectivity->getMetaData()["angesteller"]["vorname"]);
        $mform->addElement('static', 'nachname', get_string('nachname', 'mod_apsechs'), $dbConnectivity->getMetaData()["angesteller"]["nachname"]);        
        $mform->addElement('static', 'email', get_string('email', 'mod_apsechs'), $dbConnectivity->getMetaData()["angesteller"]["email"]);
        $mform->addElement('static', 'tel', get_string('tel', 'mod_apsechs'), $dbConnectivity->getMetaData()["angesteller"]["tel"]);
        $mform->addElement('static', 'fax', get_string('fax', 'mod_apsechs'), $dbConnectivity->getMetaData()["angesteller"]["fax"]);        
        
        // 2. Angaben zum Unternehmen
        $mform->addElement('header', 'angabenZumUnternehmen', get_string('subtitle2', 'mod_apsechs'));
        $mform->closeHeaderBefore('angabenZumUnternehmen');
        
        $mform->addElement('static', 'name', get_string('name', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["name"]);
        $mform->addElement('static', 'branche', get_string('branche', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["branche"]);        
        $mform->addElement('static', 'mitgliedKammer', get_string('mitgliedKammer', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["mitgliedKammer"]);        
        $mform->addElement('static', 'in', get_string('in', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["in"]);        
        $mform->addElement('static', 'stadt', get_string('stadt', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["stadt"]);        
        $mform->addElement('static', 'postleitzahl', get_string('postleitzahl', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["postleitzahl"]);        
        $mform->addElement('static', 'anzahlMitarbeiter', get_string('anzahlMitarbeiter', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["anzahlMitarbeiter"]);        
        $mform->addElement('static', 'anzahlKaufmAusbildenden', get_string('anzahlKaufmAusb', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["anzahlKaufmAusbildenden"]);        
        $mform->addElement('static', 'strasse', get_string('strasse', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["strasse"]);        
        $mform->addElement('static', 'nummer', get_string('nummer', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["nummer"]);        
        $mform->addElement('static', 'anzahlTechnischenAusbildenden', get_string('anzahlTechnischenAusb', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["anzahlTechnischenAusbildenden"]);        
        $mform->addElement('static', 'anzahlSonstigerAusbildenden', get_string('anzahlSonstigerAusb', 'mod_apsechs'), $dbConnectivity->getMetaData()["unternehmen"]["anzahlSonstigerAusbildenden"]);        
        
        // 3. Angaben zur Ausbildung
        $mform->addElement('header', 'angabenZurAusbildung', get_string('subtitle3', 'mod_apsechs'));
        $mform->closeHeaderBefore('angabenZurAusbildung');
        
        $mform->addElement('static', 'verguetung', get_string('verguetung', 'mod_apsechs'), $dbConnectivity->getMetaData()["ausbildung"]["verguetung"]);
        
        // radio buttons for inhalte des a.bildungplanes
        $inhalte=array();
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internVollVermittelt', 'mod_apsechs'), 0);
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internTeilVermittelt', 'mod_apsechs'), 1);
        $mform->addGroup($inhalte, 'inhalteGroup', get_string('ausbildungsplanInhalte', 'mod_apsechs'), array(' '), false);
        
        // Download option
        $downloadOption = array();
        $downloadOption[] =& $mform->createElement('html', '<span class="col-form-label d-inline-block">'. get_string('ausbildungsplanStud', 'mod_apsechs') .'</span>');
        $downloadOption[] =& $mform->createElement('html', '<button style="background: url(icons/downloadIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/>');
        $mform->addGroup($downloadOption, 'downloadGroup', '', array(' '), false);        
        
        // 4. Angaben zur Ausbildung
        $mform->addElement('header', 'antragsbearbeitung', '4. Antragsbearbeitung');
        $mform->closeHeaderBefore('antragsbearbeitung');
        
        // radio buttons for inhalte des a.bildungplanes
        $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme1', 'mod_apsechs'), 0)],
                        'aufnahmeG1', '', array(' '), false);
        
        // fehlt noch: date selector:
        $inhaltOption2=array();
        $inhaltOption2[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme2', 'mod_apsechs'), 1);
        $inhaltOption2[] = $mform->createElement('date_selector', 'inhaltOpt2DS', '');
        $mform->addGroup($inhaltOption2, 'aufnahmeG2', get_string('aufnahmeText', 'mod_apsechs'), array(' '), false);
        
        $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme3', 'mod_apsechs'), 0)],
                         'aufnahmeG3', '', array(' '), false);
        
        $mform->addElement('select', 'zulassung', get_string('zulassungStudiengang', 'mod_apsechs'),
                           ["nicht zutreffend"],
                           [0]);
        
        $mform->disabledIf('zulassung', 1, 'eq', 0);
        
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
        $mform->addGroup($process, 'proz', '', array(' '), false);
        
        $mform->addElement('checkbox', 'besichtigt',  get_string('besichtigt', 'mod_apsechs'));
        $mform->addElement('date_selector', 'datumUNehmenBes', get_string('datumUNBes', 'mod_apsechs'));

        
        // error_log("TEST FROM INSIDE FORM");
        
        $mainButons=array();
        $mainButons[] =& $mform->createElement('submit', 'genehmigen', get_string('genehmigen', 'mod_apsechs'));
        $mainButons[] =& $mform->createElement('submit', 'ablehen', get_string('ablehen', 'mod_apsechs'));
        $mainButons[] =& $mform->createElement('html', '<div class="form-group fitem"><button onclick="window.print()" style="background: url(icons/printIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/></div>');
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