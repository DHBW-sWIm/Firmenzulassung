<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once(dirname(dirname(dirname(__FILE__))).'/backend/DbConnectivity.php');

class Uebersicht extends moodleform {
    //Add elements to form
    
    public function definition() {
        global $CFG;
        
        $mform = $this->_form;
        $dbConnectivity = new DbConnectivity();
        
        if (isset($_GET['anfrageid']) && !empty($_GET['anfrageid'])) {
            $anfrage_id = $_GET['anfrageid'];
        } else if (isset($_POST['anfrageid']) && !empty($_POST['anfrageid'])) {
            $anfrage_id = $_POST['anfrageid'];
        } else {
            return;
        }
        
        if (isset($_GET['editmode']) && ($_GET['editmode'] == 1)) {
            $edit_mode = true;
        } else if (isset($_GET['changeResp']) && ($_GET['changeResp'] == 1)) {
            $change_responsible = true;
        }
                
        /**
         * Main part
         */
        
        if (isset($change_responsible) || isset($edit_mode)) {

            $mform->addElement('select', 'responsible', get_string('responsible', 'mod_firmenzulassung'),
                $dbConnectivity->getResponsibles()['name'],
                $dbConnectivity->getResponsibles()['user_id']);
        
            $mform->setDefault('responsible', $dbConnectivity->getMetaData($anfrage_id)["general"]["responsible"]);
        } else {
            $mform->addElement('static', 'responsible', get_string('responsible', 'mod_firmenzulassung'),
                               $dbConnectivity->getUserIDToName($dbConnectivity->getMetaData($anfrage_id)["general"]["responsible"]));
        }
                
        $mform->addGroup([$mform->createElement('html', '<text style="color: rgb(250, 70, 50); font-weight:  bold;">' . get_string('status' . $dbConnectivity->getMetaData($anfrage_id)["general"]["currentStatus"], 'mod_firmenzulassung') . '</text>')],
            'status', get_string('status', 'mod_firmenzulassung'), array(' '), false);
        
        $mform->addElement('static', 'requestDate', get_string('antragsdatum', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["general"]["requestDate"]);
        
        if (isset($edit_mode)) {
            $mform->addElement('select', 'studiengang', get_string('studiengang', 'mod_firmenzulassung'),
                $dbConnectivity->getStudiengangs()['name'],
                $dbConnectivity->getStudiengangs()['id']);
            $mform->setDefault('studiengang', $dbConnectivity->getMetaData($anfrage_id)["general"]["studiengang"]);
        } else {
            $mform->addElement('static', 'studiengang', get_string('studiengang', 'mod_firmenzulassung'),
                               $dbConnectivity->getStudiengangsIDToName($dbConnectivity->getMetaData($anfrage_id)["general"]["studiengang"]));
        }
        
        /**
         * 1. Angaben zum Antragsteller als Unternehmen
         */
        $mform->addElement('header', 'angabenZumAntragstellerAlsUnternehmen', get_string('subtitle1', 'mod_firmenzulassung'));
        $mform->addElement('static', 'vorname', get_string('vorname', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["vorname"]);
        $mform->addElement('static', 'nachname', get_string('nachname', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["nachname"]);
        $mform->addElement('static', 'email', get_string('email', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["email"]);
        $mform->addElement('static', 'tel', get_string('tel', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["tel"]);
        $mform->addElement('static', 'fax', get_string('fax', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["fax"]);
        
        /**
         * 2. Anhaben zum Unternehmen
         */
        $mform->addElement('header', 'angabenZumUnternehmen', get_string('subtitle2', 'mod_firmenzulassung'));
        $mform->closeHeaderBefore('angabenZumUnternehmen');
        
        $mform->addElement('html', '<table style="width: 100%">');
        $mform->addElement('html', '<tr><td colspan=2>');
        $mform->addElement('static', 'name', get_string('name', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["name"]);
        $mform->addElement('html', '</td></tr><tr><td colspan=2>');
        $mform->addElement('static', 'branche', get_string('branche', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["branche"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'mitgliedKammer', get_string('mitgliedKammer', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["mitgliedKammer"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'in', get_string('in', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["in"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'anzahlMitarbeiter', get_string('anzahlMitarbeiter', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlMitarbeiter"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'anzahlKaufmAusbildenden', get_string('anzahlKaufmAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlKaufmAusbildenden"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'anzahlTechnischenAusbildenden', get_string('anzahlTechnischenAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlTechnischenAusbildenden"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'anzahlSonstigerAusbildenden', get_string('anzahlSonstigerAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlSonstigerAusbildenden"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'stadt', get_string('stadt', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["stadt"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'postleitzahl', get_string('postleitzahl', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["postleitzahl"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'strasse', get_string('strasse', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["strasse"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'nummer', get_string('nummer', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["nummer"]);
        $mform->addElement('html', '</td></tr></table>');
        
        $mform->addElement('static', 'divBetween345', '', '');
        $mform->closeHeaderBefore('divBetween345');
        
        /**
         * 3. Angaben zur Ausbildung
         */
        $mform->addElement('html', '<table style="width: 100%"><tr><td>');
        
        $mform->addElement('header', 'angabenZurAusbildung', get_string('subtitle3', 'mod_firmenzulassung'));
        $mform->addElement('static', 'verguetung', get_string('verguetung', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["ausbildung"]["verguetung"] . " €");
        
        // DisableIf is buggy on the Moodle version used by DHBW for radio buttons. Therefore, for view-only mode, it is represented with a text.
        // TODO: set $edit_mode if edit is enabled.
        if (isset($edit_mode)) {
            $inhalte=array();
            $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('vermittelt0', 'mod_firmenzulassung'), 0);
            $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('vermittelt1', 'mod_firmenzulassung'), 1);
            $mform->addGroup($inhalte, 'inhalteGroup', get_string('ausbildungsplanInhalte', 'mod_firmenzulassung'), array(' '), false);
        } else {
            $mform->addElement('static', 'inhalte',
                get_string('ausbildungsplanInhalte', 'mod_firmenzulassung'),
                get_string('vermittelt'. $dbConnectivity->getMetaData($anfrage_id)["ausbildung"]["inhalteDesAusbildungsplanes"], 'mod_firmenzulassung'));
        }
        
        // Download option
        $mform->addGroup([$mform->createElement('html', '<button style="background: url(icons/downloadIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/>')],
            'downloadGroup', get_string('ausbildungsplanStud', 'mod_firmenzulassung'), array(' '), false);
        
        $mform->addElement('html', '</td><td>');
        
        /**
         * 4. Antragsbearbeitung
         */
        $mform->addElement('header', 'antragsbearbeitung', '4. Antragsbearbeitung');
        $mform->closeHeaderBefore('antragsbearbeitung');
        
        // Radio buttons for Inhalte des Ausbildungsplanes.
        // Alone stading radio buttons must be in group as well, otherwise gets misaligned
        // due to opt2, where a date selector is next to the option.
        
        //TODO: set $edit_mode if edit is enabled.
        if (isset($edit_mode)) {
            $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme1', 'mod_firmenzulassung'), 0)],
                'aufnahmeG1', '', array(' '), false);
            $inhaltOption2=array();
            $inhaltOption2[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme2', 'mod_firmenzulassung'), 1);
            $inhaltOption2[] = $mform->createElement('date_selector', 'inhaltOpt2DS', '');
            $mform->addGroup($inhaltOption2, 'aufnahmeG2', get_string('aufnahmeText', 'mod_firmenzulassung'), array(' '), false);
            
            $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme3', 'mod_firmenzulassung'), 0)],
                'aufnahmeG3', '', array(' '), false);
            
            $mform->addElement('select', 'zulassung', get_string('zulassungStudiengang', 'mod_firmenzulassung'),
                ["nicht zutreffend"],
                [0]);
        } else {
            // if the Zulassung is from a specific date, then concetanete with the date, otherwise use only the text.
            if ($dbConnectivity->getMetaData($anfrage_id)["antragsbearbeitung"]["aufnahme"]["typ"] == 3) {
                $mform->addElement('static', 'aufnahme',
                    get_string('aufnahmeText', 'mod_firmenzulassung'),
                    get_string('aufnahme'. $dbConnectivity->getMetaData($anfrage_id)["antragsbearbeitung"]["aufnahme"]["typ"], 'mod_firmenzulassung')) . " " . $dbConnectivity->getMetaData($anfrage_id)["antragsbearbeitung"]["aufnahme"]["datum"];
            } else {
                $mform->addElement('static', 'aufnahme',
                    get_string('aufnahmeText', 'mod_firmenzulassung'),
                    get_string('aufnahme'. $dbConnectivity->getMetaData($anfrage_id)["antragsbearbeitung"]["aufnahme"]["typ"], 'mod_firmenzulassung'));
            }
            
            $mform->addElement('static', 'zulassung', get_string('zulassungStudiengang', 'mod_firmenzulassung'), "nicht zutreffend");
            $mform->addElement('static', '', "", "");
        }
        
        
        
        $mform->addElement('html', '</td></tr></table>');
        
        /**
         * Zulassungsprozess
         */
        $mform->addElement('header', 'zulassungsprozess', get_string('subtitleFinal', 'mod_firmenzulassung'));
        $mform->closeHeaderBefore('zulassungsprozess');
        
        $currentStep = $dbConnectivity->getMetaData($anfrage_id)["general"]["currentStatus"];
        
        
        // TODO: -1, ..., -3 wann es abgelehnt ist
        $part1 = '';
        $part2 = '';
        for ($i = 0; $i <=3; $i++) {
            if ($i < $currentStep) {
                $part1 = $part1 . get_string('zulassung' . $i, 'mod_firmenzulassung') . " > ";
            } elseif ($i == $currentStep) {
                $part1 = $part1 . get_string('zulassung' . $i, 'mod_firmenzulassung');
            } else {
                $part2 = $part2 . " > " . get_string('zulassung' . $i, 'mod_firmenzulassung');
            }
        }
        
        $mform->addElement('html', '<div><text style="color: rgb(250, 70, 50); font-weight:  bold;">' . $part1 .
            '</text><text style="color: rgb(180, 175, 175); font-weight:  bold;">' . $part2 . '</text></div>');
        
        $mform->addElement('checkbox', 'besichtigt',  get_string('besichtigt', 'mod_firmenzulassung'));
        $mform->addElement('date_selector', 'datumUNehmenBes', get_string('datumUNBes', 'mod_firmenzulassung'));
        $mform->disabledIf('datumUNehmenBes', 'besichtigt');
        
        $mainButons=array();
        
        if (isset($edit_mode)) {
            $mainButons[] =& $mform->createElement('submit', 'save_edit', get_string('speichern', 'mod_firmenzulassung'));
        } elseif (isset($change_responsible)) {
            $mainButons[] =& $mform->createElement('submit', 'change_resp', get_string('speichern', 'mod_firmenzulassung'));
        } else {
            $mform->addElement('textarea', 'comment', get_string('kommentar', 'mod_firmenzulassung'), 'rows="10" cols="50"');
            
            $mainButons[] =& $mform->createElement('submit', 'genehmigen', get_string('genehmigen', 'mod_firmenzulassung'));
            $mainButons[] =& $mform->createElement('submit', 'ablehnen', get_string('ablehnen', 'mod_firmenzulassung'));

            $mform->disabledIf('genehmigen', 'besichtigt');
        }
        
        $mainButons[] =& $mform->createElement('html', '<div class="form-group fitem"><button onclick="window.print()" style="background: url(icons/printIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/></div>');
        $mform->addGroup($mainButons, 'mainBtns', '', array(' '), false);
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'anfrageid');
        $mform->setType('anfrageid', PARAM_INT);

        $mform->closeHeaderBefore('mainBtns');
        
        $mform->setExpanded('angabenZumAntragstellerAlsUnternehmen', true);
        $mform->setExpanded('angabenZumUnternehmen', true);
        $mform->setExpanded('angabenZurAusbildung', true);
        $mform->setExpanded('antragsbearbeitung', true);
        $mform->setExpanded('zulassungsprozess', true);
    }
    
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}