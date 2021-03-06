/**
 * Created by Lula on 11/13/2015.
 */
angular.module('luccaAdminApp').controller('manageCategoryController', function($http,$rootScope, $scope, GetData,$routeParams, CategoriesTasks){
    var categoryId = $routeParams.param;
    const CAT_RESOURCE_PATH = 'server/resources/categories.php';
    const MESSAGE_DOM_WRAPER_ERROR = "#edit-category-wrapper";
    $scope.param = 'categories';
    $scope.itemDataModel;
    //console.log('manage categorie controlles');
    function createIdName(name){
        var idName = name.toLowerCase();
        idName = idName.replace(/\s/g, "");
        return idName;
    }

    if(categoryId){
        //edit existing category
        $scope.categoryDataModel = GetData.returnedData.getObject({res:$scope.param, id:categoryId}).$promise.then(function(data){
            $scope.categoryDataModel = data.response[0];
        });
    }
    else{
        //create new category
        $scope.categoryDataModel = {};
    }

    //submit new category
    $scope.createCategory = function(categoryData){
        categoryData.idName = createIdName(categoryData.categoryName);

        $http.post(CAT_RESOURCE_PATH, categoryData).
            then(function(response) {
                // this callback will be called asynchronously
                // when the response is available

                //update categories object manually
                $rootScope.categories.push($scope.categoryDataModel);

                //tell that new category created
                $rootScope.$broadcast('created', response.data);

                $scope.submitSuccess($scope.categoryDataModel, $scope.categoryForm, response.data);
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                $(MESSAGE_DOM_WRAPER_ERROR).prepend(response.data);
            });
    };

    $scope.updateCategory = function(categoryData){
        categoryData.cat_id = categoryId;
        categoryData.idName = createIdName(categoryData.categoryName);

        $http.put(CAT_RESOURCE_PATH, categoryData).
            then(function(response) {
                // this callback will be called asynchronously
                // when the response is available

                //update categories object manually
                var categoryIndex = CategoriesTasks.findByPropertyAndReturnRef('cat_id',categoryData.cat_id );
                $rootScope.categories[categoryIndex].categoryName = categoryData.categoryName;
                $rootScope.categories[categoryIndex].idName = categoryData.idName;
                //console.log(' $rootScope.categories');
                //console.log($rootScope.categories);

                $scope.submitSuccess($scope.categoryDataModel, $scope.categoryForm, response.data);
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                $(MESSAGE_DOM_WRAPER_ERROR).prepend(response.data);
            });
    };
    $scope.deleteCategory = function(){
        $http.delete(CAT_RESOURCE_PATH+'?id='+categoryId).
            then(function(response) {
                // this callback will be called asynchronously
                // when the response is available

                //update categories object manually
                var categoryIndex = CategoriesTasks.findByPropertyAndReturnRef('cat_id',categoryId);
                $rootScope.categories.splice(categoryIndex, 1);

                $scope.submitSuccess($scope.categoryDataModel, $scope.categoryForm, response.data);
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                $(MESSAGE_DOM_WRAPER_ERROR).text(response.data);
            });
    };
});