<?php
function send_mail($from,$to,$subject,$mess)
{

     $envoi = 0;
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

     $message =
     '
     <!DOCTYPE HTML>
          <html>
               <head></head>
               <body>
                    <p>
                         '.$mess.'
                    </p>
               </body>
          </html>
     ';
     if(mail($to,$subject,$message,$headers))
     {
          $envoi = 1;
     }
     return $envoi;
}
?>
