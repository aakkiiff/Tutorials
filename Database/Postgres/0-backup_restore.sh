#!/bin/bash

# Set variables
DB_NAME="DB_NAME"    
DB_USER="pguser"         
DB_HOST="172.17.17.XXX" 
DB_PORT="5432"
BACKUP_DIR="."
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="$BACKUP_DIR/${DB_NAME}_backup_$TIMESTAMP.sql"

# Perform the backup
pg_dump -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER" -F c -b -v -f "$BACKUP_FILE" "$DB_NAME"

# Check if the backup was successful
if [ $? -eq 0 ]; then
    echo "Backup completed successfully. File: $BACKUP_FILE"
else
    echo "Backup failed!" >&2
    exit 1
fi


# RESTORE
# pg_restore -U pguser -d DB_NAME -h localhost -p 5433 -1 corteza_backup_backup_20241209_111406.sql