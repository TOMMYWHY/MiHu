/**
 * Created by Tommy on 16/12/23.
 */
;(function () {
    'use strict';
    angular.module('question',[])
        .service('QuestionService',function ($http,$state) {
            var me= this;
            me.new_question={};
            me.go_add_question=function () {
                $state.go('question.add')
            }
            me.add=function () {
                if(!me.new_question.title){
                    return;
                }
                $http.post('/api/question/add',me.new_question)
                    .then(function (r) {
                        // console.log('r',r);
                        if(r.data.status){
                            me.new_question={};
                            $state.go('home');
                        }
                    },function (e) {
                        console.log('e',e);
                    })
            }

        })
        .controller('QuestionAddController',function ($scope,QuestionService) {
            $scope.Question=QuestionService;
        })

})();