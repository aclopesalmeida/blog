    /// <reference path="angular/angular.js" />
    /// <reference path="angular-route/angular-route.js" />
    /// <reference path="controllers.js" />
    /// <reference path="services.js" />

    var app = angular.module("blog", ["ngRoute", "ngMessages", "ngAnimate", 'ui.bootstrap', 'ui.tinymce', 'ngSanitize']);
    
        app.config(function($routeProvider, $locationProvider, $httpProvider) {
                $httpProvider.interceptors.push(function($injector) {
                    return  { 
                        'request' : function (config) {
                            var serv = $injector.get('AdminServicoAutenticacao');
                            config.headers['Authorization'] = 'Bearer ' + serv.getToken();
                        
                        return config;
                        }
                    };
                });

                $httpProvider.interceptors.push(function($injector, $location) {
                    return  { 
                        responseError: function (rejection) {
                            if (rejection.status == 401) {
                               $location.path('/admin');
                            }
                            return rejection;
                        }
                    };
                });
    
                $routeProvider.caseInsensitiveMatch = true;
    
                $routeProvider
                    .when('/', {
                        templateUrl: 'partials/blog.html',
                        controller: 'posts'
                    })
                    .when('/categorias/:nome/:id', {
                        templateUrl: 'partials/postsCategoria.html',
                        controller: 'categoria'
                    })
                    .when('/blog', {
                        templateUrl: 'partials/blog.html',
                        controller: 'posts'
                    })
                    .when('/posts/:nome/:id', {
                        templateUrl: 'partials/post.html',
                        controller: 'post'
                    })
                    .when('/contactos', {
                        templateUrl: 'partials/contactos.html',
                        controller: 'contactos'
                    })
                    .when('/admin', {
                        templateUrl: 'partials/admin/login.html',
                        controller: 'adminLogin',
                        resolve: {
                            autenticado: function($rootScope, $q, $location, AdminServicoAutenticacao) {
                                AdminServicoAutenticacao.verificar().then(function(response) {
                                    $rootScope.autenticado = response;
                                    if($rootScope.autenticado === false) {
                                        return $q.resolve();
                                    }
                                    else {
                                        $location.path('/admin/home');
                                        return $q.reject();
                                    }
                                });
                            }
                      }
                    })
                    .when('/admin/home', {
                        templateUrl: 'partials/admin/home.html',
                        controller: 'adminHome',
                        autenticacao: true
                    })
                    .when('/admin/posts', {
                        templateUrl: 'partials/admin/posts/listagem.html',
                        controller: 'adminPosts',
                        autenticacao: true
                    })
                    .when('/admin/posts/criar', {
                        templateUrl: '/partials/admin/posts/criar.html',
                        controller: 'adminPosts',
                        autenticacao: true
                    })  
                    .when('/admin/posts/apagar/:id', {
                        templateUrl: 'partials/admin/posts/apagar.html',
                        controller: 'adminPosts',
                        autenticacao: true
                    })
                    .when('/admin/posts/editar/:nome/:id', {
                        templateUrl: 'partials/admin/posts/editar.html',
                        controller: 'adminPosts',
                        autenticacao: true
                    })
                    .when('/admin/posts/:nome/:id', {
                        templateUrl: 'partials/admin/posts/ver.html',
                        controller: 'adminPosts',
                        autenticacao: true
                    })
                    .when('/admin/categorias', {
                        templateUrl: 'partials/admin/categorias/listagem.html',
                        controller: 'adminCategorias',
                        autenticacao: true
                    })
                    .when('/admin/categorias/criar', {
                        templateUrl: 'partials/admin/categorias/criar.html',
                        controller: 'adminCategorias',
                        autenticacao: true
                    })
                    .when('/admin/utilizadores', {
                        templateUrl: 'partials/admin/utilizadores/listagem.html',
                        controller: 'adminUtilizadores',
                        autenticacao: true,
                        resolve: {
                            permissao: function(AdminServicoAutenticacao, $q, $location) {
                                $utilizador = AdminServicoAutenticacao.getUtilizador().then(function(response) {
                                    $utilizador = response.data.utilizador;
                            
                                    if($utilizador.cargo.designacao == 'Administrador') {
                                        return $q.resolve();
                                    }
                                    else {
                                        $location.path('/admin');
                                        return $q.reject();
                                    }
                                });
                            }
                        }
                    })
                    .when('/admin/utilizadores/criar', {
                        templateUrl: 'partials/admin/utilizadores/criar.html',
                        controller: 'adminUtilizadores',
                        autenticacao: true
                    })
                    .when('/admin/utilizadores/editar/:id', {
                        templateUrl: '/partials/admin/utilizadores/editar.html',
                        controller: 'adminUtilizadores',
                        autenticacao: true
                    })
                    .when('/admin/utilizadores/apagar/:id', {
                        templateUrl: '/partials/admin/utilizadores/apagar.html',
                        controller: 'adminUtilizadores',
                        autenticacao: true
                    })
                    .when('/admin/cargos', {
                        templateUrl: 'partials/admin/roles/listagem.html',
                        controller: 'adminCargos',
                        autenticacao: true,
                        resolve: {
                            permissao: function(AdminServicoAutenticacao, $q, $location) {
                                $utilizador = AdminServicoAutenticacao.getUtilizador().then(function(response) {
                                    $utilizador = response.data.utilizador;
                            
                                    if($utilizador.cargo.designacao == 'Administrador') {
                                        return $q.resolve();
                                    }
                                    else {
                                        $location.path('/admin');
                                        return $q.reject();
                                    }
                                });
                            }
                        }
                    })
                    .when('/admin/cargos/criar', {
                        templateUrl: 'partials/admin/roles/criar.html',
                        controller: 'adminCargos',
                        autenticacao: true
                    })
                    .when('/admin/cargos/apagar/:id', {
                        templateUrl: 'partials/admin/roles/apagar.html',
                        controller: 'adminCargos',
                        autenticacao: true,
                        resolve: {
                            permissao: function(AdminServicoAutenticacao, $q, $location) {
                                $utilizador = AdminServicoAutenticacao.getUtilizador().then(function(response) {
                                    $utilizador = response.data.utilizador;
                                })
                                if($utilizador != null) {
                                    return $q.resolve();
                                }
                                else {
                                    $location.path('/admin');
                                    return $q.reject();
                                }
                            }
                        }
                    })
                    .when('/admin/cargos/editar/:id', {
                        templateUrl: 'partials/admin/roles/editar.html',
                        controller: 'adminCargos',
                        autenticacao: true,
                        resolve: {
                            permissao: function(AdminServicoAutenticacao, $q, $location) {
                                $utilizador = AdminServicoAutenticacao.getUtilizador().then(function(response) {
                                    $utilizador = response.data.utilizador;
                                })
                                if($utilizador != null) {
                                    return $q.resolve();
                                }
                                else {
                                    $location.path('/admin');
                                    return $q.reject();
                                }
                            }
                        }
                    })
                    .otherwise({
                        redirectTo: '/'
                    });
    
                    $locationProvider.html5Mode(true);
            })
            .run(function($rootScope, $location, AdminServicoAutenticacao) {
    
                $rootScope.$on('$routeChangeStart', function (event, next, current) {
                    // !next.$$route.originalPath == '/admin'
                    if(next.$$route.autenticacao) {
                        if (!AdminServicoAutenticacao.estaAutenticado()) {
                            event.preventDefault();
                            $location.path('/admin');
                        }
                    }
                });
    
                // $rootScope.$on('$routeChangeStart', function(event, next, current) {
                //     if(next.autenticacao == true) {
                //         autenticado = AdminServicoAutenticacao.verificar().then(function(response) {
                //             autenticado = true;
                //             if(autenticado == false) {
                //                 window.location.href = '/admin';
                //             }
                //         });
                //     }
                //     else {
                //         return;
                //         window.location.href= next.$$route.originalPath;
                //     }
                // })
                
    
                // $rootScope.$on('$locationChangeStart', function(event, next, current) {
                //     var autenticado;
                //     event.preventDefault();
    
                //     if(next.autenticacao) {
                //         autenticado = AdminServicoAutenticacao.verificar().then(function(response) {
                //             autenticado = true;
                //             if(autenticado == true) {
                //                 $location.path(next);
                //                 alert('jjj');
                //             }
                //             else {
                //                 alert('h');
                //                 $location.path('/admin');
                //             }
                //     });
                //     }
                // })
        });
    