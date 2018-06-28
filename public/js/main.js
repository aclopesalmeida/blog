$(function() {

    function esperarLoadDOM() {
        $iconeMenuResponsivo = $('.icone-menu');
        $botaoFecharMenu = $('.fechar-nav-btn');
        $imagemPrincipal = $('#imagens-container');
        $logotipo = $('#logotipo');
        $painelControlo = $('#painel-controlo');
        windowHeight = $(window).height();
        adminNavHeight = $('#admin-nav').outerHeight();
        $seccaoSite = $('body').attr('id') == 'admin' ? 'admin' : 'ui';
    
        $(window).on('resize', function() {
            gerirMenuResponsivo();
            ativarMenuResponsivo();
            alterarLogotipo();
        });

        
        $('nav li').on('click', 'a', function() {
            $(this).parents('ul').find('a.ativo').removeClass('ativo');
            $(this).addClass('ativo');
        });


       $('nav li').on('click', 'a', function() {
           $(this).parents('ul').find('a.ativo').removeClass('ativo');
           $(this).addClass('ativo');
       });
       
   
       function gerirMenuResponsivo() {
            $iconeMenuResponsivo.click(function() {
                if($seccaoSite == 'ui') {
                    $nav =  $nav = $(this).siblings('nav');
                }   
                else {
                    $nav = $(this).parent().siblings('nav');
                }
                
                $nav.add($botaoFecharMenu).addClass('fixed');
            });

            $botaoFecharMenu.click(function() {
                $nav =  $nav = $(this).siblings('nav');
                $nav.add($botaoFecharMenu).removeClass('fixed');
            })
       };


       function fecharMenuAposClicarItem() {
           // se o menu em sm screen estiver ativo
            if($(window).outerWidth() < 767) {
                $('body nav li').click(function() {
                    $nav = $(this).parents('nav');
                    $nav.add($botaoFecharMenu).removeClass('fixed');
                });
            }
       }

       function alterarLogotipo() {
            if($(window).outerWidth() < 767) {
                $logotipo.attr('src', '/imagens/homepage/nome-blog-sm.png');
            }
            else {
                $logotipo.attr('src', '/imagens/homepage/nome-blog.png');
            }
       }

       $('#carousel').carousel({
           interval: 3000
       })

       function fadeImagemPrincipal() {
           $imagemPrincipal.addClass('final');
       };
   
       function ativarMenuResponsivo() {
           if($(window).outerWidth() < 576) {
               $iconeMenuResponsivo.addClass('fixed');    
           }
           else {
               $iconeMenuResponsivo.removeClass('fixed');
           }

           if($(window).outerWidth() < 768){
                if($seccaoSite == 'admin' && $('#icone-menu-wrapper').length == 0) {
                        $iconeMenuResponsivo.wrap('<div class="col-8 offset-2" id="icone-menu-wrapper"></div>');
                }
            }
           else {
                $iconeMenuResponsivo.unwrap();
           }
       }
   

   
   
       function alterarPosicaoPainelControloAdmin() 
       {
           $painelControlo.height(windowHeight - adminNavHeight);
           
       }

       
        ativarMenuResponsivo();
        gerirMenuResponsivo();
        fecharMenuAposClicarItem();
        fadeImagemPrincipal();
        alterarLogotipo();
        alterarPosicaoPainelControloAdmin();

           
    } // fim load DOM

    setTimeout(function() {esperarLoadDOM(); }, 3000);
   
   });
