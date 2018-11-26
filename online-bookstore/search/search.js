var app = angular.module('probook', []);

var sr = document.getElementsByClassName('search-result')[0];

app.controller('probook-ctrl', function($scope) {

    $scope.searchBooks = function() {
      if (!$scope.searchInput) {
        alert('Cannot submit empty input');
      } else {
        alert('You searched ' + $scope.searchInput);
        sr.style.display = 'flex';
      }
    };

});