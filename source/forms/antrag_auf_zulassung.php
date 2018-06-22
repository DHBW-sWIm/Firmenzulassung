<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
 
class simplehtml_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
 
        $mform = $this->_form; // Don't forget the underscore! 
 
        // Verantwortlicher
        $mform->addElement('select', 'responsible', 'Verantwortlicher',
                           $this->getResponsibles()['name'],
                           $this->getResponsibles()['user_id']);
        
        $mform->setDefault('responsible', $this->getCurrentResponsible);
        
        // Status
        $mform->addElement('static', 'status', 'Status', $this->getStatus());
        
        // Antragsdatum
        $mform->addElement('static', 'requestDate', 'Antragsdatum', $this->getRequestDate());
        
        // Studiengang
        $mform->addElement('select', 'studiengang', 'Studiengang',
                          $this->getResponsibles()['name'],
                          $this->getResponsibles()['id']);
        
        // 1. Angaben zum Unternehmen
        
        
        
        
		$mform->addElement('text', 'name', get_string('name'));
		$mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'Bitte Namen eingeben');

        // error_log("TEST FROM INSIDE FORM");
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Absenden und Prozess starten');

        // error_log("TEST FROM AFTER SUBMIT IN FORM");

    }
    
    // If set, then returns the responsible person's ID, otherwise null
    function getCurrentResponsible() {
        // TOOD: replace dummy data
        return null;
    }
    
    /* Returns a list of:
        - IDs
        - Names
        for possible responsibles for the specific request.
     */
    function getResponsibles() {
        //TODO: replace dummy data
        $resp = [
            "user_id" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            "name" => ["John", "James", "Marie", "Jonathan", "Maxime", "Michael", "Sam", "Sarah", "Carla", "Samantha"]
        ];
        
        array_unshift($resp["user_id"], null);
        array_unshift($resp["name"], "nicht zugewiesen");
        
        return resp;
    }
    
    function getRequestDate() {
        return "15.08.2018";
    }
    
    function getCurrentStatus() {
        //TODO: replace dummy data
        return "neu";
    }
    
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}