/*==============================================================================
Click sur la touche entrée sur les inputs de connexion
==============================================================================*/
$(document).on('keyup','#table_connexion input[type=text],#table_connexion input[type=password]',function(e)
{
  if(e.keyCode==13)
  {
    var this_input = $(this).attr('name');
    var pseudo = $.trim($('#table_connexion input[type=text]').val());
    var pass = $.trim($('#table_connexion input[type=password]').val());

    // les 2 champs sont remplis, on simule le click de connexion
    if(pseudo!=='' && pass!=='')
    {
    $('#table_connexion input[type=button]').trigger('click');
    }

    else
    {
      if(this_input=='pseudo' && pseudo!=='' && pass=='')
      {
        $('#table_connexion input[type=password]').focus();
      }

      else if(this_input=='pass' && pass!=='' && pseudo=='')
      {
        $('#table_connexion input[type=text]').focus();
      }
    }
  }
});

/*==============================================================================
Click sur le boutton connexion de l'extranet
==============================================================================*/
$(document).on('click','#table_connexion input[type=button]',function()
{
  check_inputs(['input[name=pseudo]','input[name=pass]'],'#table_connexion','#form_connexion');
});


/*==============================================================================
                          Appel ckeditor
==============================================================================*/
function ckeditor_replace()
{
  if($('textarea').length)
  {
    $('textarea').each
    (
      function()
      {
        if($(this).data('ckeditor')=='1' && $(this).data('id'))
        {
          var name = 'text-'+$(this).data('id');
          CKEDITOR.replace( name );
        }
      }
    );
  }
}

/*==============================================================================
                          Hover sur un I info
==============================================================================*/
$(document).on('hover','div.reference',function()
{
  var data = $(this).data('reference');

  if(references[data]!==undefined)
  {
    var div = document.createElement('div');
    $(div).attr('class','alert-info alert-danger');
    $(div).html('<p>'+references[data]+'</p>');
    $(div).appendTo($('body'));
    $(div).animate({'opacity':'1'},250);
  }
});


/*==============================================================================
                          Leave sur un I info
==============================================================================*/
$(document).on('mouseleave','div.reference',function()
{
  $('.alert-info').remove();
});

/*==============================================================================
                          Clique sur + ajouter
==============================================================================*/
$(document).on('click','.add i',function()
{
  var style = $('.form-add').css('display');
  if(style == 'none')
  {
    $('.add').html('<i class="fa fa-minus"></i>');
    $('.form-add').css('display','block');
  }
  else
  {
    $('.add').html('<i class="fa fa-plus"></i>');
    $('.form-add').css('display','none');
    $('.form-add input[type=text], .form-add input[type=mail], .form-add input[type=number], .form-add textarea').each(
      function()
      {
        $(this).val('');
      }
    );
  }
});

/*==============================================================================
                          Click sur stylo update
==============================================================================*/
$(document).on('click','.action_update',function()
{
  var data = $(this).data('id');
  var original = $('.echo[data-id='+data+']');
  var form = $('.form_action_update[data-id='+data+']');
  var style = $(form).css('display');

  if(style == 'none' || style == undefined)
  {
    $(original).addClass('hidden');
    $(form).removeClass('hidden');
  }
  else
  {
    $(form).addClass('hidden');
    $(original).removeClass('hidden');
  }

  $('echo').each(
    function()
    {
      var other_data = $(this).data('id');
      var other_original = $('.echo[data-id='+other_data+']');
      var other_form = $('.form_action_update[data-id='+other_data+']');
      if(other_data !== data)
      {
        $(other_form).removeClass('hidden');
        $(other_original).removeClass('hidden');

        $(other_form).addClass('hidden');
        $(other_original).removeClass('hidden');
      }
    }
  )
});

/*==============================================================================
                          Entree sur un enter-submit
==============================================================================*/
$(document).on('keyup','.enter-submit',function()
{
  var form = $(this).data('form');
  var id = $(this).data('id');
  if(e.keyCode == 13)
  {
    $('form.'+form+'[data-id='+id+']').submit();
  }
})

/*==============================================================================
                      Click sur croix suppression élément
==============================================================================*/
$(document).on('click','.action_delete',function()
{
  var id = $(this).data('id');
  if(confirm('Supprimer cet élément ?'))
  {
    $('form.form_action_delete[data-id='+id+']').submit();
  }
})

/*==============================================================================
                          Document ready
==============================================================================*/
$(document).on('ready',function()
{
  if($('#table_connexion').length)
  {
      vertical_align('#table_connexion');
  }
  ckeditor_replace();
})
