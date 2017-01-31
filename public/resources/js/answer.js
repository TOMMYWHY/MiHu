/**
 * Created by Tommy on 16/12/23.
 */
;(function () {
    'use strict';
    angular.module('answer',[])
        .service('AnswerService',function ($http,$state) {
            var me = this;
            me.data={};
            me.answer_form={};
            me.count_vote=function (answers) {
                // console.log('answers',answers);

                for(var i=0;i<answers.length;i++){
                    var votes, item=answers[i];
                    // console.log('answers[i]',answers[i]);
                    console.log('item[question_id]',item['question_id'])
                    if(!item['question_id']){

                        continue;
                    }

                    me.data[item.id]=item;

                    if(!item['users'])continue;

                    item.upvote_count=0;
                    item.downvote_count=0;
                    votes=item['users'];
                    // if(votes)
                    for(var j=0;j<votes.length;j++){
                        var v=votes[j];
                        if(v['pivot'].vote===1)
                            item.upvote_count++;

                        if(v['pivot'].vote===2)
                            item.downvote_count++;
                    }
                }
                return answers;
            }

            me.vote=function (conf) {
                if(!conf.id||!conf.vote){
                    console.log('id and vote are required');
                    return;
                }

                var answer=me.data[conf.id],
                    users=answer.users;
                if(answer.user_id==his.id){
                    console.log('cant vote self answer');
                    return false;
                }

                for(var i=0; i<users.length;i++){
                    if(users[i].id==his.id && conf.vote==users[i].pivot.vote ){
                       conf.vote=3;
                    }
                }

                return $http.post('api/answer/vote',conf)
                    .then(function (r) {
                        if(r.data.status)
                            return true;
                        else if(r.data.msg=='login is required!')
                            $state.go('login');
                        else
                        return false;
                    },function (e) {
                        console.log('e',e)
                    })
            }

            me.update_data=function (id) {
                return $http.post('/api/answer/read',{id:id})
                    .then(function (r) {
                        // console.log('r',r);
                        // console.log('r.data.data_answer',r.data.data_answer);
                        me.data[id]=r.data.data_answer;
                    })
            }

            me.read=function (params) {
                return $http.post('/api/answer/read',params)
                    .then(function (r) {
                        if(r.data.status){
                            me.data=angular.merge({},me.data,r.data.data);
                            return r.data.data;
                        }
                        return false;
                    },function (e) {
                        console.log('e',e)
                    })
            }

            me.add_or_update=function (question_id) {
                //update
                // console.log('me.answer_form',me.answer_form);
                if(!question_id){
                    console.error('question_id is required!');
                    return;
                }
                me.answer_form.question_id=question_id;
                if(me.answer_form.id){
                    $http.post('/api/answer/change',me.answer_form)
                        .then(function (r) {
                            if(r.data.status){
                                me.answer_form={};
                                $state.reload();
                                console.log('change successfully!');
                            }
                        },function (e) {
                            console.log('e',e);
                        })
                }else {
                    $http.post('/api/answer/add',me.answer_form)
                        .then(function (r) {
                            if(r.data.status){
                                me.answer_form={};
                                $state.reload();
                                console.log('add successfully!');

                            }
                        },function (e) {
                            console.log('e',e);
                        })
                }
            }

            me.delete=function (id) {
                if(!id){
                    console.error('id is required!');
                    return;
                }
                $http.post('/api/answer/remove',{id:id})
                    .then(function (r) {
                        if(r.data.status){
                            console.log('delete successfully!');
                            $state.reload();
                        }
                    },function (e) {
                        console.log('e',e);
                    })

            }

            me.add_comment=function () {
                return $http.post('/api/comment/add',me.new_comment)
                    .then(function (r) {
                        console.log('r',r);
                        if(r.data.status)
                            return true;
                        return false;
                    },function (e) {
                        console.log('e',e);
                    })
            }
        })
        .directive('commentBlock',function ($http,AnswerService) {
            var o={};
            o.templateUrl='comment.tpl';
            o.scope={
                answer_id:'=answerId'
            }
            o.link=function (sco,ele,attr) {
                sco.Answer=AnswerService;
                sco._={};
                sco.data={};
                sco.helper=helper;
                sco._.add_comment= function () {
                    AnswerService.new_comment.answer_id=sco.answer_id;
                    AnswerService.add_comment()
                        .then(function (r) {
                            console.log('r',r);
                            if(r){
                                AnswerService.new_comment={};
                                get_comment_list();
                            }
                        })
                }
               // ele.on('click',function () {
                   // console.log('sco.answer_id',sco.answer_id);
                function get_comment_list() {
                   return $http.post('/api/comment/read',{answer_id:sco.answer_id})
                        .then(function (r) {
                            console.log('r',r);
                            if(r.data.status){
                                sco.data=angular.merge(sco.data,r.data.data);
                            }
                        },function (e) {
                            console.log('e',e);
                        })
                }
                
                   if(sco.answer_id){
                       get_comment_list();
                   }
               // })
            }
            return o;
        })
})();
