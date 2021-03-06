<?php
if(!(isset($_SERVER['PHP_AUTH_USER']) &&
    $_SERVER['PHP_AUTH_USER'] == 'lucca' &&
    isset($_SERVER['PHP_AUTH_PW']) &&
    $_SERVER['PHP_AUTH_PW'] == "lucca")) {
//    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
//    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="luccaAdminApp">
<head>
    <meta charset="UTF-8">
    <title>Lucca`s guide: manage content</title>

    <link rel="stylesheet" type="text/css" href="media/Sass/admin_area.css">

    <!--Vendors START-->
    <script src="scripts/vendors/jquery-2.1.4.min.js"></script>
    <script src="scripts/vendors/angular.min.js"></script>
    <script src="scripts/vendors/angular-resource.min.js"></script>
    <script src="scripts/vendors/angular-route.min.js"></script>
    <script src="scripts/vendors/angular-messages.min.js"></script>
    <script src="scripts/vendors/moment.min.js"></script>
    <!--Vendors END-->

    <script src="scripts/sharedFunctionalityModule.js"></script>
    <script src="scripts/luccaAdminApplication.js"></script>
    <script src="scripts/controllers/dashboardCtrl.js"></script>
    <script src="scripts/controllers/manageItemCtrl.js"></script>
    <script src="scripts/controllers/manageCategoryCtrl.js"></script>

    <script src="scripts/directives/editItemFormDrct.js"></script>
    <script src="scripts/directives/editCategoryFormDrct.js"></script>

    <script src="scripts/services/getDataFromResourceSvc.js"></script>
    <script src="scripts/services/CategoriesTasksSvc.js"></script>

    <script src="scripts/routesAdmin.js"></script>


    <!--angular material and it`s dependencies-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/0.11.4/angular-material.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.11.4/angular-material.min.js"></script>

</head>
<body >
    <header>
        <a href="#/"><h1>The Wanderer`s Guide to Lucca</h1></a>
    </header>
    <div layout="row" class="dashboard main-wrapper" ng-controller="dashboardController as dashboardCtrl">
        <nav id="main-menu">
            <ul layout="column" id="main-categories" ng-click="clearMessage()">
                <li flex class="add-new-item">
                    <a flex href="#add-new-item">
                        <md-button flex class="md-raised md-cornered">
                            Add New Item
                        </md-button>
                    </a>
                </li>
                <li flex class="add-new-category">
                    <a flex href="#add-new-category">
                        <md-button flex class="md-raised md-cornered">
                            Add New Category
                        </md-button>
                    </a>
                </li>
                <li flex>
                    <md-button flex class="md-raised md-cornered" ng-click="menuToggleFlags['categoriesMenu'] = !menuToggleFlags['categoriesMenu']">
                        Categories
                    </md-button>
                    <ul class="sub-menu sub-category-items" ng-show="menuToggleFlags['categoriesMenu']">
                    <!--<li ng-repeat="item in category.items" id="item-{{item.item_id}}">-->
                        <li ng-repeat="category in categories">
                            <a href="#category/{{category.cat_id}}">
                                <md-button class=" md-cornered">{{category.categoryName}}</md-button>
                            </a>
                        </li>
                    </ul>

                </li>
                <li flex ng-repeat="category in categories" id="{{category.categoryName.toLowerCase()}}">

                    <a flex href="#subcategory/{{category.idName}}" ng-click="getItemsForCategory(category.idName)">
                        <md-button ng-disabled="category.idName !='churches'" flex class="md-raised md-cornered">
                            {{category.categoryName}}
                        </md-button>
                    </a>
                    <ul class="sub-menu sub-category-items"
                            ng-show="menuToggleFlags[category.idName]">
                        <li ng-repeat="item in category.items"
                            id="item-{{item.item_id}}">
                            <a href="#item/{{item.item_id}}">
                                <md-button class=" md-cornered">{{item.mainTitle}}</md-button>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div ng-view id="edit">
        </div>
    </div>
</body>
</html>