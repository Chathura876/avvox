cd C:\xampp\mysql\bin

echo %date%
echo %time%

set "dt=%date:~10,4%-%date:~4,2%-%date:~7,2%_%time:~1,-9%_%time:~3,2%_%time:~6,2%"


mysqldump -u root -proot crm_copy > H:\crmdbbackup\crm_%dt%.sql


