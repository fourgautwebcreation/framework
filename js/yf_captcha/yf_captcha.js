var array = [
            'decons',
            'faupersc',
            'rateoth',
            'wardst',
            'caudzoa',
            'busneste',
            'fistiotf',
            ],
input = 'input[type=submit][data-yfCaptcha=1]',
text = 'input[type=text][name=verif-yfCaptcha]';

(function( $ )
{
   $.fn.yf_captcha = function( options )
   {
      if($(this).attr('id'))
      {
         var div = '#'+$(this).attr('id');
      }
      else if($(this).attr('class'))
      {
         var div = '.'+$(this).attr('class');
      }

      $(input).css({'display':'none','opacity':'0'});

      //choisi un nombre entre 0 et 6
      var number = Math.floor(Math.random()*6);
      $(input).attr('data-number',number);

      var html = '<img style="display:inline-block;vertical-align:middle" src="/js/yf_captcha/img/'+(number+1)+'.png" />';
      html += '<input style="display:inline-block;margin-left:0.5em;vertical-align:middle;" type="text" data-number="'+number+'" name="verif-yfCaptcha" />';

      $(div).html(html);
      return this;
   };
})( jQuery );

$(document).on('keyup',text,function()
{
   var target = $(this).data('number');
   var val = $.trim($(this).val());
   if(array[target]==val)
   {
      $(input).css('display','block');
      $(input).animate({'opacity':'1'},500);
   }
   else
   {
      $(input).css({'display':'none','opacity':'0'});
   }
});

$(document).on('click',input,function()
{
   var target = $(this).data('number');
   var val = $.trim($(text).val());
   if(array[target]==val)
   {
      return true;
   }
   else
   {
      return false;
   }
});
