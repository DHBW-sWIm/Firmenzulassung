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
 * @package    mod_firmenzulassung
 * @copyright  2018 Wiktoria Staszak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_firmenzulassung;
defined('MOODLE_INTERNAL') || die();
/**
 * Group observers class.
 *
 * @package    mod_firmenzulassung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class group_observers {
    /**
     * Constant for the shortname of the course for Dual Partners (ARBEITSKREIS WI).
     *
     * @var string The course shortname.
     */
    private static $dualpartnercourse = "arbeitskreiswi";


    /**
     * An account was enrolled in dual partner course.
     *
     * @param \core\event\base $event The event.
     * @return void
     */


    /**this function is triggered by the event USER_ENROLMENT_CREATED
    * and sends out an email regarding the process of estimating the no. of students
    * to the dual partner who has just beeen enrolled 
    * or the user who enrolled the new member to the Arbeitskreis WI course
    * depending on whether the process is currently running or not
    */
    public static function dual_partner_added(\core\event\user_enrolment_created $event) {
        global $DB;        
        $emailText = '';
        $start = 11; // The Bedarfsmeldung Process starts in November
        $end = 3; // The Badarfsmeldung Process ends in March
        $supportUser = $DB->get_record('user', array('username' => 'supportuser'));
        $enrolledUser = $DB->get_record('user', array('id' => $event->relateduserid));
        $responsibleUser = $DB->get_record('user', array('id' => $event->userId));  
        $course = $DB->get_record('course', array('id' => $event->courseid)); 

        if($course->shortname != self::$dualpartnercourse) return; // the function should only be executed for the enrollment to the ARBEITSKREIS WI course           
        
        $sendTo = $supportUser; //default
        // check whether Bedarfsmeldeprozess is currently underway
        if(date("n") < $start && date("n") > $end ){
            /**
             * Bedarfsmeldeprozess NOT underway
             * if there is currently no Bedarfsmeldung process running (April-October), the message should be sent to the newly enrolled user, 
             * letting them know that they will be added to the next process and will be informed about it
             */
            $sendTo = $enrolledUser; //Newly enrolled user -> Dual Partner 
            $emailText = get_string('notifyemailnewdualpartner_partner', 'firmenzulassung', format_string(fullname($enrolledUser))); //content of email
        }else{
            /**
             *   Bedarfsmeldeprozess underway
             *   if there is a Bedarfsmeldung process running (November-March), an E-mail should be sent to the Studiengangsleiter, 
             *   letting them know that they should inform the newly enrolled dual partner how the process works
             */
            $sendTo = $responsibleUser; //The user who has enrolled the user -> Studiengangsleiter
            $data = array();
            $data['responsibleUser'] = fullname($responsibleUser);
            $data['enrolledUser'] = fullname($enrolledUser);
            $emailText = get_string('notifyemailnewdualpartner_studiengangsleiter', 'firmenzulassung', $data); //content of email
        }       
        
        //send email
        $supportuser->mailformat = 1; // Always send HTML version as well.
        $subject = 'Arbeitskreis WI: Bedarfsmeldeprozess';    
        $messagehtml = text_to_html($emailText, false, false, true);
        return email_to_user($sendTo, $supportUser, $subject, $emailText, $messagehtml);
    }
}