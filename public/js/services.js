app
.service('ServicoEmail', function($http) {
    return function($model) {
        return $http({
            method: 'POST',
            url: '/api/contactos',
            data: $model
        })
    }
})
.service('AdminServicoGenerico', function($http) {

    this.get = function() {
        return { 
                resultado: function($url, $id, $quantidade) {
                var dados = {};
                if($id != null) {
                    dados.id = $id;
                }
                if($quantidade != null) {
                    dados.quantidade = $quantidade;
                }
                return $http({
                    method: 'get',
                    url: $url,
                    params: dados
                });
            }
        }
    };

    this.criar = function() {
        return {
            resultado: function($url, $model, $headers) {
                var contentTypePadrao = $headers !== true ? 'application/json' : undefined;

                return $http({
                    method: 'post',
                    url: $url,
                    data: $model,
                    headers: { 'Content-Type': contentTypePadrao }
                });
            }
        }
    };

    this.editar = function() {
        return {
            resultado: function($url, $parametrosUrl, $model, $headers) {
                var contentTypePadrao = $headers !== true ? 'application/json' : undefined;
                
                return $http({
                    method: 'post',
                    url: $url,
                    params: {id: $parametrosUrl.id},
                    data: $model,
                    headers: { 'Content-Type': contentTypePadrao }
                });
            }
        }
    };

    this.apagar = function() {
        return {
            resultado: function($url, $id, $dados) {
                return $http({
                    method: 'post',
                    url: $url,
                    data: {id: $id || $dados.id}
                });
            }
        }
    };

})
.service('AdminServicoAutenticacao', function($http) {

    this.utilizador;

    this.login = function() {
        return {
            resultado: function($url, $model) {
                return $http({
                    method: 'POST',
                    url: $url,
                    data: $model
                });
            }
        }
    }; 

    this.logout = function() {
        return {
            resultado: function($url) {
                return $http({
                    method: 'GET',
                    url: $url
                });
            }
        }
    }; 
    
    this.getToken = function() {
        return sessionStorage.getItem('token');
    }

    this.estaAutenticado = function() {
        return sessionStorage.getItem('token') ? true : false;
    }

    this.getUtilizador = function() {
        return $http({
                method: 'get',
                url: '/api/admin/utilizadores/utilizadorautenticado'
            });         
    }
    

    this.verificar = function() {
        return $http({
            method: 'get',
            url: 'api/admin/utilizadores/check'
        }).then(function(response) {
            switch(response.data.estado) {
                case true:
                    autenticado = true;
                    break;
                case false:
                    autenticado = false;
            };
            console.log('a verificar');
            return autenticado;
        });
    }
});