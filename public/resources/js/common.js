/**
 * Created by Tommy on 16/12/23.
 */
;(function () {
    'use strict';
    angular.module('common',[])
        .service('TimelineService',function ($http) {
            var me=this;
            me.data=[];
            me.current_page=1;
            this.get=function (conf) {
                if(me.pending)return;
                me.pending=true;
                conf=conf||{page:me.current_page}

                $http.post('/api/timeline',conf)
                    .then(function (r) {
                        console.log(r.data);
                        if(r.data.status){
                            if(r.data.data.length){
                                me.data=me.data.concat(r.data.data);
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
        })
        .controller('HomeController',function ($scope, TimelineService) {
            $scope.Timeline=TimelineService;
            TimelineService.get();

            var $win=$(window);
            $win.on('scroll',function () {
                if($win.scrollTop()-($(document).height()-$win.height())>-30){
                    TimelineService.get();
                }
            })
        })


})();