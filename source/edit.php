<?php
/*LOGIN*/
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

/*PAGE SETZEN*/
$PAGE->set_url('/mod/firmenzulassung/edit.php', array('id' => $cm->id,'anfrageid' => $_GET['anfrageid']));
$PAGE->set_title(format_string($firmenzulassung->name));
$PAGE->set_heading(format_string($course->fullname));

/* Ab hier beginnt der Output */
echo $OUTPUT->header();
$strName = "Antrag bearbeiten";
echo $OUTPUT->heading($strName);

$url = $PAGE->url;
$strUrl = $url.'';

/* Grosse Verzweigung -> prüfe, ob erster oder zweiter Seitenaufbau*/

// erster Seitenaufbau -> Formular erstellen und mit Werten der ausgewählten Ressource vorbelegen
//// bei dem ersten Aufbau sind Kursid und Ressorucenid noch in der Moodle-Url gesetzt, hiernach prüfen
// zweiter Seitenaufbau nachdem Formular abgesendet wurde, wird die DB aktualisiert und Erfoolg ausgegeben
if(strpos($strUrl, 'anfrageid=')==true){
    //Erster Durchlauf
    $resID = $_GET['anfrageid'];
    $sql= 'SELECT * FROM {antraege} WHERE id ='.$resID.';';
    $resource = $DB->get_record_sql($sql, array($resID));
	$resMajor_request = $resource->major_request;
    $resName = $resource->surname;
    $resFirstname = $resource->firstname;
    $resCompany= $resource->company;
    $resPhone= $resource->phone;
    $resEmail = $resource->email;
	$resFax = $resource->fax;
	$resIndustry = $resource->industry;
	$resCity = $resource->city;
	$resZipcode = $resource->zipcode;
	$resStreet = $resource->street;
	$resNumber = $resource->number;
	$resCount_employees = $resource->count_employees;
	$resCount_mercantile = $resource->count_mercantile;
	$resCount_technical = $resource->count_technical;
	$resCount_other = $resource->count_other;
	$resChamber_name = $resource->chamber_name;
	$resChamber_city = $resource->chamber_city;
	$resReward = $resource->reward;
	$resImparting = $resource->imparting;
	$resStart = $resource->start;
	$resMajor_present = $resource->major_present;
	
    echo $message = "Bitte gebe die neuen Daten für die Ressource mit dem Namen ".$resName." und der ID ".$resID." ein oder kehre mit 'abbrechen' zurück";
    echo nl2br("\n");
    echo nl2br("\n");
    echo nl2br("\n");

    // Formular aufbauen und mit DB-Werten vorbelegen, hierfür in den Konstruktur übergeben
    require_once(dirname(__FILE__).'/forms/resourceform.php');
    $mform = new resourcehtml_form ( null, array('name'=>$resName, 'firstname'=>$resFirstname,'company'=>$resCompany,
    'phone'=>$resPhone,'email'=>$resEmail, 'fax'=>$resFax, 'industry'=>$resIndustry, 'city'=>$resCity, 'zipcode'=>$resZipcode,
	'street'=>$resStreet, 'number'=>$resNumber, 'count_employees'=>$resCount_employees, 'count_mercantile'=>$resCount_mercantile,
	'count_technical'=>$resCount_technical, 'count_other'=>$resCount_other, 'chamber_name'=>$resChamber_name, 'chamber_city'=>$resChamber_city,
	'reward'=>$resReward, 'imparting'=>$resImparting, 'start'=>$resStart, 'major_present'=>$resMajor_present) );
    //Formulardaten verarbeiten
    if ($fromform = $mform->get_data()) {
        error_log("TEST FROM DIRECTLY AFTER SUBMIT");
        $fm_resid = $fromform->anfrageid;
		//Angaben zum Antragssteller / Unternehmensvertreter
		$fm_major_request = $fromform->major_request;
        $fm_name = $fromform->surname;
        $fm_firstname = $fromform->firstname;
        $fm_company= $fromform->company;
        $fm_phone = $fromform->phone;
        $fm_email = $fromform->email;
		$fm_fax = $fromform->fax;
		//Angaben zum Unternehmen
		$fm_industry = $fromform->industry;
		$fm_city = $fromform->city;
		$fm_zipcode = $fromform->zipcode;
		$fm_street = $fromform->street;
		$fm_number = $fromform->number;
		$fm_count_employees = $fromform->count_employees;
		$fm_count_mercantile = $fromform->count_mercantile;
		$fm_count_technical = $fromform->count_technical;
		$fm_count_other= $fromform->count_other;
		$fm_chamber_name= $fromform->chamber_name;
		$fm_chamber_city= $fromform->chamber_city;
		//Angaben zur Ausbildung
		$fm_reward= $fromform->reward;
		$fm_imparting= $fromform->imparting;
		//Angaben zur Antrangsbearbeitung
		$fm_start= $fromform->start;
		$fm_major_present= $fromform->major_present;
		//Angaben zur Besichtigung
		
        

        /* Hier koennte man Activiti einbinden
        //Creating instance of relevant API modules
        create_api_instances();
        $process_definition_id = firmenzulassung_get_process_definition_id("meisterkey"); //key aus dem Prozessmodel
        //error_log("PROCESS DEFINITION ID IS: " . $process_definition_id);
        $process_instance_id = firmenzulassung_start_process($process_definition_id, 'businesskey');
        //error_log("PROCESS INSTANCE ID IS: " . $process_instance_id);
        sleep(3);
        $taskid = firmenzulassung_check_for_input_required($process_instance_id);
        //error_log("TASK ID IS: " . $taskid);
        if ($taskid != null) {
            //error_log("EXECUTION OF TASK RESPONSE");
        */
        //Formwerte in Variablen speichern
        $fm_resid = $fromform->anfrageid;
		$fm_major_request= $fromform->major_request;
        $fm_name = $fromform->surname;
        $fm_firstname = $fromform->firstname;
        $fm_company= $fromform->company;
        $fm_phone = $fromform->phone;
        $fm_email = $fromform->email;
		$fm_fax = $fromform->fax;
		$fm_industry = $fromform->industry;
		$fm_city = $fromform->city;
		$fm_zipcode = $fromform->zipcode;
		$fm_street = $fromform->street;
		$fm_number = $fromform->number;
		$fm_count_employees = $fromform->count_employees;
		$fm_count_mercantile = $fromform->count_mercantile;
		$fm_count_technical = $fromform->count_technical;
		$fm_count_other= $fromform->count_other;
		$fm_chamber_name= $fromform->chamber_name;
		$fm_chamber_city= $fromform->chamber_city;
		$fm_reward= $fromform->reward;
		$fm_imparting= $fromform->imparting;
		$fm_start= $fromform->start;
		$fm_major_present= $fromform->major_present;
		
       

        /*Activit*/
        //$result = firmenzulassung_answer_input_required_resources($taskid, $process_definition_id, $fm_name, $fm_description, $fm_serialnumber, $fm_inventorynumber,$fm_comment,$fm_status,$fm_amount,$fm_type,$fm_maincategory,$fm_subcategory);
        //neue anonyme Klasse aufbauen und instanziieren, Formvariablen als Eigenschaften belegen
        $record = new stdClass();
        $record->id=$fm_resid;
		$record->id=$fm_major_request;
        $record->name = $fm_name;
        $record->firstname = $fm_firstname;
        $record->company =$fm_company;
        $record->phone=$fm_phone ;
        $record->email=  $fm_email;
		$record->fax=  $fm_fax;
		$record->industry=  $fm_industry;
		$record->city=  $fm_city;
		$record->zipcode=  $fm_zipcode;
		$record->street=  $fm_street;
		$record->number=  $fm_number;
		$record->count_employees=  $fm_count_employees;
		$record->count_mercantile=  $fm_count_mercantile;
		$record->count_technical=  $fm_count_technical;
		$record->count_other=  $fm_count_other;
		$record->chamber_name=  $fm_chamber_name;
		$record->chamber_city=  $fm_chamber_city;
		$record->reward=  $fm_reward;
		$record->imparting=  $fm_imparting;
		$record->start=  $fm_start;
		$record->major_present=  $fm_major_present;
        
    } 
    else {
        // falls die Daten des Formulars nicht validiert wurden oder für die erste Anzeige des Formulars
        
        $formdata = array('id' => $id, 'anfrageid' => $resID); // Moodle braucht die Moodle-Kursid, diese war hidden-input im Formular und wird hier gesetzt
        $mform->set_data($formdata);
        //Formular anzeigen
        $mform->display();
        //error_log("TEST FROM AFTER DISPLAY");
    }
    echo $OUTPUT->single_button(new moodle_url('../firmenzulassung/view.php', array('id' => $cm->id)), 'abbrechen');

}

else{
    //zweiter Durchlauf

    require_once(dirname(__FILE__).'/forms/resourceform.php');
    $mform = new resourcehtml_form ();

    //Formulardaten verarbeiten
    if ($fromform = $mform->get_data()) {
        error_log("TEST FROM DIRECTLY AFTER SUBMIT");
        $fm_resid = $fromform->anfrageid;
		$fm_major_request = $fromform->major_request;
        $fm_name = $fromform->name;
		$fm_firstname = $fromform->firstname;
        $fm_company = $fromform->company;
        $fm_phone= $fromform->phone;
        $fm_email = $fromform->email;
		$fm_fax = $fromform->fax;
		$fm_industry = $fromform->industry;
		$fm_city = $fromform->city;
		$fm_zipcode = $fromform->zipcode;
		$fm_street = $fromform->street;
		$fm_number = $fromform->number;
		$fm_count_employees = $fromform->count_employees;
		$fm_count_mercantile = $fromform->count_mercantile;
		$fm_count_technical = $fromform->count_technical;
		$fm_count_other= $fromform->count_other;
		$fm_chamber_name= $fromform->chamber_name;
		$fm_chamber_city= $fromform->chamber_city;
		$fm_reward= $fromform->reward;
		$fm_imparting= $fromform->imparting;
		$fm_start= $fromform->start;
		$fm_major_present= $fromform->major_present;

        /* Hier koennte man Activiti einbinden
        //Creating instance of relevant API modules
        create_api_instances();
        $process_definition_id = firmenzulassung_get_process_definition_id("meisterkey"); //key aus dem Prozessmodel
        //error_log("PROCESS DEFINITION ID IS: " . $process_definition_id);
        $process_instance_id = firmenzulassung_start_process($process_definition_id, 'businesskey');
        //error_log("PROCESS INSTANCE ID IS: " . $process_instance_id);
        sleep(3);
        $taskid = firmenzulassung_check_for_input_required($process_instance_id);
        //error_log("TASK ID IS: " . $taskid);
        if ($taskid != null) {
            //error_log("EXECUTION OF TASK RESPONSE");
        */

        /*Activiti*/
        // $result = firmenzulassung_answer_input_required_resources($taskid, $process_definition_id, $fm_name, $fm_description, $fm_serialnumber, $fm_inventorynumber,$fm_comment,$fm_status,$fm_amount,$fm_type,$fm_maincategory,$fm_subcategory);
        
        $record = new stdClass();
        $record->id=$fm_resid;
		$fm_major_request = $fromform->major_request;
        $record->name = $fm_name;
        $record->firstname = $fm_firstname;
        $record->company =$fm_company;
        $record->phone=$fm_phone ;
        $record->email=  $fm_email;
		$record->fax=  $fm_fax;
		$record->industry=  $fm_industry;
		$record->city=  $fm_city;
		$record->zipcode=  $fm_zipcode;
		$record->street=  $fm_street;
		$record->number=  $fm_number;
		$record->count_employees=  $fm_count_employees;
		$record->count_mercantile=  $fm_count_mercantile;
		$record->count_technical=  $fm_count_technical;
		$record->count_other=  $fm_count_other;
		$record->chamber_name=  $fm_chamber_name;
		$record->chamber_city=  $fm_chamber_city;
		$record->reward=  $fm_reward;
		$record->imparting=  $fm_imparting;
		$record->start=  $fm_start;
		$record->major_present=  $fm_major_present;
		

        //DB-Update: Tabelle: >>resources<<, Record-Objekt, kein Bulk Update
        $DB->update_record('antraege',$record,$bulk=false); 
        echo "Der Antrag mit der ID ".$fm_resid." wurde erfolgreich aktualisiert.";
    }

    else {

    // falls die Daten des Formulars nicht validiert wurden oder für die erste Anzeige des Formulars
    $formdata = array('id' => $id); // Moodle braucht die Moodle-Kursid, diese war hidden-input im Formular und wird hier gesetzt/*, 'anfrageid' => $resID);*/
    $mform->set_data($formdata);
    //Formular anzeigen
    $mform->display();
    //error_log("TEST FROM AFTER DISPLAY");
    }
    echo nl2br("\n");
    echo $OUTPUT->single_button(new moodle_url('../firmenzulassung/view.php', array('id' => $cm->id)), 'ok');
}

echo nl2br("\n");
echo nl2br("\n");
echo $OUTPUT->footer();
?>

