
    <section ng-controller="HomeController">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h4>News</h4>
                    <hr>
                    <div class="item_box">
                        {{--each--}}
                        <div ng-repeat="item in Timeline.data" class="item">
                            <div class="vote_portrait">
                                <div class="portrait"><img src="/resources/img/touxiang.jpg" alt=""></div>
                                <div class="vote">
                                    <button class="btn btn-default">ding</button>
                                    <button class="btn btn-default">cai</button>
                                </div>
                            </div>
                            <div class="content ">
                                <div class="event_header" ng-if="item.question_id"> [:item.user.username:] add Answer</div>
                                <div class="event_header" ng-if="!item.question_id"> [:item.user.username:] add Qusetion</div>
                                <div class="item_title">[:item.title:]</div>
                                <div class="author">Username: [:item.user.username:]</div>
                                <div class="content_main mt5">
                                    <div><img src="/resources/img/demo.jpg" alt=""></div>
                                    <div><p>[:item.desc:]</p></div>
                                </div>
                                <div class="bottom_common p5">关注问题 收起评论 感谢 分享 收藏 • 没有帮助 • 举报 • 禁止转载
                                </div>
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
                    <div ng-if="Timeline.no_more_data" class="text-center">
                        No more data!!!
                    </div>
                    <div ng-if="Timeline.pending" class="text-center">
                        Loading....
                    </div>
                </div>

                {{--aside--}}
                <div  class="col-md-4 h100 pink"></div>
            </div>
        </div>
    </section>
