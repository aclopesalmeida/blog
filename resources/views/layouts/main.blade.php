<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="content-width;initial-scale=1.0"/>
    <title>{{ config('app.name')}}</title>
    
<base href="/">

@include('partials.head-inc')

</head>

<body ng-app="blog" class="container-fluid" id="ui">

    <div class="row no-padding" id="pre-header">
        <span><a href="#"><i class="fab fa-facebook"></i></a></span>
        <span><a href="#"><i class="fab fa-instagram"></i></a></span>
        <span><a href="#"><i class="fab fa-youtube"></i></a></span>
    </div>
    
    <header class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
            <div class="row">
                <div class="col-12 col-md-7 slide carousel carousel-fade" id="carousel" data-ride="carousel">
                    <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img class="img-fluid" src="{{ asset('imagens/homepage/fitness.png') }}"  alt="fitness">
                            </div>
                            <div class="carousel-item">
                            <img class="img-fluid" src="{{ asset('imagens/homepage/turismo.png') }}"  alt="turismo">
                            </div>
                            <div class="carousel-item">
                            <img class="img-fluid" src="{{ asset('imagens/homepage/nutricao.png') }}" alt="nutrição">
                            </div>
                    </div>
                </div>
                <div class="col-12 col-md-5" id="logotipo-container">
                    <img src="imagens/homepage/nome-blog.png" alt="Blog [Nome do Blog]" class="img-fluid" id="logotipo">
                </div>
            </div>
        </div>
        <span class="icone-menu"><i class="fas fa-bars"></i></span>  
        <span class="fechar-nav-btn pointer"><i class="far fa-times-circle"></i></span> 
        <nav class="col-12">
            <ul>
                <li><a href="/"  class="ativo">Home</a></li>
            <li><a href="/categorias/fitness/1">Fitness</a></li>
            <li><a href="/categorias/nutricao/2">Nutrição</a></li>
            <li><a href="/categorias/turismo-desportivo/3">Turismo Desportivo</a></li>
                <li><a href="/contactos">Contactos</a></li>
            </ul>

        </nav>
    </header>

    @yield('content')


    <footer class="row">
        <p id="copyright">&copy; 2018 - [Nome Blog]</p>

    </footer>

    
</body>
</html>
