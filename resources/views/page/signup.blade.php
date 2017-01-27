<section ng-controller="signupController">
    <div class="container ">
        <center>
            <h1>Signup</h1>
            {{--[:User.signup_data:]--}}
            <form name="signup_form" ng-submit="User.signup()">
                <div>
                    <label for="">Username</label>
                    <input type="text" name="username" ng-model="User.signup_data.username" ng-model-options="{deounce:300}"  ng-minlength="4" ng-maxlength="24" required >
                </div>
                <div ng-if="signup_form.username.$touched" class="input_error_set">
                    <div ng-if="signup_form.username.$error.required ">username is required</div>
                    <div ng-if="signup_form.username.$error.maxlength || signup_form.username.$error.minlength ">length should be 4~24</div>
                    <div ng-if="User.signup_username_exists">username is exist</div>
                </div>
                <div>
                    <label for="">Password&ensp;</label>
                    <input type="text" name="password" ng-model="User.signup_data.password" ng-minlength="6" ng-maxlength="24" required>
                </div>
                <div ng-if="signup_form.password.$touched" class="input_error_set">
                    <div ng-if="signup_form.password.$error.required">password is required</div>
                    <div ng-if="signup_form.password.$error.maxlength || signup_form.password.$error.minlength ">length should be 6~255</div>
                </div>
                <button class=" btn btn-default" type="submit" ng-disabled="signup_form.$invalid">signup</button>
            </form>
        </center>
    </div>
</section>