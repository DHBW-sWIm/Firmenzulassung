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
 * Group observers.
 *
 * @package    mod_apsechs
 * @copyright  2018 Wiktoria Staszak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_apsechs;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/mod/assign/locallib.php');
/**
 * Group observers class.
 *
 * @package    mod_apsechs
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class group_observers {
    /**
     * An account was enrolled in dual partner course.
     *
     * @param \core\event\base $event The event.
     * @return void
     */


    /**this function is triggered by the event USER_ENROLMENT_CREATED
    * and sends out a message regarding the process of estimating the no. of students
    * to the dual partner who has just beeen enrolled 
    * or the user who enrolled the new member to the Arbeitskreis WI course
    * depending on whether the process is currently running or not
    */
    public static function dual_partner_added($event) {
        global $DB;
        $start = 11; // The Bedarfsmeldung Process starts in November
        $end = 3; // The Badarfsmeldung Process ends in March (?)


        
        $course = $DB->get_record('course', array('id' => $event->courseid)); 
        if($course->shortname != "arbeitskreiswi") return; // the function should only be executed for the enrollment to the ARBEITSKREIS WI course
        
        $supportUser = $DB->get_record('user', array('username' => 'supportuser')); //the message is sent from a bot user "Support User"


        //message creation
        $message = new \core\message\message();
        $message->component = 'moodle';
        $message->name = 'instantmessage';
        $message->userfrom = $supportUser;   
        // $message->userto = $event->relateduserid; //Dual Partner 
        $message->subject = 'Bedarfsmeldeprozess';
        $message->fullmessageformat = FORMAT_MARKDOWN;
        $message->fullmessagehtml = '<p>message body</p>';
        $message->notification = '0';
        $message->contexturl = '';
        $message->contexturlname = 'Context name';
        $message->replyto = "";
        $content = array('*' => array('header' => ' test ', 'footer' => ' test ')); // Extra content for specific processor
        $message->set_additional_content('email', $content);
        $message->courseid = $course->id; // This is required in recent versions, use it from 3.2 on https://tracker.moodle.org/browse/MDL-47162




        if(date("n") < $start && date("n") > $end ){
            //outside the process
            // if there is currently no Bedarfsmeldung process running (April-October), 
            // the message should be sent to the newly enrolled user, 
            // letting them know that they will be added to the next process
            $message->userto = $event->relateduserid; //Newly enrolled user -> Dual Partner 
            $message->fullmessage = 'No Bedarfsmeldung Process is running at the moment, but you will be added to the next one.';
            $message->smallmessage = 'No Bedarfsmeldung Process is running at the moment, but you will be added to the next one.';
        }else{
            //inside the process
            // if there is a Bedarfsmeldung process running (November-March), 
            // the message should be sent to the Studiengangsleiter, 
            // letting them know that they should inform the newly enrolled dual partner how the process works
            $message->userto = $event->userid; //The user who has enrolled the user -> Studiengangsleiter
            $message->fullmessage = 'The Bedarfsmeldung Process is currently running. Please inform the new Dual Partner about the process.';
            $message->smallmessage = 'The Bedarfsmeldung Process is currently running. Please inform the new Dual Partner about the process.';
        }               
        $messageid = message_send($message);
    }
}