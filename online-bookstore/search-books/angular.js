var app = angular.module("myapp", [])
app.controller("mycontroller", function($scope, $http){
    $scope.isArray = angular.isArray;
    $scope.showresultcount = false;
    $scope.showloading = false;
    $scope.error = false;
    $scope.search = function(){
        $scope.showloading = true;
        $scope.showresultcount = false;
        $scope.showresult = false;
        $scope.error = false;
        $http.post(
            "search-result.php",
            {'title':$scope.title}
        ).then(function(data){
            console.log(data);
            $scope.showloading = false;
            $scope.showresultcount = (data.data.item.length);
            $scope.showresult = true;
            $scope.results = data.data.item;
            $scope.error = !(data.data.item.length);
        })
    }
});