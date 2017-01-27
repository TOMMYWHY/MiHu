<section ng-controller="QuestionAddController">
    <div class="container">
        <form name="question_add_form" ng-submit="Question.add()">
            <div>
                <label for="">Title</label>
                <input type="text" name="title" ng-model="Question.new_question.title" required minlength="5" maxlength="255">
            </div>
            <div>
                <label for="">Description</label>
                <textarea class="" name="desc" id="" cols="30" rows="10" ng-model="Question.new_question.desc"></textarea>
            </div>
            <div>
                <button ng-disabled="question_add_form.title.$invalid" class="btn btn-danger" >Submit</button>
            </div>
        </form>
    </div>
</section>