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
 * Internal library of functions for module firmenzulassung
 *
 * All the firmenzulassung specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod_firmenzulassung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/lib/autoload.php');

defined('MOODLE_INTERNAL') || die();

$processDefinitionsApiInstance = null;
$processInstancesApiInstance = null;
$tasksApiInstance = null;
$formsApiInstance = null;

function create_api_instances() {
	// Configure HTTP basic authorization: basicAuth
	$config = Swagger\Client\Configuration::getDefaultConfiguration()
		->setUsername('kermit')
		->setPassword('kermit');

	global $engineApiInstance;
	$engineApiInstance = new Swagger\Client\Api\EngineApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
		new GuzzleHttp\Client(),
		$config
	);

	global $processDefinitionsApiInstance;
	$processDefinitionsApiInstance = new Swagger\Client\Api\ProcessDefinitionsApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
		new GuzzleHttp\Client(),
		$config
	);

	global $processInstancesApiInstance;
	$processInstancesApiInstance = new Swagger\Client\Api\ProcessInstancesApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
		new GuzzleHttp\Client(),
		$config
	);

	global $tasksApiInstance;
	$tasksApiInstance = new Swagger\Client\Api\TasksApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
		new GuzzleHttp\Client(),
		$config
	);

	global $formsApiInstance;
	$formsApiInstance = new Swagger\Client\Api\FormsApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
		new GuzzleHttp\Client(),
		$config
	);
}

function firmenzulassung_do_something_useful(array $things) {
    return new stdClass();
}

function firmenzulassung_get_process_definition_id($processKey) {
	global $processDefinitionsApiInstance;

	$version = null; // int | Only return process definitions with the given version.
	$name = null; // string | Only return process definitions with the given name.
	$name_like = null; // string | Only return process definitions with a name like the given name.
	$key_like = null; // string | Only return process definitions with a name like the given key.
	$resource_name = null; // string | Only return process definitions with the given resource name.
	$resource_name_like = null; // string | Only return process definitions with a name like the given resource name.
	$category = null; // string | Only return process definitions with the given category.
	$category_like = null; // string | Only return process definitions with a category like the given name.
	$category_not_equals = null; // string | Only return process definitions which donï¿½t have the given category.
	$deployment_id = null; // string | Only return process definitions with the given category.
	$startable_by_user = null; // string | Only return process definitions which are part of a deployment with the given id.
	$latest = "true"; // bool | Only return the latest process definition versions. Can only be used together with key and keyLike parameters, using any other parameter will result in a 400-response.
	$suspended = null; // bool | If true, only returns process definitions which are suspended. If false, only active process definitions (which are not suspended) are returned.
	$sort = "version"; // string | Property to sort on, to be used together with the order.
	try {
		$result = $processDefinitionsApiInstance->getProcessDefinitions($version, $name, $name_like, $processKey, $key_like, $resource_name, $resource_name_like, $category, $category_like, $category_not_equals, $deployment_id, $startable_by_user, $latest, $suspended, $sort);
        $process_definition_id = "meisterkey:1:10870"; //fix gesetzt, sollte bei Activit-Integration dynamisch aufgebaut werden
		return $process_definition_id;
	} catch (Exception $e) {
		echo 'Exception when calling ProcessDefinitionsApi->getProcessDefinitions: ', 	$e->getMessage(), PHP_EOL;
		return null;
	}
}

function firmenzulassung_start_process($process_definition_id, $business_key) {
	global $processInstancesApiInstance;

	$requestArray = array(
		'process_definition_id' => $process_definition_id,
		'business_key' => $business_key
	);
	$body = new \Swagger\Client\Model\ProcessInstanceCreateRequest($requestArray); // \Swagger\Client\Model\ProcessInstanceCreateRequest |

	// attempt to create instance for process
	try {
		$result = $processInstancesApiInstance->createProcessInstance($body);
		// get instance ID
		$process_instance_id = $result->getId();
		print_r($process_instance_id);
		return $process_instance_id;

	} catch (Exception $e) {
		echo 'Exception when calling ProcessInstancesApi->createProcessInstance: ', $e->getMessage(), PHP_EOL;
		return null;
	}
}

function firmenzulassung_check_for_input_required($process_instance_id) {
	global $tasksApiInstance;
	try {
		$result = $tasksApiInstance->getTasks(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $process_instance_id, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
		// print("PRINT TASKS CONNECTED TO PROCESS INSTANCE");
		$task_id = $result['data'][0]->id;
		$task_name = $result['data'][0]->name;
		$taskDefinitionKey = $result['data'][0]->taskDefinitionKey;
		print_r($result['data'][0]);
		return $task_id;

	} catch (Exception $e) {
		// echo 'Exception when calling TasksApi->getTasks: ', $e->getMessage(), PHP_EOL;
		echo "Nope, not yet.";
		return null;
	}
}


//TODO J&C
function firmenzulassung_answer_input_required_resources($task_id, $process_definition_id,
$resName, $resDescription, $resSerNumber, $resInvNumber,$resComment,$resStatus,$resAmount,$resType,$resMainCategory,$resSubCategory) {
	global $formsApiInstance;

	$formArray = array(
		'action' => 'submit',
		'task_id' => $task_id,
		'process_definition_id' => $process_definition_id,
		'properties' => array(
			array(
				'id' => 'name',
				'value' => $resName
			),
			array(
				'id' => 'description',
				'value' => $resDescription
			),
			array(
				'id' => 'serialnumber',
				'value' => $resSerNumber
			),
			array(
				'id' => 'inventorynumber',
				'value' => $resInvNumber
			),
			array(
				'id' => 'comment',
				'value' => $resComment
			),
			array(
				'id' => 'status',
				'value' => $resStatus
			),
			array(
				'id' => 'amount',
				'value' => $resAmount
			),
			array(
				'id' => 'type',
				'value' => $resType
			),
			array(
				'id' => 'maincategory',
				'value' => $resMainCategory
			),
			array(
				'id' => 'subcategory',
				'value' => $resSubCategory
			)
		)
	);

	$body = new \Swagger\Client\Model\SubmitFormRequest($formArray); // \Swagger\Client\Model\SubmitFormRequest |

	try {
		$result = $formsApiInstance->submitForm($body);
		//print_r($result);
		return $result;
	} catch (Exception $e) {
		echo 'Exception when calling FormsApi->submitForm: ', $e->getMessage(), PHP_EOL;
		return null;
	}
}

function firmenzulassung_answer_input_required($task_id, $process_definition_id, $value1, $value2) {
	global $formsApiInstance;

	$formArray = array(
		action => "submit",
		task_id => $task_id,
		process_definition_id => $process_definition_id,
		properties => array(
			array(
				id => new_property_1,
				value => $value1
			),
			array(
				id => new_property_2,
				value => $value2
			)
		)
	);

	$body = new \Swagger\Client\Model\SubmitFormRequest($formArray); // \Swagger\Client\Model\SubmitFormRequest |

	try {
		$result = $formsApiInstance->submitForm($body);
		print_r($result);
		return $result;
	} catch (Exception $e) {
		echo 'Exception when calling FormsApi->submitForm: ', $e->getMessage(), PHP_EOL;
		return null;
	}
}

function firmenzulassung_get_process_instance_status($process_instance_id) {
	global $processInstancesApiInstance;

	try {
		$result = $processInstancesApiInstance->getProcessInstance($process_instance_id);
		print("PRINT INFO ABOUT PROCESS INSTANCE");
		print_r($result);
		return $result;

	} catch (Exception $e) {
		echo 'Exception when calling ProcessInstancesApi->getProcessInstance: ', $e->getMessage(), PHP_EOL;
		return null;
	}
}

require_once($CFG->dirroot.'/lib/moodlelib.php');
require_once($CFG->dirroot.'/config.php');

function mail_to($email, $name, $subject, $message) {

	global $DB;

	$from = new stdClass();
	$from->firstname = 'sWIm15';
	$from->lastname  = '';
	$from->firstnamephonetic = '';
  $from->lastnamephonetic = '';
  $from->middlename = '';
  $from->alternatename = '';
	$from->email     = 'swim15.noreply@gmail.com';
	$from->maildisplay = true;
  $from->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML emails.
	
	$emailsubject = $subject;
	$emailmessage = $message;
	
	$user = $DB->get_record('user', ['email' => $email]);

	if (!isset($user) or empty($user->email)) {
		$user = generate_dummy_user($email, $name);
	}

	try {
        $success = email_to_user($user, $from, $emailsubject, $emailmessage);
    } catch (Exception $e) {
	    // ignore this one. it works!
    }
	return $success;
}

function generate_dummy_user($email, $name = '', $id = -99) {
	$emailuser = new stdClass();
	$emailuser->email = trim(filter_var($email, FILTER_SANITIZE_EMAIL));
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailuser->email = '';
		}
	$name = format_text($name, FORMAT_HTML, array('trusted' => false, 'noclean' => false));
	$emailuser->firstname = trim(filter_var($name, FILTER_SANITIZE_STRING));
	$emailuser->lastname = '';
	$emailuser->maildisplay = true;
	$emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML emails.
	$emailuser->id = $id;
	$emailuser->firstnamephonetic = '';
	$emailuser->lastnamephonetic = '';
	$emailuser->middlename = '';
	$emailuser->alternatename = '';

	return $emailuser;
}


/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @param $isApproved bool
 * @param $reason string
 * @throws Exception
 */
function processApplication($applicationID, $isApproved, $reason) {

    $dbConnectivity = new DbConnectivity();
    $applicationStatus = $dbConnectivity->getCurrentStatus($applicationID);

    if ( $applicationStatus == null ) {
        throw new Exception('The application ID '.$applicationID.' does not exist!');
    }

    // processing the application depending on current status
    switch ( $applicationStatus ) {
        case 0:
            processApplicationByStudiengangsleiter($applicationID, $isApproved, $reason);
            break;
        case 1:
            processApplicationByDekan($applicationID, $isApproved, $reason);
            break;
        case 2:
            processApplicationByHochschulrat($applicationID, $isApproved, $reason);
            break;
        case 3:
            throw new Exception('The application has been already approved by all instances!');
            break;
        case -3:
        case -2:
        case -1:
            throw new Exception('The application has been already rejected!');
        default:
            throw new OutOfRangeException('The applicationStatus \''.$applicationStatus.'\' is not defined!');
            break;
    }
}


//TODO: outsource strings to lang/en/firmenzulassung.php and access with getString('...');
/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @param $isApproved bool
 * @param $reason string
 * @throws Exception
 */
function processApplicationByStudiengangsleiter($applicationID, $isApproved, $reason) {

    global $USER;
    global $DB;
    $dbConnectivity = new DbConnectivity();

    $currentUserID = &$USER->id;

    // throw exception if user is not responsible
    if (!isResponsibleStudiengangsleiter($currentUserID, $applicationID)) {
        throw new Exception("You are not allowed to perform this task!");
    }

    // continue as Dekan to avoid performing same action twice for the user
    if (isAuthorizedDekan($currentUserID)) {
        // continue as Dekan if current Studiengangsleiter is Dekan
        processApplicationByDekan($applicationID, $isApproved, $reason);
        return;
    }

    try {

        if ($isApproved == true) {

            // Update status in database with 1 (approvedByStudiengangsleiter)
            $dbConnectivity->insertApplicationHistoryEntry($applicationID, 1, $reason);

            // Email to next process instance (Dekan)
            $email = getAuthorizedDekan($applicationID);
            $name = $DB->get_field('firmenzulassung_antraege', 'company', array('id' => $applicationID), MUST_EXIST);
            $subject = 'neuer Antrag auf Zulassung zur Bearbeitung';
            $message = 'Ein Antrag auf Zulassung wurde durch ' . fullname($USER) . ' genehmigt.
                    \n\nBitte fahren Sie mit der Bearbeitung des Antrags fort.';

            mail_to($email, $name, $subject, $message);

        } else {
            // Update status in database with -1 (rejectedByStudiengangsleiter)
            $dbConnectivity->insertApplicationHistoryEntry($applicationID, -1, $reason);

            // Email to companyRepresentative
            emailRejectionToCompanyRepresentive($applicationID, $reason);

        }

    } catch (Exception $e) {
        echo $e->getTraceAsString();
        throw $e;
    }

}

/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @param $isApproved bool
 * @param $reason string
 * @throws Exception
 */
function processApplicationByDekan($applicationID, $isApproved, $reason)
{

    global $USER;
    global $DB;
    $dbConnectivity = new DbConnectivity();

    $currentUserID = &$USER->id;

    if (!isAuthorizedDekan($currentUserID)) {
        throw new Exception("You are not allowed to perform this task!");
    }

    try {

        if ($isApproved == true) {
            // Update status in database
            $dbConnectivity->insertApplicationHistoryEntry($applicationID, 2, $reason);

            // Send mail/notification to next responsible user if update was successful
            // Email to next process instance (Hochschulrat)
            $email = getAuthorizedHochschulrat($applicationID);
            $name = $DB->get_field('firmenzulassung_antraege', 'company', array('id' => $applicationID), MUST_EXIST);
            $subject = 'neuer Antrag auf Zulassung zur Bearbeitung';
            $message = 'Ein Antrag auf Zulassung wurde durch '.fullname($USER).' genehmigt.
                    \n\nBitte fahren Sie mit der Bearbeitung des Antrags fort.';

            mail_to($email, $name, $subject, $message);

        } else {

            // Update status in database
            $dbConnectivity->insertApplicationHistoryEntry($applicationID, -2, $reason);

            if (isResponsibleStudiengangsleiter($currentUserID, $applicationID)) {
                // Email to companyRepresentative
                emailRejectionToCompanyRepresentive($applicationID, $reason);

            } else {
                // Email to Studiengangsleiter
                sendEmailToResponsibleStudiengangsleiter($applicationID, -2);
            }
        }

    } catch (Exception $e) {
        echo $e->getTraceAsString();
        throw $e;
    }
}

/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @param $isApproved bool
 * @param $reason string
 * @throws Exception
 */
function processApplicationByHochschulrat($applicationID, $isApproved, $reason) {

    global $USER;
    $dbConnectivity = new DbConnectivity();
    $currentUserID = &$USER->id;

    if (!isAuthorizedDekan($currentUserID)) {
        throw new Exception("You are not allowed to perform this task!");
    }

    try {
        if ($isApproved == true)
            $status = 3;
        else
            $status = -3;

        // Update status in database
        $dbConnectivity->insertApplicationHistoryEntry($applicationID, $status, $reason);

        // Send mail/notification to next responsible user if update was successful
        // Email to Studiengangsleiter
        sendEmailToResponsibleStudiengangsleiter($applicationID, $status);

    } catch (Exception $e) {
        echo $e->getTraceAsString();
        throw $e;
    }
}

/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @param $status int
 * @return bool
 */
function sendEmailToResponsibleStudiengangsleiter($applicationID, $status) {
    global $USER;

    $responsibleStudiengangsleiter = getResponsibleStudiengangsleiter($applicationID);

    switch ($status) {
        case -2:
            $subject = 'Antrag auf Zulassung vom Dekanat abgelehnt';
            $message = 'Der Antrag auf Zulassung wurde durch '.fullname($USER).' abgelehnt.
                    \n\nBitte informieren Sie den Antragsteller.';
            $messageHTML = '';
            break;
        case 2:
            $subject = 'Antrag auf Zulassung vom Dekanat genehmigt';
            $message = 'Der Antrag auf Zulassung wurde durch '.fullname($USER).' genehmigt.
                    \n\nDie Bearbeitung wird in nächster Instanz beim Hochschulrat fortgesetzt.';
            $messageHTML = '';
            break;
        case -3:
            $subject = 'Antrag auf Zulassung vom Hochschulrat abgelehnt';
            $message = 'Der Antrag auf Zulassung wurde durch '.fullname($USER).' abgelehnt.
                    \n\nBitte informieren Sie den Antragsteller.';
            $messageHTML = '';
            break;
        case 3:
            $subject = 'Antrag auf Zulassung vom Hochschulrat genehmigt';
            $message = 'Der Antrag auf Zulassung wurde durch '.fullname($USER).' genehmigt.
                    \n\n
                    \n\nBitte informieren Sie den Antragsteller über die erfolgreiche Zulassung des Unternehmens!';
            $messageHTML = '';
            break;
        default:
            return false;
    }

    return email_to_user($responsibleStudiengangsleiter, $USER, $subject, $message, $messageHTML, ",", false);

}

/**
 * by Simon Wohlfahrt
 * @param $applicationID
 * @param $reason
 */
function emailRejectionToCompanyRepresentive($applicationID, $reason) {
    global $DB;
    global $USER;

    $email = $DB->get_field('firmenzulassung_antraege', 'email', array('id' => $applicationID), MUST_EXIST);
    $name = $DB->get_field('firmenzulassung_antraege', 'company', array('id' => $applicationID), MUST_EXIST);
    $subject = 'Ihr Antrag wurde leider abgelehnt';
    $message = 'Sehr geehrte Damen und Herren von ' . $name . ',
                    \nwir haben Ihren Antrag auf Zulassung an der DHBW mit folgender Begründung abgelehnt:
                    \n\"' . $reason . '\"
                    \n\nmit freundlichen Grüßen,
                    \n' . fullname($USER) . '';

    mail_to($email, $name, $subject, $message);
}

/**
 * by Simon Wohlfahrt
 * @param $userID int
 * @param $applicationID int
 * @return bool
 */
function isResponsibleStudiengangsleiter($userID, $applicationID) {
    global $DB;

    try {
        //echo 'MARKER: [INFO] $USER->id = '.$userID.'.';
        $responsibleID = $DB->get_field('firmenzulassung_antraege', 'responsible', array('id'=>$applicationID), MUST_EXIST);
        return $responsibleID == $userID;
    } catch (Exception $e) {
        echo $e->getMessage().' at line '.$e->getLine();
        echo $e->getTraceAsString();
        return false;
    }
}

/**
 * by Simon Wohlfahrt
 * @param $applicationID int
 * @return mixed
 */
function getResponsibleStudiengangsleiter($applicationID) {
    global $DB;

    $responsibleStudiengangsleiterID =  $DB->get_field('firmenzulassung_antraege', 'responsible', array('id'=>$applicationID), MUST_EXIST);
    return $DB->get_record('user', array('id' => $responsibleStudiengangsleiterID));
}

/**
 * by Simon Wohlfahrt
 * @param $userID int
 * @return bool
 */
function isAuthorizedDekan($userID) {
    //TODO: Database selection with real dekan data
    $dekans = array(0000000001, 0000000002, 0000000003);
    return in_array ( $userID , $dekans );
}

/**
 * by Simon Wohlfahrt
 * @param $antrags_id int
 * @return string
 */
function getAuthorizedDekan($applicationID) {
    //TODO: Currently no good solution for that!

    getResponsibleStudiengangsleiter($applicationID);
    // use this user to get its supervisor or supervising group (the Dekan)

    //This is not the valid E-Mail Adress!!!
    return 'dekan01@trash-mail.com';
}

/**
 * by Simon Wohlfahrt
 * @param $userID int
 * @return bool
 */
function isAuthorizedHochschulrat($userID) {
    //TODO: Database selection with real responsibles data
    $hochschulrat = array(0000000001, 0000000002, 0000000003);
    return in_array ( $userID , $hochschulrat );
}

/**
 * by Simon Wohlfahrt
 * @param $antrags_id int
 * @return string
 */
function getAuthorizedHochschulrat($applicationID) {
    //TODO: Currently no good solution for that!

    getAuthorizedDekan($applicationID);
    // use this user to get its supervisor or supervising group (the Hochschulrat)

    //This is not the valid E-Mail Adress!!!
    return 'hochschulrat@trash-mail.com';
}

/**
 * original from Quynh Nguyen edited by Simon Wohlfahrt
 * @return stdClass
 */
function getSwimUser() {
    $from = new stdClass();
    $from->firstname = 'sWIm15';
    $from->lastname  = '';
    $from->email     = 'swim15.noreply@gmail.com';
    $from->maildisplay = 1;

    return $from;
}