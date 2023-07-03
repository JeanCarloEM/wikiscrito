(function($){ //criar fechamento, para que possamos usar com segurança $ como apelido para jQuery
  $(window).scroll(function(){
    /* EFEITO MENU MUDANDO DE APARENCIA */
    if ($(window).scrollTop() > (($(window).height()*0.05)>20?($(window).height()*0.05):20))
      $('header#master').addClass('scroll');
    else
      $('header#master').removeClass('scroll');        
    
    /* ACERTANDO A EXIBIÇÃO DO MENU */    
    exibirMenu(true);

    $('header#master div.menu').addClass('inicializado');
  });

  /* ACERTANDO A EXIBIÇÃO DO MENU */
  $(window).resize(function(){
    exibirMenu(false);
  });

  /* CARREGA O CONTEUDO DOS SVGs */
  $(document).ready(function(){
    $('svg[src*="/"]').each(function (){
      var el  = $(this);
      var css = el.attr('class');    
      var st  = el.attr('style');    

      $.ajax({
        url: this.getAttribute("src"),
        cache: true,
        async: false,
        dataType: "text",         
        success: function( xml ) {        
          $.each(el.prop('attributes'), function(){
            xml = xml.replace("<svg ", '<svg '+this.name+'="' + this.value + '" ');
          });

          var pos = xml.indexOf('<svg ');
          xml = xml.substring(pos, xml.lenght);
          el.replaceWith(xml);
        }
      });       
    });
    
    // initialise plugin SUPERFISH
    var principal = $('#master').superfish({
            //add options here if required
    });
    
    $('a.sf-with-ul').on('click', function(){
      if ($('a.sf-with-ul').css('display') == 'none')
        principal.children('li:first').superfish('show');
      else
        window.setTimeout("principal.children('li:first').superfish('hide');", 500);        
    });  
  });
})(jQuery);


function exibirMenu(esperou, seguranca){
  if (esperou){
    var menuW   = parseInt($('header#master div.menu ul').attr('ow'));
    
    if ((isNaN(menuW))){
      menuW = $('header#master div.menu ul').outerWidth();
      
      if (isNaN(menuW))
        var menuW = 0;
    
      $('header#master div.menu ul').attr('ow', menuW);
    }
    
    
    var MenuSW   = parseInt($('header#master ul#principal').attr('ow'));
    
    if ((isNaN(MenuSW))){
      MenuSW = $('header#master ul#principal').outerWidth();
      
      if (isNaN(MenuSW))
        var MenuSW = 0;
    
      $('header#master ul#principal').attr('ow', MenuSW);
    }          
            
    var logoW   = $('header#master div.logo').outerWidth(true);    
    var screenW = $(window).width();

    /*$('div#pg_id_splash').html('\n\n\n\n<br /><br /><br /><br /><br /> logoW = ' + logoW + ' <br /> menuW = ' + menuW + ' <br />soma = '+(menuW+logoW)+'<br /> screenW = ' + screenW + ' <br /> ===' + $('header#master div.menu ul').css('display'));*/

    if ((logoW + menuW + 7) > screenW){
      /*$('div#pg_id_splash').html($('div#pg_id_splash').html() + '\n<br />SIM');*/

      menuDisplay('header#master div.menu ul', true, menuW);
      /*$('header#master div.menu ul').hide();*/
      menuDisplay('header#master ul#principal', false, MenuSW);      
    }else if (seguranca != 1){
      menuDisplay('header#master div.menu ul', false, menuW);
      /*$('header#master div.menu ul').show();      */
      menuDisplay('header#master ul#principal', true, MenuSW);
    }
  }else
    window.setTimeout('exibirMenu(true);', 100);
  
  if (seguranca != 1)
    window.setTimeout('exibirMenu(true, 1);', 800);    
  else{
    if (($('header#master ul#principal').css('display') == 'none') && ($('header#master div.menu ul').css('display') == 'none'))
      menuDisplay('header#master ul#principal', false, MenuSW)
  }
}

function menuDisplay(tag, desaparecer, originalW, esperou){
  if (desaparecer){
    /*$('div#pg_id_splash').html($('div#pg_id_splash').html() + '\n<br />SIM');*/

    /* SUMINDO */
    if ($(tag).css('display') != 'none'){
      if ($(tag).attr('processando') != 1){
        $(tag).attr('processando', 1);

        $(tag).animate({width: 0},  "fast", "linear", function(){
          $(tag).attr('od', $(tag).css('display'));
          $(tag).css('display', 'none');          
          $(tag).attr('processando', 0);           
        });           
      }else if (esperou != 1){
        window.setTimeout('menuDisplay('+tag+', '+tag+', 1);', 800);        
      }
    }
  }else{
    /*$('div#pg_id_splash').html($('div#pg_id_splash').html() + '\n<br />NÃO');      */
    if ($(tag).css('display') == 'none'){
      if ($(tag).attr('processando') != 1){
        $(tag).attr('processando', 1);
        $(tag).css('display', $(tag).attr('od'));

        $(tag).animate({width: originalW}, "fast", "linear", function(){
          $(tag).attr('processando', 0);        
        });
      }else if (esperou != 1){
        window.setTimeout('menuDisplay('+tag+', '+tag+', 1);', 800);        
      }
    }      
  }  
}