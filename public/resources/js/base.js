;(function () {
    'use strict';

    window.his={
        id:parseInt($('html').attr('user_id'))
    };
    window.helper={};
    helper.obj_length=function (obj) {
        if(obj)
            return Object.keys(obj).length;
    }

    angular.module('mihu',[
        'ui.router',
        'user',
        'question',
        'answer',
        'common'
    ])
        .config(function ($interpolateProvider,
                          $stateProvider,
                          $urlRouterProvider) {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home')

            $stateProvider
                .state('home',{
                    url:'/home',
                    templateUrl:'tpl/page/home'
                })
                .state('login',{
                    url:'/login',
                    templateUrl:'tpl/page/login'
                })
                .state('signup',{
                    url:'/signup',
                    templateUrl:'tpl/page/signup'
                })
                .state('question',{
                    abstract:true,
                    url:'/question',
                    template:'<div ui-view></div>',
                    controller:'QuestionController'
                })
                .state('question.add',{
                    url:'/add',
                    templateUrl:'tpl/page/question_add'
                })
                .state('question.detail',{
                    url:'/detail/:id?answer_id',
                    templateUrl:'tpl/page/question_detail'
                })
                .state('user',{
                    url:'/user/:id',
                    templateUrl:'tpl/page/user'
                })
        })
        .controller('BaseController',function ($scope) {
            $scope.his=his;
            $scope.helper=helper;

        })
})();