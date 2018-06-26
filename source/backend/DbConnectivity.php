<?php

/**
 * Class to communicate with the backend, and to retrieve
 * the necessary data from the database tables.
 * The class also provides both read, write and delete possibilities.
 * @author Nandor Babina
 * 
 */
class DbConnectivity {
    function getMetaData() {
        return [
            "angesteller" => [
                "vorname" => "Anke",
                "nachname" => "Berndt",
                "email" => "anke.berndt.schnippschnapp.de",
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
    
    // If set, then returns the responsible person's ID, otherwise null
    function getCurrentResponsible() {
        // TOOD: replace dummy data
        return 1;
    }
    
    function getStudiengangs() {
        return [
            "id" => [1, 2, 3],
            "name" => ["Wirtschaftsinformatik", "Digital Media", "Informatik"]
        ];
    }
    
    /**
     * Return 1-4, depending on who's responsibility it is:
     *      1: Studiengangsleiter
     *      2: Dekan
     *      3: Rektorat
     *      4: Abschluss
     */
    function getCurrentStepInApproval() {
        return 2;
    }
    
    function getPlanInhalteSelectables() {
        return [
            "id" => [0, 1],
            "text" => ["intern voll vermittlet.", "intern nur teilweise vermittelt."]
        ];
    }
    
    function getSelectedPlanInhalte() {
        return 1;
    }
    
    function getCurrentStudiengang() {
        return -1;
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
        
        array_unshift($resp["user_id"], -1);
        array_unshift($resp["name"], "nicht zugewiesen");
        
        return $resp;
    }
    
    function getRequestDate() {
        return "15.08.2018";
    }
    
    function getCurrentStatus() {
        //TODO: replace dummy data
        return "neu";
    }
}