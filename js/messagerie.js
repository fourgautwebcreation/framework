//clé du securité
var key = '';
//taille de la fenetre
var width = 0;
//taille d'une box de conversation
var width_box = 0;
//nombre de boxs maximum
var max_boxs = 0;
//id de l'utilisateur
var id = 0;
//variable stockants la liste des contacts
var contacts = '';
//variable contenant le nombre d'appel du fichier contacts.php
var calls = 0;


//Cette fonction récupere la liste des contacts et les affiche dans la box
function get_contacts()
{
  $.getJSON('/php/lib/messagerie/contacts.php',{'id':id,'key':key})
  .fail(
    function()
    {
      get_contacts();
    }
  )
  .success(
    function(data)
    {
      calls++;
      //premier appel, on appele la fonction get_messages
      if(calls == 1)
      {
        get_messages(id);
      }
      contacts = data;
      var html = '<table class="table table-responsive table-hovered">';
      $.each(contacts,
        function(key)
        {
          if(contacts[key]['statut'] == 0){var point = '<div class="point_red"></div>'; }
          else if(contacts[key]['statut'] == 1){var point = '<div class="point_green"></div>'; }

          html += '<tr class="open-tchat" data-id="'+contacts[key]['id']+'">';
            html += '<td align="left"><img width="50" src="'+contacts[key]['avatar']+'" alt="" /></img></td>';
            html += '<td align="left">'+contacts[key]['prenom']+' '+contacts[key]['nom']+'</td>';
            html += '<td align="left">'+point+' '+contacts[key]['time']+'</td>';
          html += '</tr>';
        }
      )
      html += '</table>';
      $('.general_box_middle').html(html);
      //rappel de la fonction contacts
      setTimeout(function(){get_contacts();},10000);
    }
  );
}


//Cette fonction récupere les messages
function get_messages(id)
{
  $.getJSON('/php/lib/messagerie/messages.php',{'id':id,'key':key})
  .fail(function()
  {
    get_messages(id);
  })
  .success(
    function(data)
    {
      for(i=0;i<data.length;i++)
      {
        var his_id = parseInt(data[i]['expediteur']);
        create_tchat(his_id,1);
      }

      //temps de création de la boite plus envoi de l'update
      setTimeout(function(){get_messages(id)},2000);
    }
  );
}

//Cette fonction crée la box principale de la messagerie
function add_messagerie()
{
 if(width>1024 && id!=='' && key!=='')
 {
  //on définit la variable max_box, le -1 représente la box générale
  max_boxs = Math.floor(width/width_box)-1;
  //on enregistre le timestamp de création
  var time = new Date().getTime();

  var html = '<div class="general_box_top"><p>Messagerie</p></div>';
  html += '<div class="general_box_middle"></div>';
  var div = document.createElement('div');
  $(div).attr('class','general_box');
  $(div).attr('data-timestamp',time);
  $(div).css('width',width_box+'px');
  $(div).html(html);
  $(div).appendTo($('body'));
  //+4 car border-width:2px
  var height = parseInt($(div).height())+4;
  //on enregistre son height en data pour la réduction/agrandissement de la box
  $(div).attr('data-height',height);
  $(div).css('height','50px');

  //on crée l'élément audio destiné à alerter de manière sonore la réception d'un message
  var div2 = document.createElement('audio');
  $(div2).attr('class','new_message');
  $(div2).attr('preload','preload');
  $(div2).html('<source src="/audio/notification.mp3" type="audio/mp3"/>')
  $(div2).appendTo($('body'));

  //appel des contacts
  get_contacts();
 }
}

//cette fonction insere la discution
function get_discution(id,his_id)
{
  //verification que la discution est toujours ouverte
  if($('#tchat'+his_id).length)
  {

  var timestamp = 0;
  var html = '';
  var last_send = 0;
  var last_send_id = 0;

  var type = 0;
  var count_messages = $('#tchat'+his_id+' .tchat_middle .discution .message').length;
  var count_envoyes = $('#tchat'+his_id+' .tchat_middle .discution .message_to').length;

  var id_last = 0;
  var statut_last = 0;

  //si des messages sont présent, ainsi qu'un message envoyé
  if(count_messages !== 0 && count_envoyes !== 0)
  {
    var get_last = $('#tchat'+his_id+' .tchat_middle .discution .message_to')[count_envoyes-1];
    var data = $(get_last).data('id');
    var statut = $('.content_message[data-id='+data+']').find('.statut').data('statut');

    id_last = data;
    statut_last = statut;
  }

  $.getJSON('/php/lib/messagerie/discution.php',{'destinataire':id,'expediteur':his_id,'key':key,'count':count_messages,'statut_last':statut_last,'id_last':id_last})
  .fail(function()
  {
    get_discution(id,his_id);
  })
  .success(
    function(data)
    {
      for(i=0;i<data.length;i++)
      {
        var id_message = parseInt(data[i]['id']);
        var message = data[i]['text'];
        var expediteur = parseInt(data[i]['expediteur']);
        var statut = parseInt(data[i]['statut']);

        //mise a jour du timestamp du dernier message échangé
        if(data[i]['timestamp'] > timestamp)
        {
          $('#tchat'+his_id).attr('data-timestamp',data[i]['timestamp']);
        }

        //si le message n'est pas déjà présent dans la conversation
        if(!$('#tchat'+his_id+' .tchat_middle .discution .message[data-id="'+id_message+'"]').length)
        {
          html += '<div class="block_message">';

          //message dont nous sommes l'expediteur
          if(parseInt(expediteur) !== parseInt(his_id))
          {
            //enregistrement de la derniere clé de message
            last_send = i;
            last_send_id = id_message;

            html += '<div align="right" data-id="'+id_message+'" class="message message_to">';
              html += '<div class="content_message" data-key="'+i+'" data-id="'+id_message+'"><span>'+message+'</span>';
              html += '</div>';
            html += '</div>';
          }

          else if(parseInt(expediteur) == parseInt(his_id))
          {
            //renseignement d'un message non lu
            if(statut == 0){type = 1;}

            html += '<div align="left" data-key="'+i+'" data-id="'+id_message+'" class="message message_from">';
              html += message;
            html += '</div>';
          }
          html += '</div>';
        }

        //si le message est déja present
        else
        {
          //message dont nous sommes l'expediteur
          if(parseInt(expediteur) !== parseInt(his_id))
          {
            //enregistrement de la derniere clé de message
            last_send = i;
            last_send_id = id_message;
          }
          else if(parseInt(expediteur) == parseInt(his_id))
          {
            //renseignement d'un message non lu
            if(statut == 0){type = 1;}
          }
        }
      }

      //recupération du statut du dernier message envoyé
      if(data[last_send]['statut'] == 1)
      {
        var view = '<i class="fa fa-check"></i>';
      }
      else
      {
        var view = '<i class="fa fa-send"></i>';
      }

      html += '</div>';
      var append = $(html).appendTo($('#tchat'+his_id+' .tchat_middle .discution'));

      if(append)
      {
        if($('.discution[data-id='+his_id+'] img.loading').length)
        {
          $('.discution[data-id='+his_id+'] img.loading').remove();
        }
        //si le symbole vu n'était pas déja renseigné
        if($('.statut[data-key='+last_send+'][data-id='+last_send_id+']').length == 0)
        {
          var view = '<div class="statut" data-statut="'+data[last_send]['statut']+'" data-key="'+last_send+'" data-id="'+last_send_id+'">'+view+'</div>';
          $(view).appendTo($('.content_message[data-key='+last_send+'][data-id='+last_send_id+']'));
        }
        else
        {
          $('.statut[data-key='+last_send+'][data-id='+last_send_id+']').data('statut',data[last_send]['statut']);
          $('.statut[data-key='+last_send+'][data-id='+last_send_id+']').html(view);
        }

        //taille du conteneur
        var height_conteneur = parseInt($('#tchat'+his_id+' .tchat_middle').height());
        //taille de la discution
        var top = parseInt($('#tchat'+his_id+' .tchat_middle .discution').height());
        //scroll en cours
        var current_scroll = parseInt($('#tchat'+his_id+' .tchat_middle').scrollTop());

        if((top-current_scroll-height_conteneur) < height_conteneur || current_scroll == 0)
        {
        $('#tchat'+his_id+' .tchat_middle').scrollTop(top);
        }
      }


      //si un message non lu a été detecté
      if(type == 1)
      {
        //si on est pas sur le textarea de la discution, on sonne l'alerte
        if($('textarea[data-expediteur="'+id+'"][data-destinataire="'+his_id+'"]').is(':focus') == false)
        {
          $('.new_message').get(0).currentTime = 0;
          $('.new_message').get(0).play();
          hide_show_discution(his_id,1);
          //effet visuel de surbrillance
          surbrillance(his_id);
          update_vue(id,his_id);
        }
        else
        {
          update_vue(id,his_id);
        }
      }
      get_discution(id,his_id);
    }
  );
  }
}

//cette fonction passe les messages reçus en statut = 1
function update_vue(id,his_id)
{
  $.post('/php/lib/messagerie/update.php',{'type':'vue','destinataire':id,'expediteur':his_id,'key':key});
}

//fonction qui crée une surbrillance de la discution
function surbrillance(his_id)
{
  var div = $('#tchat'+his_id+' .tchat_top');
  $(div).animate(
    {'opacity':'0.5'},250,
    function()
    {
      $(div).animate(
        {'opacity':'1'},250
      );
    }
  );
}

//cette fonction vérifie l'existence d'une discution passé
function verif_exists_discution(id,his_id)
{
  $.get('/php/lib/messagerie/discution_exists.php',{'destinataire':id,'expediteur':his_id,'key':key})
  .success(
    function(data)
    {
      //aucun message préalablement échangé, on supprime le loading
      if(data == 0)
      {
        get_discution(id,his_id);
        $('.discution[data-id='+his_id+'] img.loading').remove();
      }
      else
      {
        get_discution(id,his_id);
      }
    }
  );
}

//cette fonction crée une boite de dialogue
function create_tchat(his_id,type)
{
  //si la boite de dialogue n'existe pas
  if(!$('#tchat'+his_id).length)
  {

    //si il n'y a plus de place pour une nouvelle boite
    if($('.tchat').length >= max_boxs )
    {
    var id_box = 0;
    var timestamp_box = 0;


    //on prends la box qui a le plus petit data-timestamp
      $('.tchat').each(
        function()
        {
          if( ($(this).data('timestamp') < timestamp_box) || timestamp_box == 0)
          {
            id_box = $(this).data('id');
            timestamp_box = $(this).data('timestamp')
          }
        }
      );

    //on la détruit
    destroy_tchat(id_box);
    }

    //on compte le nombre de discution + la boite générale
    var others = ($('.tchat').length)+1;

    //on en déduit le right en px
    var right = others*width_box;

    //on crée la boite de dialogue
    var div = document.createElement('div');
    $(div).attr('class','tchat');
    $(div).attr('id','tchat'+his_id);
    $(div).attr('data-id',his_id);
    $(div).attr('data-timestamp','0');
    $(div).css({'width':width_box+'px','right':right+'px','height':'339px'});


    //on crée son contenu
    var html = '<div class="tchat_top" data-id="'+his_id+'" >';
          html += '<table class="table table-responsive">';
            html += '<tr>';
              html += '<td align="left" width="50"><img src="'+contacts[his_id]['avatar']+'" alt="" class="img-responsive"/></img></td>';
              html += '<td align="left">'+contacts[his_id]['prenom']+' '+contacts[his_id]['nom']+'</td>';
              html += '<td align="right"><i class="fa fa-remove" data-id="'+contacts[his_id]['id']+'"></i></td>';
            html += '</tr>';
          html += '</table>';
        html += '</div>';
        html += '<div class="tchat_middle" data-id="'+his_id+'"><div class="discution" data-id="'+his_id+'"><img class="loading" src="/php/lib/messagerie/img/loading.gif" alt=""/></div></div>';
        html += '<div class="tchat_bottom">';

          html += '<form data-id="'+his_id+'" method="post" enctype="mutlipart/form-data">';
            html += '<input data-id="'+his_id+'" id="post_file_'+his_id+'" type="file" data-expediteur="'+id+'" data-destinataire="'+his_id+'"/>';
            html += '<i class="fa fa-upload"></i>';
          html += '</form>';
          html += '<div class="echo_upload" data-id="'+his_id+'"></div>';

          html += '<textarea class="form-control" data-expediteur="'+id+'" data-destinataire="'+his_id+'"></textarea>';
        html += '</div>';

    $(div).html(html);

    //on ajoute la box au body
    $(div).appendTo($('body'));

    var height = parseInt($(div).height())+4;

    //prise d'information de l'existence de la conversation, recuperation de la conversation
    verif_exists_discution(id,his_id);

    //on renseigne son data-height pour la réduction / agrandissement
    $(div).attr('data-height',height);
  }
}

//cette fonction réduit ou aggrandit une discution
function hide_show_discution(his_id,show)
{
  var div = $('#tchat'+his_id);
  var height = parseInt($(div).height())+4;
  var data = $(div).data('height');

  if(show == 0)
  {
    if(height == data)
    {
      $(div).css('height','50px');
    }
    else
    {
      $(div).css('height',data+'px');
    }
  }

  //on force la box a s'agrandir dans le cas d'une reception de message
  else if(show == 1)
  {
    $(div).css('height',data+'px');
  }
}

function hide_show_box()
{
  var div = $('.general_box');
  var height = parseInt($(div).height())+4;
  var data = $(div).data('height');
  if(height == data)
  {
    $(div).css('height','50px');
  }
  else
  {
    $(div).css('height',data+'px');
  }
}

//cette fonction detruit une discution
function destroy_tchat(id)
{
  var right = parseInt($('#tchat'+id).css('right'));
  $('#tchat'+id).remove();
  $('.tchat').each(
    function()
    {
      if(parseInt($(this).css('right')) > right)
      {
        var this_right = parseInt($(this).css('right'));
        $(this).css('right',(this_right-width_box)+'px');
      }
    }
  );
}

//cette fonction envoi le message
function send_message(expediteur,destinataire,message)
{

$.post('/php/lib/messagerie/post.php',{'expediteur':expediteur,'destinataire':destinataire,'message':message,'key':key})
.success(
  function()
  {
    $('#tchat'+destinataire+' textarea').val('');
    $('.tchat textarea[data-expediteur='+expediteur+'][data-destinataire='+destinataire+']').removeAttr('disabled');
    $('.tchat textarea[data-expediteur='+expediteur+'][data-destinataire='+destinataire+']').focus();
  }
);
}

//cette fonction remplace l'image par l'iframe au click
function replace_img_iframe(id_message,key,plateforme,iframe)
{
  if(plateforme !== '' && iframe !== '')
  {
    if(plateforme == 'youtube')
    {
      var iframe = '<iframe width="100%" class="iframe-responsive" src="'+iframe+'" frameborder="0" allowfullscreen></iframe>';
      $('.message[data-id="'+id_message+'"] a div[data-key="'+key+'"]').html(iframe);
    }

    else if(plateforme == 'dailymotion')
    {
      var iframe = '<iframe width="100%" class="iframe-responsive" src="'+iframe+'" frameborder="0" allowfullscreen></iframe>';
      $('.message[data-id="'+id_message+'"] a div[data-key="'+key+'"]').html(iframe);
    }

    else if(plateforme == 'rutube')
    {
      var iframe = '<iframe width="100%" class="iframe-responsive" src="'+iframe+'" frameborder="0" allowfullscreen></iframe>';
      $('.message[data-id="'+id_message+'"] a div[data-key="'+key+'"]').html(iframe);
    }

  }
}

//click sur un contact
$(document).on('click','.open-tchat',function()
{
  var id = $(this).data('id');
  create_tchat(id,0);
});

//clicque sur la croix de fermeture d'une box
$(document).on('click','.tchat_top i',function()
{
  var id = $(this).data('id');
  destroy_tchat(id);
});

//click sur le haut de la box
$(document).on('click','.tchat_top',function()
{
  var his_id = $(this).data('id');
  hide_show_discution(his_id,0);
});

//click sur le haut de la box générale
$(document).on('click','.general_box_top',function()
{
  hide_show_box();
});

//click sur une image présente dans la discution
$(document).on('click','.message a img',function()
{
  var id_message = $(this).data('id');
  var plateforme = $(this).data('plateforme');
  var iframe = $(this).data('iframe');
  var key = $(this).data('key');
  //si les datas sont renseignés, c'est donc une image "pré-iframe"
  if(plateforme !== '' && iframe !== '')
  {
    replace_img_iframe(id_message,key,plateforme,iframe);
    return false;
  }
});

//ecriture dans le textarea
$(document).on('keyup','.tchat textarea',function(e)
{
  //condition de la touche entrée
  if(e.keyCode == 13 && e.shiftKey==false && e.altKey==false)
  {
    var expediteur = $(this).data('expediteur');
    var destinataire = $(this).data('destinataire');
    var message = $.trim($(this).val());
    $('.tchat textarea[data-expediteur='+expediteur+'][data-destinataire='+destinataire+']').attr('disabled','disabled');
    send_message(expediteur,destinataire,message);
  }
});

//upload d'un fichier
$(document).on('change','.tchat_bottom input[type=file]',function()
{
  var id = $(this).data('id');
  var file = document.getElementById('post_file_'+id).files[0];
  var expediteur = $(this).data('expediteur');
  var destinataire = $(this).data('destinataire');

  if (file)
  {
    $('.echo_upload[data-id='+id+']').html('Upload en cours...');

    var form_data = new FormData();
    form_data.append('file', file);
    form_data.append('expediteur', expediteur);
    form_data.append('destinataire', destinataire);
    form_data.append('key', key);

    $.ajax(
      {
        type: 'post',
        url: '/php/lib/messagerie/post_fichier.php',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (d)
        {
          if(d == 1)
          {
            document.getElementById('post_file_'+id).value = '';
            $('.echo_upload[data-id='+id+']').html('Upload effectué');
            setTimeout(
              function()
              {
                $('.echo_upload[data-id='+id+']').html('');
              },
              2500
            );
          }
          else
          {
            $('.echo_upload[data-id='+id+']').html('Erreur lors de l\'upload');
            setTimeout(
              function()
              {
                $('.echo_upload[data-id='+id+']').html('');
              },
              2500
            );
          }
        }
      });
  }
});


//Envoi de l'activité de l'utilisateur
$(window).on('click',function()
{
  var time_know = $('.general_box').data('timestamp');
  //on enregistre le timestamp du click
  var time = new Date().getTime();
  if((time - time_know) > ((1000*60)*5) )
  {
    $.post('/php/lib/messagerie/activity.php',{'id':id,'key':key});
  }
});

$(document).on('ready',function()
{
//enregistrement de la taille de la fenetre
width = parseInt($(window).width());
//définition de la taille d'une box pour en placer 5, le -4 représente les bordures
width_box = (width/5)-4;
add_messagerie();
});
