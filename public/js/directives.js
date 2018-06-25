app.directive('formatarValidacao', [function() {
    return {
        restrict: 'A',
        scope: {
            formatarValidacao : '='
        },
        link: function(scope, element, attrs) {
            var fraseIntrodutoria = angular.element('<p>Ocorreram os seguintes erros:</p>');
            fraseIntrodutoria.appendTo(element);
            angular.forEach(scope.formatarValidacao, function(value, key) {
                if(Array.isArray(value)) {
                    angular.forEach(value, function(subvalue) {
                        var err = angular.element('<span></span>');
                        err.html(subvalue);
                        err.appendTo(element);
                    });
                }
                else {
                    console.log(value + ' ' + key);
                    console.log(scope.formatarValidacao);
                    var erro = angular.element('<span></span>');
                    erro.html(value);
                    erro.appendTo(element);
                }
              });
        }
    };
}])
.directive("filesInput", function() {
    return {
      require: "ngModel",
      link: function postLink(scope,elem,attrs,ngModel) {
        elem.on("change", function(e) {
          var files = elem[0].files[0];
          ngModel.$setViewValue(files);
        })
      }
    }
  });