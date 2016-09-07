<?php

function autoLoad()
{
   GLOBAL $bdd;
   $class_and_functions = array
                           (
                              'define',
                              'accepted_extensions',
                              'copy_resample',
                              'remove_spaces',
                              'pure_characters',
                              'pure_link',
                              'build_link',
                              'create_secure_key',
                              'post',
                              'documentation',
                              'verif_session',
                              'verif_mail',
                              'send_mail'
                           );
   foreach($class_and_functions as $c):
      if(file_exists('php/class/'.$c.'.php')):
         include_once 'php/class/'.$c.'.php';
      elseif(file_exists('php/functions/'.$c.'.php')):
         include_once 'php/functions/'.$c.'.php';
      endif;
   endforeach;
}

autoLoad("autoLoad");

?>
