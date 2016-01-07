var myApp = angular.module('YiimineApp', ['dndLists'])
    .controller('SiteIndexCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.setModel = function() {
            $http.get('/site/get-issues-json').success(function(data) {
                $scope.models = {
                    selected: null,
                    lists: data
                };
            });
        };

        $scope.$watch('models', function(model) {
            $scope.modelAsJson = angular.toJson(model, true);
        }, true);
    }]);