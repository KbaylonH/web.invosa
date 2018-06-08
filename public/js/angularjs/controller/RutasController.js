var myApp = angular.module('InvosaApp',[]);

myApp.controller('RutasController', ['$scope', '$http', '$uibModal',function($scope, $http, $uibModal) {
  $scope.pageTitle = 'Rutas';
  var tpl = {
    data: [],
    searching: false,
    sparams: {
      page: 1,
      sidx: 'dialprefix',
      sord: 'asc',
      rows: 10,
      totalItems: 0
    },
    trunks: angular.copy(troncales),
    openModal: function(record){
      var instance = $uibModal.open({
        templateUrl: 'rutaModal.html',
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        controller: modalController,
        controllerAs: '$ctrl',
        appendTo: undefined,
        backdrop: 'static',
        resolve: {
          items: function(){
            return {
              trunks: $scope.trunks,
              record: record ? record : undefined
            };
          }
        }
      });

      instance.result.then(function(){}, function(){});
    },
    search: function(){
      $scope.searching = true;
      $http({
          url: '/route/search',
          method: 'GET',
          params: tpl.sparams
      }).then(function(d){
        console.log(d);
        $scope.data = d.data.rows;
        $scope.sparams.totalItems = d.data.records;
      }).catch(function(e){
        console.log(e);
      }).finally(function(){
        $scope.searching = false;
      });
    },
    filter: function(){
      tpl.sparams.page = 1;
      tpl.search();
    }
  };

  angular.extend($scope, tpl);

  tpl.search();

  function modalController($uibModalInstance, items){
    var $ctrl = this;
    $ctrl.trunks = items.trunks;
    $ctrl.params = {
      dialprefix: '',
      troncal_id: $ctrl.trunks[0].id + "",
      es_portado: '0'
    };

    if(items.record !== undefined){
      $ctrl.params.dialprefix = items.record.dialprefix;
      $ctrl.params.troncal_id = items.record.troncal_id+"";
      $ctrl.params.es_portado = items.record.es_portado_id+"";
      $ctrl.params.id = items.record.id;
    }

    $ctrl.cancel = function(){
      $uibModalInstance.dismiss('cancel');
    };

    $ctrl.ok = function(){
      $ctrl.saving = true;
      $http({
        url: '/route',
        method: 'POST',
        data: $ctrl.params
      }).then(function(d){
        $scope.search();
        toastr.success('Datos guardados');
        $ctrl.cancel();
      }).catch(function(e){
        toastr.error(e.data.error);
      }).finally(function(){
        $ctrl.saving = false;
      });
    };
  }

}]);