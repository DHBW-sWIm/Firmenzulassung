    <?php
	if ($oldversion < 2018070700) {

        // Define table firmenzulassung to be created.
        $table = new xmldb_table('firmenzulassung');

        // Adding fields to table firmenzulassung.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('intro', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('grade', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '100');

        // Adding keys to table firmenzulassung.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table firmenzulassung.
        $table->add_index('course', XMLDB_INDEX_NOTUNIQUE, array('course'));

        // Conditionally launch create table for firmenzulassung.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
		
		 // Define table antraege to be created.
        $table = new xmldb_table('antraege');

        // Adding fields to table antraege.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '30', null, null, null, null);
        $table->add_field('surname', XMLDB_TYPE_CHAR, '30', null, null, null, null);
        $table->add_field('company', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_INTEGER, '15', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '30', null, null, null, null);
        $table->add_field('major_request', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('fax', XMLDB_TYPE_INTEGER, '15', null, null, null, null);
        $table->add_field('industry', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('city', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('zipcode', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('street', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('number', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('count_employees', XMLDB_TYPE_INTEGER, '7', null, null, null, null);
        $table->add_field('count_mercantile', XMLDB_TYPE_INTEGER, '3', null, null, null, null);
        $table->add_field('count_technical', XMLDB_TYPE_INTEGER, '3', null, null, null, null);
        $table->add_field('count_other', XMLDB_TYPE_INTEGER, '3', null, null, null, null);
        $table->add_field('chamber_name', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('chamber_city', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('reward', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('imparting', XMLDB_TYPE_BINARY, null, null, null, null, null);
        $table->add_field('start', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('major_present', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('responsible', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('status', XMLDB_TYPE_CHAR, '30', null, null, null, null);
        $table->add_field('visit', XMLDB_TYPE_BINARY, null, null, null, null, null);
        $table->add_field('visit_date', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('app_date', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table antraege.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for antraege.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }


        // Firmenzulassung savepoint reached.
        upgrade_mod_savepoint(true, 2018070700, 'firmenzulassung');
    }
