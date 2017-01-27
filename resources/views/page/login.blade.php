<section ng-controller="LoginController">
    <center>
        <h1>Login</h1>
        <form name="login_form" ng-submit="User.login()">
            <div>
                <label for="">Username</label>
                <input type="text" name="username" ng-model="User.login_data.username" required >
            </div>
            <div>
                <label for="">Password&ensp;</label>
                <input type="text" name="password" ng-model="User.login_data.password" required >
            </div>
            <div ng-if="User.login_failed" class="input_error_set">
                <div>Username and password are error!</div>
            </div>
            <button class=" btn btn-danger "  type="submit" ng-disabled="login_form.$invalid" >Login</button>
        </form>
    </center>
</section>