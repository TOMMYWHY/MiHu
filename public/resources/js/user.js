/**
 * Created by Tommy on 16/12/23.
 */
;(function () {
    'use strict';
    angular.module('user',['answer','question'])
        .service('UserService',function ($http,$state) {
            var me = this;
            me.signup_data={};
            me.login_data={};
            me.data={};
            me.signup=function () {
                $http.post('/api/signup',me.signup_data)
                    .then(function (r) {
                        // console.log('r',r);
                        if(r.data.status){
                            me.signup_data={};
                            $state.go('login');
                        }
                    },function (e) {
                        console.log('e',e);
                    })
            }
            //检查用户是否存在
            me.username_exists=function () {
                $http.post('/api/user/exists',{username:me.signup_data.username})
                    .then(function (r) {
                        if(r.data.status && r.data.data.count){
                            me.signup_username_exists=true;
                        }else{
                            me.signup_username_exists=false;
                        }
                    },function (e) {
                        console.log('e',e);
                    })
            }
            me.login=function () {
                $http.post('/api/login',me.login_data)
                    .then(function (r) {
                        // console.log(111);
                        if(r.data.status){
                            // $state.go('home');
                            location.href='/';
                        }else{
                            me.login_failed=true;
                        }
                    },function (e) {
                        console.log('e',e);
                    })

            }
            me.read=function (param) {
                return $http.post('/api/user/read',param)
                    .then(function (r) {
                        // console.log('param',param);
                        // console.log('r.data.data',r.data.data);
                        if(r.data.status) {
                            me.current_user=r.data.data;
                            me.data[param.id]= r.data.data;
                        }else{
                          if(r.data.msg=='login required'){
                              $state.go('login');
                          }
                        }
                    },function (e) {
                        console.log('e',e)
                    })
            }
        })
        .controller('signupController',function ($scope,UserService) {
            $scope.User=UserService;
            $scope.$watch(function () {
                return UserService.signup_data;
            },function (n,o) {
                if(n.username!=o.username){
                    return UserService.username_exists();
                }
            },true);

        })
        .controller('LoginController',function ($scope,UserService) {
            $scope.User=UserService;
        })
        .controller('UserController',function ($scope,$stateParams,UserService,AnswerService,QuestionService) {
            $scope.User=UserService;
            console.log('$stateParams',$stateParams)
            UserService.read($stateParams);

            AnswerService.read({user_id:$stateParams.id})
                .then(function (r) {
                    if(r){
                        UserService.his_answers=r;      
                    }
                },function (e) {
                  console.log('e',e)
                })
            QuestionService.read({user_id:$stateParams.id})
                .then(function (r) {
                    if(r){
                        UserService.his_questions=r;
                    }
                },function (e) {
                    console.log('e',e)
                })
        })
    
})();