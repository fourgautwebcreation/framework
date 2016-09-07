/*==============================================================================
Fonction indiquant si l'élément est hovered
==============================================================================*/
function isHovered(id)
{
  var rep = $(id+':hover').length;
  return rep;
}

/*==============================================================================
fonction d'écriture de l'erreur
==============================================================================*/
function write_error(error)
{

  var html = '<p><span>';
  html += '<i class="fa fa-remove"></i>';
  html += '<i class="fa fa-warning"></i>';
  html += error;
  html += '</span></p>';

  var div = document.createElement('div');
  $(div).attr('class','error');
  $(div).html (html);
  $(div).appendTo($('body'));
  $(div).animate({'opacity':'1'},'slow');
}
/*==============================================================================
fonction d'alignement vertical en position fixed
==============================================================================*/

function vertical_align(id)
{
  var width_id = parseInt($(id).width());
  var height_id = parseInt($(id).width());
  $(id).css({'position':'fixed','left':'50%','top':'50%','margin-left':'-'+(width_id/2)+'px','margin-top':'-'+(height_id/2)+'px'});
  $(id).animate({'opacity':'1'},'slow');
  $(id).find('input[type=text]').get(0).focus();
}

/*==============================================================================
fonction de vérification de champ vide
==============================================================================*/
function check_inputs(inputs,id,submit)
{
  //On remet toutes les div alertant de champ vide en display none
  $(id).find('.champs_vide').css('display','none');

  var champs = new Array;
   for(i=0;i<inputs.length;i++)
   {
       var val = $.trim($(id).find(inputs[i]).val());

       //si le champs est vide, on l'enregistre dans le tableau des champs vides
       if(val=='' && val!==undefined)
       {
         var nom = $(id).find(inputs[i]).attr('name');
         champs.push(nom);
       }
   }

   //si le tableau des champs vides..est vide, on post le formulaire
   if(champs.length<1)
   {
     if(submit!=='')
     {
       $(submit).submit();
     }
   }

   //si il ne l'est pas
   else
   {
     for(i=0;i<champs.length;i++)
     {
       $(id).find('.champs_vide[data-name='+champs[i]+']').css('display','block');
     }
   }
}

/*==============================================================================
Click sur la croix de fermeture du message d'erreur
==============================================================================*/
$(document).on('click','.error i.fa-remove',function()
{
  $('.error').remove();
});
