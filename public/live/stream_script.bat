@echo off
set HLS_TIME=10
set HLS_LIST_SIZE=10
set STREAM_URL=rtsp://172.16.94.12:1935/
set OUTPUT_FILE=mystream.m3u8

ffmpeg -i "%STREAM_URL%" -c:v copy -c:a aac -hls_time %HLS_TIME% -hls_list_size %HLS_LIST_SIZE% "%OUTPUT_FILE%"
