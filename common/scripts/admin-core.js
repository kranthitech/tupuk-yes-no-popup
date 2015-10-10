angular.module("tupukAdmin", ["ui.bootstrap", "ngAnimate", "base64", "formly", "formlyBootstrap","toggle-switch"])

angular.module("tupukAdmin")
    .controller("tupukAdminController", ['$scope', '$http', '$base64', function($scope, $http, $base64) {

        $scope.widgetActive = tupuk_widget_active

        $scope.$watch('widgetActive',function(){
            document.getElementById('widget_active_field').checked = $scope.widgetActive
        })

        if(tupuk_widget_settings && tupuk_widget_settings.length > 0){
            $scope.settings = angular.fromJson($base64.decode(tupuk_widget_settings))
        }else{
            $scope.settings = {}
        }
        
        $scope.general = general_settings_fields

        //Watch settings, if anything changes, encode and put it in the text box
        $scope.$watch('settings', function() {
                //set the actual trigger event based in the selected value
                if ($scope.settings.general && $scope.settings.general.trigger) {
                    $scope.settings.trigger_event = 'tupuk_' + $scope.settings.general.trigger
                    if ($scope.settings.general.trigger == 'elapsed') {
                        $scope.settings.trigger_event = $scope.settings.trigger_event + '_' + $scope.settings.general.elapsed
                    }
                }

                
                document.getElementById('widget_settings_field').value = $base64.encode(angular.toJson($scope.settings))
            }, true)

            //get the config fields for the widget here
            //these are stored in config.json
        $http.get(tupuk_plugin_path + '/widget/config.json')
            .then(function(res) {
                $scope.widgetFields = res.data
            })
    }])

//Define editable directive
angular.module("tupukAdmin")
    .directive("editable", function() {
        console.log("directive is being defined")
        return {
            restrict: 'A',
            controller: function($scope, $element, $modal, $base64) {
                console.log('inside editable directive')
                $element.on('mouseover', function() {
                    $element.addClass('tupuk-highlight')
                })
                $element.on('mouseout', function() {
                    $element.removeClass('tupuk-highlight')
                })
                $element.click(function() {
                    //on clicking the element, show a modal with text input
                    var current_html = $element.html()
                    console.log(current_html)

                    var modalInstance = $modal.open({
                        animation: true,
                        templateUrl: 'editableInput.html',
                        controller: function($scope, $modalInstance) {
                            $scope.inner = current_html

                            $scope.ok = function() {
                                $modalInstance.close($scope.inner)
                            }

                            $scope.cancel = function() {
                                $modalInstance.dismiss('cancel')
                            }
                        },
                        size: 'md',
                        resolve: {
                            inner: function() {
                                return $scope.inner;
                            }
                        }
                    });

                    modalInstance.result.then(function(inner) {
                        console.log('New Inner Text- ' + inner)
                        $element.html(inner)
                        
                        //Encode the updated template and put it in the widget_template_field text box
                        var updated_template = document.getElementById("tupuk-sample-widget-container").outerHTML
                        console.log(updated_template)

                        document.getElementById("widget_template_field").value = $base64.encode(updated_template)
                    })
                })
            }
        }
    })

var general_settings_fields = [{
    key: "trigger",
    type: "radio",
    templateOptions: {
        label: "When should the Widget show up?",
        options: [{
            name: "As soon as the page loads",
            value: "page_loaded"
        }, {
            name: "When visitor scrolls to the bottom of the page",
            value: "scroll_bottom"
        }, {
            name: "When the visitor is trying to leave the page",
            value: "page_exit"
        }, {
            name: "After some time",
            value: "elapsed"
        }]
    }
}, {
    key: "elapsed",
    hideExpression: "(model.trigger != 'elapsed')",
    type: "radio",
    templateOptions: {
        label: "Specify a delay",
        options: [{
            name: "5 Seconds",
            value: 5
        }, {
            name: "10 Seconds",
            value: 10
        }, {
            name: "30 Seconds",
            value: 30
        }, {
            name: "60 Seconds",
            value: 60
        }]
    }
}]