<?php

/**
 * Class to communicate with the backend, and to retrieve
 * the necessary data from the database tables.
 * The class also provides both read, write and delete possibilities.
 * @author Nandor Babina
 */

class DbConnectivity {


    /**
     * @param $anfrage_id
     * @return array
     */
    function getMetaData($anfrage_id) {
        global $DB;
        
        return [
            "general" => [
                "requestDate" => $DB->get_field('firmenzulassung_antraege', 'app_date', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                //"currentStatus" => $DB->get_field('firmenzulassung_antraege', 'status', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                //TODO: Testing (implemented by Simon Wohlfahrt)
                "currentStatus" => self::getCurrentStatus($anfrage_id),
                "studiengang" => $DB->get_field('firmenzulassung_antraege', 'studiengang', array('id'=>$anfrage_id), $strictness=IGNORE_MISSING),
                "responsible" => $DB->get_field('firmenzulassung_antraege', 'responsible', array('id'=>$anfrage_id), $strictness=MUST_EXIST)
            ],
            "angesteller" => [
                "vorname" => $DB->get_field('firmenzulassung_antraege', 'firstname', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "nachname" => $DB->get_field('firmenzulassung_antraege', 'surname', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "email" => $DB->get_field('firmenzulassung_antraege', 'email', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "tel" => $DB->get_field('firmenzulassung_antraege', 'phone', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "fax" => $DB->get_field('firmenzulassung_antraege', 'fax', array('id'=>$anfrage_id), $strictness=MUST_EXIST)
            ],
            "unternehmen" => [
                "name" => $DB->get_field('firmenzulassung_antraege', 'company', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "branche" => $DB->get_field('firmenzulassung_antraege', 'industry', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "mitgliedKammer" => $DB->get_field('firmenzulassung_antraege', 'chamber_name', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "in" => $DB->get_field('firmenzulassung_antraege', 'chamber_city', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "stadt" => $DB->get_field('firmenzulassung_antraege', 'city', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "postleitzahl" => $DB->get_field('firmenzulassung_antraege', 'zipcode', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "anzahlMitarbeiter" => $DB->get_field('firmenzulassung_antraege', 'count_employees', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "anzahlKaufmAusbildenden" => $DB->get_field('firmenzulassung_antraege', 'count_mercantile', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "strasse" => $DB->get_field('firmenzulassung_antraege', 'street', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "nummer" => $DB->get_field('firmenzulassung_antraege', 'number', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "anzahlTechnischenAusbildenden" => $DB->get_field('firmenzulassung_antraege', 'count_technical', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "anzahlSonstigerAusbildenden" => $DB->get_field('firmenzulassung_antraege', 'count_other', array('id'=>$anfrage_id), $strictness=MUST_EXIST)
            ],
            "ausbildung" => [
                "verguetung" => $DB->get_field('firmenzulassung_antraege', 'reward', array('id'=>$anfrage_id), $strictness=MUST_EXIST),
                "inhalteDesAusbildungsplanes" => '0'
            ],
            "antragsbearbeitung" => [
                "aufnahme" => [
                    "typ" => $DB->get_field('firmenzulassung_antraege', 'firmenliste_aufnahme', array('id'=>$anfrage_id), $strictness=IGNORE_MISSING),
                    "datum" => $DB->get_field('firmenzulassung_antraege', 'firmenliste_aufnahme_date', array('id'=>$anfrage_id), $strictness=IGNORE_MISSING)
                ],
                "zulassungBereitsBeiStudiengang" => -1,
                "is_visited" => $DB->get_field('firmenzulassung_antraege', 'is_visited', array('id'=>$anfrage_id), $strictness=MUST_EXIST)
            ]
        ];
    }


    /**
     * by Simon Wohlfahrt
     * @param $applicationID
     * @return mixed
     */
    function getApplicationEntry($applicationID) {
        global $DB;

        return $DB->get_record('firmenzulassung_antraege', array('id'=>$applicationID), $fields='*', MUST_EXIST);
    }

    function deleteApplication($applicationID) {
        global $DB;

        $DB->delete_records('firmenzulassung_antraege', array('id'=>$applicationID));
        $DB->delete_records('firmenzulassung_status', array('application_id'=>$applicationID));
    }
    
    
    /**
     * by Simon Wohlfahrt
     * @param $applicationID
     * @return string
     */
    function getHistoryAsFormattedString($applicationID) {
        global $DB;

        $records = $DB->get_records('firmenzulassung_status', array('application_id'=>$applicationID));
        //TODO: order by date

        //echo 'Generierung des Zulassungsprozessverlaufs...';
        //print_object($records);

        $string = '';
        foreach ($records As $entry) {

            if ($entry->status == 0)
                continue;

            $string = $string . '<b> Der Antrag wurde am ' . userdate($entry->date) . ' ' . get_string('status' . $entry->status, 'mod_firmenzulassung') . ' ' . $DB->get_field('user', 'username', array ('id'=>$entry->user), $strictness=IGNORE_MISSING) . '</b>';

            //TODO: format user name output, date and maybe some bold text for fancyness
            if (strlen($entry->reason) > 0) {
                $string = $string . '<b> mit folgender Begründung:</b><br />' . $entry->reason;
            } else {
                $string = $string . '<b> ohne Begründung.</b>';
            }

            $string = $string . '<br /><br />';
        }

        return nl2br($string);
    }
    
    // TODO: Legacy code, wird von Simon neu etwicklet
    function changeStatus($newStatus) {
        global $DB;
        
        // TODO: save changes in the backend.
        /** $newStatus comes in the following structure:
         *  [
         *  -> AntragsID kommt noch hinzu -> entspricht ID aus antraege (erstes Feld)
         *      "genehmigt" =>  1, // 1 = approved, 0 = declined. -> status bei Genehmigung um 1 erhöhen
         *      "generell" => [
         *          "verantwortlicher" => 5468464, // ID of the Studiengangsleiter
         *          "studiengang" => 54 // ID of the Studiengang
         *      ],
         *      "antragsbearbeitung" => [
         *          "aufnahme" => [
         *              "aufnahme" => 1,
         *              "datum" => "29.09.2018"
         *          ],
         *          "zulassung" => 0,
         *      ],
         *      "zulassungprozess" => [
         *          "besichtigung" => "20.09.2017" (or null if it hasn't happened)
         *      ]
         *  ]
         *  $jsonData = file_get_contents('cr0co.json');
         *  $array = json_decode($jsonData);
         *  $DB->update_record($table, $dataobject, $bulk=false)
         *  
         **/ 
        
//         Methode:
//         $arr = get_class_methods(get_class($obj));
//         foreach ($arr as $method) {
//             echo "\tfunction $method()\n";
//         }
//         global $$obj;
//         if (is_subclass_of($$obj, $class)) {
//             echo "Objekt $obj gehört zur Klasse ".get_class($GLOBALS[$obj]);
//             echo ", einer Subklasse von $class\n";
//         } else {
//             echo "Object $obj gehört nicht zu einer Subklasse von $class\n";
//         }

//         ODER:
//         $jsonarray = json_decode($response, true);
        
//         echo $jsonarray->results->operation->selector;  
        
        
        
//         genehmigt++;
        
//         foreach($newstatus as $item) {
//             switch ($item) {
//                 case 'verantwortlicher':
//                     $DB->update_record($table '...allumfassende table', ('verantwortlicher'=>$item), $bulk=false);
//             }            
//         }
        
    }
    
    function getStudiengangs() {     
        return [
            "id" => [-1, 1],
            "name" => ["", "Wirtschaftsinformatik"]
        ];
    }
    
    /** Returns a list of:
     * - IDs
     * - Names
     * for possible responsibles for the specific request.
     */
    // TODO: Legacy code, wird von Simon neu entwicklet
    function getResponsibles() {
        // global $DB;
        
        $resp = [
            "user_id" => ["1", "2", "3", "4", "5", "6", "7", "8"],
            "name" => ["Prof. Dr. Hans-Peter Engel", "Prof. Dr. Kai Focke", "Prof. Dr. Thomas Holey", "Prof. Dr. Frank Koslowski", "Prof. Dr.-Ing. Clemens Martin", "Prof. Dr.-Ing. habil. Dennis Pfisterer", "Prof. Dr. Julian Reichwald",  "Prof. Dr. Frank Wolff"]
        ];
        
        array_unshift($resp["user_id"], -1);
        array_unshift($resp["name"], "nicht zugewiesen");
        
        return $resp;
    }
    
    function getUserIDToName($user_id) {
        $resp = self::getResponsibles();
        return $resp["name"][array_search($user_id, $resp["user_id"])];
    }
    
    function getStudiengangsIDToName($studiengangs_id) {
        $studiengangs = self::getStudiengangs();
        return $studiengangs["name"][array_search($studiengangs_id, $studiengangs["id"])];
    }


    /**
     * by Simon Wohlfahrt
     * @param $application stdClass()
     */
    function updateApplication($application) {
        global $DB;

        if (!$DB->record_exists('firmenzulassung_antraege', array('id'=>$application->id))) {
            throw new Exception('The application with ID '.$application->id.' does not exist!');
        }

        $DB->update_record('firmenzulassung_antraege', $application, $bulk=false);
    }

    /**
     * by Simon Wohlfahrt
     * @param $applicationID
     * @return int
     */
    function getCurrentStatus($applicationID) {
        global $DB;

        // Select the latest history entry (status change) for a specific applicationID.
        $sql= 'SELECT status FROM {firmenzulassung_status} WHERE application_id = ? AND date = (SELECT MAX(date) FROM {firmenzulassung_status} WHERE application_id = ?);';

        try {
            $record = $DB->get_record_sql($sql, array($applicationID, $applicationID));

            if ($record != null)
                return $record->status;

            //TODO: add standard status entry if not exists
            // if application with id $applicationID exists
            // and no history entry is found
            // add default history entry with insertDefaultApplicationHistoryEntry($applicationID);
            if ($DB->record_exists('firmenzulassung_antraege', array('id'=>$applicationID)))
                self::insertDefaultApplicationHistoryEntry($applicationID);

            return 0;

        } catch (Exception $e) {
            echo 'MARKER: [ERROR] in function \'getCurrentStatus\' !!!';
            echo $e->getTraceAsString();
            return 0;
        }
    }

    /**
     * by Simon Wohlfahrt
     * @param $applicationID int
     * @param $status int
     * @param $reason string
     */
    function insertApplicationHistoryEntry($applicationID, $status, $reason) {
        global $USER;
        global $DB;

        $currentDateTime = new DateTime("now", core_date::get_server_timezone_object());

        $record = new stdClass();
        $record->user = $USER->id;
        $record->application_id = $applicationID;
        $record->status = $status;
        $record->reason = $reason;
        $record->date = $currentDateTime->getTimestamp();

        // Update status in database
        try {
            $DB->insert_record('firmenzulassung_status', $record, false);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            throw $e;
        }
    }

    /**
     * by Simon Wohlfahrt
     * @param $applicationID
     */
    function insertDefaultApplicationHistoryEntry($applicationID) {
        global $DB;

        $currentDateTime = new DateTime("now", core_date::get_server_timezone_object());

        $record = new stdClass();
        $record->user = 0;
        $record->application_id = $applicationID;
        $record->status = 0;
        $record->reason = null;
        $record->date = $currentDateTime->getTimestamp();

        // Update status in database
        try {
            $DB->insert_record('firmenzulassung_status', $record, false);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            throw $e;
        }
    }
}