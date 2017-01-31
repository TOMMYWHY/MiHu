<section ng-controller="QuestionDetailController">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                {{--question--}}
                <div class="question_box ml50">
                    <p class="question_title">
                        [:Question.current_question.title:]
                        <span class="author" ng-click="Question.show_update_form=!Question.show_update_form" ng-if="his.id==Question.current_question.user_id"><span ng-if="Question.show_update_form">Hid</span> Edit Question</span>
                    </p>
                    <p>[:Question.current_question.desc:]</p>
                    <div class="author">answer account:[:Question.current_question.answers_with_user_info.length:]</div>
                    {{--edit question form--}}
                    <form ng-if="Question.show_update_form" name="question_add_form" ng-submit="Question.update()">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input class="form-control" type="text" name="title" ng-model="Question.current_question.title" required minlength="5" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" name="desc" id="" cols="10" rows="3" ng-model="Question.current_question.desc"></textarea>
                        </div>
                        <div>
                            <button ng-disabled="question_add_form.title.$invalid" class="btn btn-danger" >Submit</button>
                        </div>
                    </form>
                    {{--edit question form end--}}
                    <hr>
                </div>
                {{--answer--}}
                <div class="answer_vote_box">
                    <div ng-if="!helper.obj_length(Question.current_question.answers_with_user_info)">
                        <p class="text-center author">No answer yet,please answer it!</p>
                    </div>
                    {{--each--}}
                    <div class="answer_each"  ng-if="!Question.current_answer_id ||Question.current_answer_id== item.id" ng-repeat="item in Question.current_question.answers_with_user_info">
                        <div class="vote_box mr15">
                            <div class="vote"  >
                                <button  ng-click="Question.vote({id:item.id,vote:1})" class="btn btn-default">赞[:item.upvote_count:]</button>
                                <button  ng-click="Question.vote({id:item.id,vote:2})" class="btn btn-default">踩[:item.downvote_count:]</button>
                            </div>
                        </div>
                        <div class="answer_box ">
                            <div class="user">
                                <span ui-sref="user({id:item.user.id})" class="cursor">
                                 username:[:item.user.username:]
                                </span>
                            </div>
                            <div class="" ng-if="item.question_id" ui-sref="question.detail({id:item.current_question.id,answer_id:item.id})">
                                <p class="cursor mt5 mb10 ">[:item.content:]</p>
                            </div>
                            <span ng-click="item.show_comment=!item.show_comment">
                                <span ng-if="item.show_comment">hidden</span>
                                comment
                            </span>
                            {{--comment--}}

                               <div ng-if="item.show_comment" comment-block answer-id="item.id"></div>

                            {{--comment end--}}
                            <span ng-if="item.user_id==his.id">
                                <span class="cursor" ng-click="Answer.answer_form=item" >Edit</span>&nbsp;
                                <span class="cursor" ng-click="Answer.delete(item.id)" >Delete</span>&nbsp;
                            </span>
                            <span class="author">[:item.updated_at:]</span>
                            <hr>
                        </div>

                    </div>
                    {{--each--}}
                    {{--form--}}
                    <div class="add_answer">
                        <form name="answer_form" ng-submit="Answer.add_or_update(Question.current_question.id)">
                            <div class="form-group">
                                 <textarea name="content" ng-minlength="5"
                                           ng-model="Answer.answer_form.content"
                                           class="form-control" rows="9" cols="25" required="required" placeholder="Add answer..."></textarea>
                            </div>
                            <button  ng-disabled="answer_form.$invalid" class="btn btn-danger">Submit</button>
                        </form>
                    </div>
                </div>


            </div>
            <div class="col-md-4">advertisement</div>
        </div>
    </div>







    {{--<div class="container">--}}
        {{--question detail--}}
        {{--<div>[:Question.current_question.title:]</div>--}}
        {{--<div>[:Question.current_question.desc:]</div>--}}
        {{--<div>answer account:[:Question.current_question.answers_with_user_info.length:]</div>--}}
        {{--<div ng-if="!Question.current_answer_id ||Question.current_answer_id== item.id" ng-repeat="item in Question.current_question.answers_with_user_info">--}}
            {{--<div >--}}
                {{--<span ui-sref="user({id:item.user.id})">--}}
                    {{--username:[:item.user.username:]--}}
                {{--</span>--}}
            {{--</div>--}}
            {{--<div ng-if="item.question_id" ui-sref="question.detail({id:item.current_question.id,answer_id:item.id})">--}}
                {{--<a>[:item.content:]</a>--}}
                {{--<div class="author">[:item.updated_at:]</div>--}}
            {{--</div>--}}
            {{--<div>[:item.content:]</div>--}}
            {{--<div class="vote" >--}}
                {{--<button ng-click="Question.vote({id:item.id,vote:1})" class="btn btn-default">赞[:item.upvote_count:]</button>--}}
                {{--<button ng-click="Question.vote({id:item.id,vote:2})" class="btn btn-default">踩[:item.downvote_count:]</button>--}}
            {{--</div>--}}
            {{--<hr>--}}
        {{--</div>--}}

    {{--</div>--}}
</section>