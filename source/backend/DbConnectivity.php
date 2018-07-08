<?php

/**
 * Class to communicate with the backend, and to retrieve
 * the necessary data from the database tables.
 * The class also provides both read, write and delete possibilities.
 * @author Nandor Babina
 */
class DbConnectivity {
    function getMetaData($anfrage_id) {
        return [
            "general" => [
                "requestDate" => "15.08.2018",
                "currentStatus" => 0,
                "studiengang" => -1,
                "responsible" => 1
                
            ],
            "angesteller" => [
                "vorname" => "Anke",
                "nachname" => "Berndt",
                "email" => "anke.berndt@schnippschnapp.de",
                "tel" => "0123 567890",
                "fax" => "0123 456789"
            ],
            "unternehmen" => [
                "name" => "SchnippSchnapp GmbH",
                "branche" => "Industrie und Wirtschaft",
                "mitgliedKammer" => "...",
                "in" => "...",
                "stadt" => "Bremen",
                "postleitzahl" => 28195,
                "anzahlMitarbeiter" => 235,
                "anzahlKaufmAusbildenden" => 1,
                "strasse" => "SchnippSchnappStraße",
                "nummer" => "24-27",
                "anzahlTechnischenAusbildenden" => 2,
                "anzahlSonstigerAusbildenden" => 0
            ],
            "ausbildung" => [
                "verguetung" => "900 €",
                "inhalteDesAusbildungsplanes" => 0
            ],
        ];
    }
    
    function changeStatus($newStatus) {
        /** $newStatus comes in the following structure:
         *  [
         *      "genehmigt" =>  1, // 1 = approved, 0 = declined.
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
         **/ 
        // TODO: save changes in the backend.
    }
    
    function getStudiengangs() {
        return [
            "id" => [1, 2, 3],
            "name" => ["Wirtschaftsinformatik", "Digital Media", "Informatik"]
        ];
    }
    
    /** Returns a list of:
     * - IDs
     * - Names
     * for possible responsibles for the specific request.
     */
    function getResponsibles($anfrage_id) {
        //TODO: replace dummy data
        $resp = [
            "user_id" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            "name" => ["John", "James", "Marie", "Jonathan", "Maxime", "Michael", "Sam", "Sarah", "Carla", "Samantha"]
        ];
        
        array_unshift($resp["user_id"], -1);
        array_unshift($resp["name"], "nicht zugewiesen");
        
        return $resp;
    }
    
}