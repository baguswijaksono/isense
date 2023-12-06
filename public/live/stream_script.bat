@echo off

set HLS_TIME=10
set HLS_LIST_SIZE=10
set STREAM_URL=rtsp://192.168.1.30:1935/
set OUTPUT_FILE=mystream.m3u8
set TS_FOLDER=mystream

ffmpeg -i %STREAM_URL% -c:v copy -c:a aac -hls_time %HLS_TIME% -hls_list_size %HLS_LIST_SIZE% %OUTPUT_FILE%

:: Delay to ensure files are generated before processing
timeout /t 5 /nobreak > nul

:: Change directory to the output folder where the .ts files are stored
cd %TS_FOLDER%

:: Get the count of .ts files in the folder
for %%# in (*) do set /a Count+=1

:: If the count exceeds 10, delete the oldest files until 2-10 are left
if %Count% gtr 10 (
    set /a DeleteCount=%Count%-10
    for /f "skip=%DeleteCount% delims=" %%F in ('dir /b /o-d *.ts') do (
        del "%%F"
    )
)

:: Return to the previous directory
cd ..
