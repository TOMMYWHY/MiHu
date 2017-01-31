<section ng-controller="QuestionAddController">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form name="question_add_form" ng-submit="Question.add()">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input class="form-control" type="text" name="title" ng-model="Question.new_question.title" required minlength="5" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="desc" id="" cols="30" rows="10" ng-model="Question.new_question.desc"></textarea>
                    </div>
                    <div>
                        <button ng-disabled="question_add_form.title.$invalid" class="btn btn-danger" >Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
</section>