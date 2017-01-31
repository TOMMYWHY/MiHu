
<section ng-controller="UserController">
    <div class="container ">
        <div class="user_info">
            <div class="portrait_big">
                <img src="/resources/img/touxiang.jpg" alt="">
            </div>
            <div class="info_detail ">
                <h1>[:User.current_user.username:]</h1>
                <h3>[:User.current_user.ata.intro||'No more info':]</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row p40">
            <div class="col-md-8 col-xs-12 ">
                {{--answer--}}
                <div class="answer_box">
                    <h4>His Question</h4>
                    <hr>
                    {{--each--}}
                    <div  class="item" ng-repeat="(key,value) in User.his_questions">

                        <div class="vote_portrait">
                            <div class="portrait"><img src="/resources/img/touxiang.jpg" alt=""></div>
                        </div>
                        <div class="content " style="width: 100%">
                            <div class="item_title">[:value.title:]</div>
                            <div>description:[:value.desc:]</div>
                            <div class="bottom_common p5">Public time:[:value.updated_at:]</div>
                            <hr class="item_each_line">
                        </div>
                    </div>
                    {{--end--}}

                </div>

                {{--question--}}
                <div class="question_box">
                    <h4>His Answer</h4>
                    <hr>
                    {{--each--}}
                    <div ng-repeat="(key,value) in User.his_answers" class="item">
                        <div class="vote_portrait">
                            <div class="portrait"><img src="/resources/img/touxiang.jpg" alt=""></div>
                            <div class="vote" >
                                <button  class="btn btn-default">赞[:item.upvote_count:]</button>
                                <button  class="btn btn-default">踩[:item.downvote_count:]</button>
                            </div>
                        </div>
                        <div class="content " style="width: 100%">
                            <div class="event_header" > [:User.current_user.username:] add Answer</div>
                            <div class="item_title">Question: [:value.question.title:]</div>
                            <div class="content_main mt5">
                                <div ><p>[:value.content:]</p></div>
                            </div>
                            <div class="bottom_common p5">Public time:[:value.updated_at:]</div>
                            <div class="common_box">
                                {{--each--}}
                                <div class="common_each">
                                    <div><img src="/resources/img/touxiang.jpg" alt=""></div>
                                    <div>
                                        <div class="common_username">铁齿铜牙汉尼拔</div>
                                        <div><p>从不买华为，将来也不会买华为。好不容易由小米魅族开创的国产机新局面，绝不能让华为跟ov 开了倒车</p></div>
                                        <hr class="common_end ">
                                    </div>
                                </div>
                                {{--end--}}
                            </div>
                            <hr class="item_each_line">
                        </div>
                    </div>
                    {{--end--}}
                </div>
            </div>
            <div class="col-md-4 col-xs-12"></div>
        </div>
    </div>
{{----}}

</section>