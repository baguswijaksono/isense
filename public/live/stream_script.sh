#!/bin/bash

HLS_TIME=10
HLS_LIST_SIZE=10
STREAM_URL="rtsp://192.168.1.4:1935/"
OUTPUT_FILE="mystream.m3u8"

ffmpeg -i "$STREAM_URL" -c:v copy -c:a aac -hls_time "$HLS_TIME" -hls_list_size "$HLS_LIST_SIZE" "$OUTPUT_FILE"
