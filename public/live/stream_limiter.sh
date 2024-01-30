#!/bin/bash

directory_path=$(dirname "$0") 
num_files_to_keep=10

while true; do
    num_files=$(find "$directory_path" -maxdepth 1 -name "*.ts" | wc -l)
    if [ "$num_files" -gt "$num_files_to_keep" ]; then
        files_to_delete=$(ls -t "$directory_path"/*.ts | tail -n +"$((num_files_to_keep + 1))")
        for file in $files_to_delete; do
            rm "$file"
            echo "Deleted: $file"
        done
    fi
    sleep 10 
done

