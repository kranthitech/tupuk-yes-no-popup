console.log('injecting dependencies')
angular.module("tupukAdmin", ["ui.bootstrap", "ngAnimate", "base64", "formly", "formlyBootstrap", "toggle-switch"])

console.log('injected')
angular.module("tupukAdmin")
    .controller("tupukAdminController", ['$scope', '$http', '$base64', '$sce', function($scope, $http, $base64, $sce) {
        //1. load scope variables from saved option variables
        $scope.widgetActive = tupuk_widget_active

        if (tupuk_widget_settings && tupuk_widget_settings.length > 0) {
            $scope.settings = angular.fromJson($base64.decode(tupuk_widget_settings))
        } else {
            $scope.settings = {}
        }

        //2. load config.json variables on to scope
        $http.get(plugin_path + '/widget/config.json')
            .then(function(res) {
                $scope.widgetFields = res.data.fields
                $scope.widgetDetails = res.data.widget
            })

        //3. setup general settings defined below, which are common for all tupuk widgets
        $scope.general = general_settings_fields

        //4. Watch for scope variable changes and save them to the options text boxes
        $scope.$watch('widgetActive', function() {
            document.getElementById('widget_active_field').checked = $scope.widgetActive
        })

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

        //5. define variables and functions that can be used within the templates
       
        $scope.plugin_path = plugin_path

        $scope.layoutTemplateUrl = function(layout) {
            return plugin_path + '/widget/layouts/' + layout + '/' + layout + '-template.php'
        }

        //6. Retrieved saved templates
        $scope.encodedTemplates = getEncodedLayoutTemplates($base64)
        $scope.layoutTemplates = {}
        for(var key in $scope.encodedTemplates){
            $scope.layoutTemplates[key] = $base64.decode($scope.encodedTemplates[key])
        }

        $scope.layoutTemplate = function(layout) {
            return $sce.trustAsHtml($base64.decode($scope.encodedTemplates[layout]))
        }
    }])

//Define editable directive
angular.module("tupukAdmin")
    .directive("editable", function() {
        console.log("directive is being defined")
        return {
            restrict: 'A',
            controller: function($scope, $element, $modal, $base64) {

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
                        console.log('container_id- ' + container_id)
                        var current_layout = $scope.settings.layout
                        var updated_template = document.getElementById(container_id).outerHTML

                        saveLayoutTemplate($scope.settings.layout, updated_template, $base64)

                    })
                })
            }
        }
    })

function getEncodedLayoutTemplates(base64Service) {
    var saved_encoded_templates = document.getElementById("widget_template_field").value
    var template_json = {}

    if (saved_encoded_templates) {
        template_json = angular.fromJson(base64Service.decode(saved_encoded_templates))
    }

    return template_json
}

function saveLayoutTemplate(layout, template, base64Service) {
    var template_json = getEncodedLayoutTemplates(base64Service)
    template_json[layout] = base64Service.encode(template)
    document.getElementById("widget_template_field").value = base64Service.encode(angular.toJson(template_json))
}

angular.module("tupukAdmin")
    .directive('bindHtmlCompile', ['$compile', function($compile) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                scope.$watch(function() {
                    return scope.$eval(attrs.bindHtmlCompile);
                }, function(value) {
                    // Incase value is a TrustedValueHolderType, sometimes it
                    // needs to be explicitly called into a string in order to
                    // get the HTML string.
                    element.html(value && value.toString());
                    // If scope is provided use it, otherwise use parent scope
                    var compileScope = scope;
                    if (attrs.bindHtmlScope) {
                        compileScope = scope.$eval(attrs.bindHtmlScope);
                    }
                    $compile(element.contents())(compileScope);
                });
            }
        };
    }]);

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