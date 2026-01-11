#!/bin/bash

# Directories to back up
# DIR1="/home/samyakmatrimony/public_html/photos"
# DIR2="/home/samyakmatrimony/public_html/photos_big"
# BACKUP_DIR="/home/samyakmatrimony/temp/backup"
# TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")

# Google Drive remote name in rclone
# REMOTE_NAME="gdrive"
# REMOTE_FOLDER="Samyak DB Backups Daily"

# Create backup directory
# mkdir -p "$BACKUP_DIR"

# Zip the directories
# ZIP_FILE="$BACKUP_DIR/backup_$TIMESTAMP.zip"
# zip -r "$ZIP_FILE" "$DIR1" "$DIR2"

# Upload to Google Drive
# rclone copy "$ZIP_FILE" "$REMOTE_NAME:$REMOTE_FOLDER" --progress

# Remove local backup file
# rm "$ZIP_FILE"

# echo "Backup completed and uploaded to Google Drive!"


set -euo pipefail

SRC_DIRS=(
  "/home/samyakm1/public_html/photos"
  "/home/samyakm1/public_html/photos_big"
)

WORK_DIR="/home/samyakm1/temp/backup"
REMOTE="gdrive:Samyak DB Backups Daily/zips"
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
ZIP_BASE="$WORK_DIR/photos_$TIMESTAMP.zip"
LOG_FILE="/home/samyakm1/photos_backup_zip.log"

mkdir -p "$WORK_DIR"

echo "===== ZIP BACKUP START: $(date) =====" >> "$LOG_FILE"

# Create split ZIPs (1GB chunks)
zip -r -s 1g "$ZIP_BASE" "${SRC_DIRS[@]}" >> "$LOG_FILE" 2>&1

# Upload with throttle
if /usr/local/bin/rclone copy "$WORK_DIR" "$REMOTE" \
  --include "photos_$TIMESTAMP*" \
  --transfers 1 \
  --checkers 1 \
  --tpslimit 4 \
  --tpslimit-burst 4 \
  --drive-chunk-size 64M \
  --retries 10 \
  --low-level-retries 20 \
  --log-level INFO \
  >> "$LOG_FILE" 2>&1
then
  rm -f "$WORK_DIR/photos_$TIMESTAMP"* 
  echo "SUCCESS: ZIP backup uploaded" >> "$LOG_FILE"
else
  echo "ERROR: ZIP backup upload failed" >> "$LOG_FILE"
  exit 1
fi

exit 0
