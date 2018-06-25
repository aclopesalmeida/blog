
/// <reference path="services.js" />

app.controller('posts', function(AdminServicoGenerico, $location, $scope) {
    $scope.posts = AdminServicoGenerico.get().resultado('/api/posts', null).then(function(response) {
        $scope.posts = response.data.posts;
    });
})
.controller('post', function($scope, AdminServicoGenerico, $routeParams) {
    $scope.post = AdminServicoGenerico.get().resultado('/api/post/', $routeParams.id).then(function(response) {
        $scope.post = response.data.post;
    });

    $scope.ultimosPosts = AdminServicoGenerico.get().resultado('/api/posts', null, 4).then(function(response) {
        $scope.ultimosPosts = response.data.posts;
    });
})
.controller('categoria', function($scope, $http, $routeParams, AdminServicoGenerico) {
    $scope.posts = AdminServicoGenerico.get().resultado('/api/categorias/', $routeParams.id).then(function(response) {
        $scope.originalPosts = response.data.posts;
        $scope.posts = $scope.originalPosts;
        $scope.categoria = response.data.categoria;
        
        $scope.currentPage = 1;
        $scope.itemsPerPage = 3;
        $scope.totalItems = $scope.posts.length;
        $scope.maxSize = 10;
        paginacao($scope.currentPage);
    });

    $scope.mudarPagina = function() {
        paginacao($scope.currentPage);
      };

      function paginacao(pagina) {
        var begin = ($scope.currentPage - 1) * $scope.itemsPerPage;
        var end = begin + $scope.itemsPerPage;
    
        $scope.posts = Array.from($scope.originalPosts).slice(begin, end);
      };
    
})
.controller('contactos', function($scope, ServicoEmail, $anchorScroll) {
    $scope.enviarEmail = function() {
        ServicoEmail($scope.model).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll();
        });
    };
})
.controller('adminPosts', function($scope, $routeParams, $location, $anchorScroll, AdminServicoGenerico) {

    $scope.posts = AdminServicoGenerico.get().resultado('/api/admin/posts', null).then(function(response) {
        $scope.posts = response.data.posts;
    });


    AdminServicoGenerico.get().resultado('/api/admin/categorias', null).then(function(response) {
        $scope.categorias = response.data.categorias;
    });

    $scope.criarPost = function() {
        var formData = new FormData();
        for(var key in $scope.post) 
        {
            formData.append(key, $scope.post[key]);
        };
        if($scope.post.imagem != null) 
        {
            formData.append('imagem', $scope.post.imagem);
        }
        if($scope.post.categorias != null) {
            var categorias = JSON.stringify($scope.post.categorias);
            formData.append('categorias', categorias);
        }

        AdminServicoGenerico.criar().resultado('/api/admin/posts/criar', formData, true).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
          
            $anchorScroll(); 
        });
    };


    $scope.post = AdminServicoGenerico.get().resultado('/api/post/', $routeParams.id).then(function(response) {
        $scope.post = response.data.post;
    });
  
     $scope.editarPost = function() {
        var formData = new FormData();
        for(var key in $scope.post) 
        {
            if(key !== 'imagem') {
                formData.append(key, $scope.post[key]);
            }
        };
        if($scope.post.imagem != null) 
        {
            formData.append('imagem', $scope.post.imagem);
        }
        if($scope.post.categorias != null) {
            var categorias = JSON.stringify($scope.post.categorias);
            formData.append('categorias', categorias);
        }

        AdminServicoGenerico.editar().resultado('/api/admin/posts/editar', $routeParams, formData, true).then(function(response) {
            $scope.mensagem = response.data.mensagem; 
            $scope.erros = response.data.erro;
            $anchorScroll();   
        });
    };

    $scope.apagarPost = function() {
        AdminServicoGenerico.apagar().resultado('/api/admin/posts/apagar', $scope.post.id, $scope.post).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
        });
    };

    $scope.tinymceOptions = {
        setup: function(editor) {
            editor.on("init", function() {
              }, 7000);
        },
        baseUrl: '/admin',
        plugins: 'advlist autolink lists link charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code',
        theme:'modern'
    };

    $scope.apagarComentario = function(id) {
        var apagar = confirm('Tem a certeza que deseja apagar este comentário?');

        if(apagar) {
            AdminServicoGenerico.apagar().resultado('/api/admin/comentarios/apagar', id, {id: id}).then(function(response) {
                $scope.mensagem = response.data.mensagem;
                $scope.erros = response.data.erro;
                $anchorScroll(); 
            });
        }
    };
    
})
.controller('adminCategorias', function($scope, $routeParams,   $anchorScroll, $http, AdminServicoGenerico, $uibModal) {
    $scope.categorias = AdminServicoGenerico.get().resultado('/api/admin/categorias', null).then(function(response) {
        $scope.categorias = response.data.categorias;
    });

    $scope.criarCategoria = function() {
        AdminServicoGenerico.criar().resultado('/api/admin/categorias/criar', $scope.categoria, false).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };
    
    $scope.editarCategoria = function (cat) {
        var modalInstance = $uibModal.open({
            animation: true,
            controller: 'adminCategoriasModal',
            scope: $scope,
            templateUrl: '/modals/editar-categoria.html',
            size: 'sm',
            resolve: {
                categoria: function() { return cat; }
            }
        });
    };

    $scope.apagarCategoria = function(id) {
        var apagar = confirm('Tem a certeza que deseja apagar esta categoria?');
        
        if(apagar) {
            AdminServicoGenerico.apagar().resultado('/api/admin/categorias/apagar', id, $scope.categoria).then(function(response) {
                $scope.mensagem = response.data.mensagem;
                $scope.erros = response.data.erro;
                $anchorScroll(); 
            });
        }
    }
  
})
.controller('adminCategoriasModal', function($scope, $uibModalInstance, categoria, AdminServicoGenerico) {
    $scope.categoria = categoria;
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.ok = function () {
        AdminServicoGenerico.editar().resultado('/api/admin/categorias/editar', $scope.categoria.id, $scope.categoria, false).then(function(response) {
                $scope.mensagem = response.data.mensagem;
                $scope.erros = response.data.erro;
                console.log($scope.cat);
                $uibModalInstance.close();
            });
    };
})
.controller('adminLogin', function($scope, $rootScope, $location, AdminServicoAutenticacao){

    $scope.login = function() {
        AdminServicoAutenticacao.login().resultado('/api/admin/login', $scope.utilizador).then(function(response) {
            if(response.status == 200) {
                sessionStorage.setItem('token', response.data.token);
                $rootScope.$broadcast('utilizadorAutenticado');
                $location.path('/admin/home');
            }
            else {
                console.log(response.data.erro);
                switch(response.data.erro)
                {
                    case 'invalido':
                        alert('Email ou password incorretos.');
                        break;
                    case 'token':
                        alert('Ocorreu um erro. Por favor contacte o administrador do sistema.');
                        break;
                    default:
                        alert($scope.erro);
                }
            }
        });

        // $scope.verificar = function() {
        //     AdminServicoAutenticacao.verificar().then(function(response){
        //         $rootScope.autenticado = response;
        //     });
        // }
       
    };
})
.controller('adminLogout', function($scope, $rootScope, $location, AdminServicoAutenticacao){
    $scope.logout = function() {
        AdminServicoAutenticacao.logout().resultado('/api/admin/logout').then(function(response) {
            sessionStorage.removeItem('token');
            $rootScope.$broadcast('logout');
            $location.path('/admin');
        });
    };

})
.controller('adminNav', function($scope, $rootScope, $location, AdminServicoGenerico, AdminServicoAutenticacao) {
    
    $scope.autenticado = AdminServicoAutenticacao.verificar().then(function(response) {
        $scope.autenticado = response;
    });

    $rootScope.$on('utilizadorAutenticado', function() {
        $scope.autenticado = true;
    });

    $rootScope.$on('logout', function() {
        $scope.autenticado = false;
    });
    
})
.controller('adminHome', function($scope, AdminServicoAutenticacao) {
    
})
 .controller('adminUtilizadores', function($scope, $http, $location, $routeParams,   $anchorScroll, AdminServicoGenerico, AdminServicoAutenticacao) {

    $scope.cargos = AdminServicoGenerico.get().resultado('/api/admin/cargos', null).then(function(response) {
        $scope.cargos = response.data.cargos;
    });
    
    $scope.utilizadores = AdminServicoGenerico.get().resultado('/api/admin/utilizadores', null).then(function(response) {
            $scope.utilizadores = response.data.utilizadores;
    });

    $scope.utilizador = AdminServicoGenerico.get().resultado('/api/admin/utilizador/', $routeParams.id).then(function(response) {
        $scope.utilizador = response.data.utilizador;
    });

    $scope.criarUtilizador = function() {
        AdminServicoGenerico.criar().resultado('/api/admin/utilizadores/criar', $scope.utilizador, false).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };
    
    $scope.editarUtilizador = function() {
        AdminServicoGenerico.editar().resultado('api/admin/utilizadores/editar', $routeParams, $scope.utilizador, false).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };

    $scope.apagarUtilizador = function() {
        AdminServicoGenerico.apagar().resultado('/api/admin/utilizadores/apagar', $routeParams.id, $scope.utilizador).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };
})
.controller('adminCargos', function($scope, $http, $routeParams,   $anchorScroll, AdminServicoGenerico) {

    $scope.cargos = AdminServicoGenerico.get().resultado('/api/admin/cargos', null).then(function(response) {
            $scope.cargos = response.data.cargos;
    });

    
    $scope.cargo = AdminServicoGenerico.get().resultado('/api/admin/cargo', $routeParams.id).then(function(response) {
        $scope.cargo = response.data.cargo;
    });

    $scope.criarCargo = function() {
        AdminServicoGenerico.criar().resultado('/api/admin/cargos/criar', $scope.cargo, false).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };
    
    $scope.editarCargo = function() {
        AdminServicoGenerico.editar().resultado('api/admin/cargos/editar', $routeParams.id, $scope.cargo, false).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };

    $scope.apagarCargo = function() {
        AdminServicoGenerico.apagar().resultado('/api/admin/cargos/apagar', $routeParams.id, $scope.cargo).then(function(response) {
            $scope.mensagem = response.data.mensagem;
            $scope.erros = response.data.erro;
            $anchorScroll(); 
        });
    };
});



