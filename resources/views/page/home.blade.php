
    <section ng-controller="HomeController">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h4>News</h4>
                    <hr>
                    <div class="item_box">
                        {{--each--}}
                        <div ng-repeat="item in Timeline.data track by $index" class="item">
                            <div class="vote_portrait">
                                <div class="portrait"><img src="/resources/img/default.jpg" alt=""></div>
                                <div class="vote" ng-if="item.question_id">
                                    <button ng-click="Timeline.vote({id:item.id,vote:1})" class="btn btn-default">赞[:item.upvote_count:]</button>
                                    <button ng-click="Timeline.vote({id:item.id,vote:2})" class="btn btn-default">踩[:item.downvote_count:]</button>
                                </div>
                                {{--<div class="vote"  >--}}
                                    {{--<button  ng-click="Timeline.vote({id:item.id,vote:1})" class="btn btn-default">赞[:item.upvote_count:]</button>--}}
                                    {{--<button  ng-click="Timeline.vote({id:item.id,vote:2})" class="btn btn-default">踩[:item.downvote_count:]</button>--}}
                                {{--</div>--}}


                            </div>
                            <div class="content " style="width: 100%">
                                <div class="event_header" ng-if="item.question_id"><a ui-sref="user({id:item.user.id})">[:item.user.username:]</a> add Answer</div>
                                <div class="event_header" ng-if="!item.question_id"><a ui-sref="user({id:item.user.id})"> [:item.user.username:]</a> add Question</div>
                                <div class="item_title" g-if="item.question_id" ui-sref="question.detail({id:item.question.id})">[:item.question.title:]</div>
                                <div class="item_title" ui-sref="question.detail({id:item.id})" >[:item.title:]</div>
                                <div class="author">Username: [:item.user.username:]</div>
                                <div class="content_main mt5">
                                    <div><img src="/resources/img/demo.jpg" alt=""></div>
                                    {{--<div ng-if="!item.question_id"><p>[:item.desc:]</p></div>--}}
                                    <div ng-if="item.question_id" ui-sref="question.detail({id:item.question_id,answer_id:item.id})"><a>[:item.content:]</a>
                                        <div class="author">[:item.updated_at:]</div>
                                    </div>
                                </div>
                                <div class="bottom_common p5" ng-if="item.question_id">
                                    <span ng-click="item.show_comment=!item.show_comment">
                                        <span ng-if="item.show_comment">hidden</span>
                                        comment
                                    </span>
                                </div>
                                {{--comment--}}

                                <div ng-if="item.show_comment" comment-block answer-id="item.id"></div>




                                {{--</div>--}}
                                <hr class="item_each_line">


                            </div>
                        </div>
                        {{--end--}}

                    </div>
                    <div ng-if="Timeline.no_more_data" class="text-center">
                        No more data!!!
                    </div>
                    <div ng-if="Timeline.pending" class="text-center">
                        Loading....
                    </div>
                </div>

                {{--aside--}}
                <div  class="col-md-4 h100 ">
                    <h3> Project:MiHu <br></h3>
                    <h3> Author:Tommy <br></h3>
                    <h4>CV:&nbsp;&nbsp;	&nbsp;		&nbsp;	&nbsp;	&nbsp;	 <a target="_blank" href="http://tommycv.cf/">http://tommycv.cf</a>
                    <h4>Portfolio: <a target="_blank" href="http://www.tommywhy.ml.s3-website-ap-southeast-2.amazonaws.com/">http://tommy.cf</a>
                   </h4>
                </div>
            </div>
        </div>
    </section>
