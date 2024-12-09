#!/bin/bash
#mysql -h192.168.226.176 -P3306 -uroot -p'super$%Admin'
# Variables
DB_NAME="dbname"
USER="root"
PASSWORD="super$%Admin"
HOST="192.168.226.176"
PORT="3306"
DUMP_FILE="21novcps.sql"

# Function to get the list of all tables
get_all_tables() {
    mysql -u $USER -p$PASSWORD -h$HOST -P$PORT -Bse "SHOW TABLES FROM $DB_NAME"
}

# Function to get foreign key dependencies
get_foreign_keys() {
    mysql -u $USER -p$PASSWORD -h$HOST -P$PORT -Bse "
        SELECT TABLE_NAME, REFERENCED_TABLE_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE REFERENCED_TABLE_SCHEMA = '$DB_NAME'
          AND REFERENCED_TABLE_NAME IS NOT NULL"
}

# Build the order of tables based on foreign key dependencies
build_table_order() {
    declare -A table_references
    declare -A tables_with_foreign_keys

    while IFS=$'\t' read -r table referenced_table; do
        table_references[$referenced_table]+=" $table"
        tables_with_foreign_keys[$table]=1
    done <<< "$(get_foreign_keys)"

    ordered_tables=()
    visited_tables=()

    visit_table() {
        local table=$1
        if [[ ! " ${visited_tables[@]} " =~ " ${table} " ]]; then
            visited_tables+=($table)
            for referenced_table in ${table_references[$table]}; do
                visit_table $referenced_table
            done
            ordered_tables+=($table)
        fi
    }

    # Visit each table with foreign keys
    for table in "${!tables_with_foreign_keys[@]}"; do
        visit_table $table
    done

    # Add remaining tables
    for table in $(get_all_tables); do
        if [[ ! " ${visited_tables[@]} " =~ " ${table} " ]]; then
            ordered_tables+=($table)
        fi
    done

    echo ${ordered_tables[@]}
}

# Get the ordered list of tables
ORDERED_TABLES=$(build_table_order)

# Start the dump file
echo "SET FOREIGN_KEY_CHECKS = 0;" > $DUMP_FILE

# Dump all tables
for TABLE in $ORDERED_TABLES; do
    mysqldump -u $USER -p$PASSWORD -h$HOST -P$PORT --set-gtid-purged=OFF $DB_NAME $TABLE >> $DUMP_FILE
done

# End the dump file
echo "SET FOREIGN_KEY_CHECKS = 1;" >> $DUMP_FILE

echo "Dump file created successfully."

