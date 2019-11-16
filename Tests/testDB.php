<?php
function initTestDB()
{
    shell_exec('mysqldump --opt --no-create-info  -u userTEC -ppassTEC TEC > ../dump.sql');
    shell_exec('mysql -u userTEC -ppassTEC < ../build_database.sql');
}

function restoreDB()
{
    shell_exec('mysql -u userTEC -ppassTEC < ../build_database.sql');
    shell_exec('mysql -u userTEC -ppassTEC TEC < ../dump.sql');
}