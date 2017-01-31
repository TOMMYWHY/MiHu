/**
 * Created by Tommy on 16/12/23.
 */
;(function () {
    'use strict';
    angular.module('common',[])
        .service('TimelineService',function ($http,AnswerService) {
            var me=this;
            me.data=[];
            me.current_page=1;
            me.no_more_data=false;
            me.get=function (conf) {
                if(me.pending ||  me.no_more_data)return;
                me.pending=true;
                conf=conf||{page:me.current_page}

                $http.post('/api/timeline',conf)
                    .then(function (r) {
                        // console.log(r.data);
                        if(r.data.status){
                            if(r.data.data.length){
                                me.data=me.data.concat(r.data.data);
                                me.data=AnswerService.count_vote(me.data);
                                me.current_page++;
                            }else{
                                me.no_more_data=true;
                            }
                        }else{
                            console.error('network error');
                            console.log('r',r);
                        }
                        me.pending=false;
                    },function (e) {
                        me.pending=false;
                        console.log('e',e);
                    })
            }

            me.vote=function (conf) {
                var $r =AnswerService.vote(conf);
                if($r)
                    $r .then(function (r) {
                        if(r){
                            AnswerService.update_data(conf.id);
                        }
                    },function (e) {
                        console.log('e',e)
                    })
            }

            me.reset_state=function () {
                me.data=[];
                me.current_page=1;
                me.no_more_data=false;
            }
        })
        .controller('HomeController',function ($scope, TimelineService,AnswerService) {
            $scope.Timeline=TimelineService;
            // TimelineService.data=[];
            // TimelineService.current_page=1;
            // TimelineService.no_more_data=false;
            TimelineService.reset_state();
            TimelineService.get();

            var $win=$(window);
            $win.on('scroll',function () {
                if($win.scrollTop()-($(document).height()-$win.height())>-30){
                    TimelineService.get();
                }
            })

            $scope.$watch(function () {
                // console.log(AnswerService.data);
                return AnswerService.data;
            },function (new_data,old_data) {

                var timeline_data=TimelineService.data;
                for(var k in new_data){
                    // console.log('new_data[k]',new_data[k]);
                    for(var i=0; i<timeline_data.length;i++){
                        if(k==timeline_data[i].id){
                            timeline_data[i]=new_data[k];
                        }
                    }
                }
                TimelineService.data=AnswerService.count_vote( TimelineService.data);
            },true)
        })


})();