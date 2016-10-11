<?php
date_default_timezone_set('Europe/Paris');
define('ENVIRONNEMENT','dev'); // dev | prod | public

if(ENVIRONNEMENT == 'dev' || ENVIRONNEMENT == 'prod')
{
    ini_set('display_errors','on');
    ini_set('error_reporting',E_ALL);
}

else
{
    ini_set('display_errors','off');
    ini_set('error_reporting',0);
}
