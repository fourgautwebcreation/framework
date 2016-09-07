$(document).on('click','.content h3 span',function()
{
  var div = $(this).data('div');
  var style = $(div).css('display');
  $('.details').css('display','none');
  if(style=="none")
    $(div).css('display','block');
});
