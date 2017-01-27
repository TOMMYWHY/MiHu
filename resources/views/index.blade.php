<!doctype html>
<html ng-app="mihu">
<head>
    <meta charset="UTF-8">
    <title>米乎</title>
    <link rel="stylesheet" href ="/node_modules/normalize-css/normalize.css">
    <link rel="stylesheet" href="/resources/css/commons.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/resources/css/base.css">

    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/bootstrap/bootstrap.min.js"></script>
    <script src="/node_modules/angular/angular.js"></script>
    <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/resources/js/base.js"></script>
    <script src="/resources/js/user.js"></script>
    <script src="/resources/js/common.js"></script>
    <script src="/resources/js/question.js"></script>

</head>
<body>
        <header>
            <div class="container-fluid p0">
                <div class="top_line"></div>
                <nav class="navbar navbar-default navbar-static-top" >
                    <div class="container p0">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="javascript:;" ui-sref="home">MiHu</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li >
                                    <form id="quick_ask" class="" ng-controller="QuestionAddController" ng-submit="Question.go_add_question()">
                                        <div class="input-group pt10 " style=" max-width: 350px">
                                            <input type="text" class="form-control" placeholder="Search for..." ng-model="Question.new_question.title">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">
                                                    {{--<span class="  glyphicon glyphicon-search" aria-hidden="true"></span>--}}
                                                    Ask Question?
                                                </button>
                                              </span>
                                        </div>
                                    </form>
                                </li>
                                {{--<li class=""><a href='javascript:;'>Home</a></li>--}}
                                <li><a href="#">Topic</a></li>
                                {{--<li><a href="#">Discover</a></li>--}}
                            </ul>
                            <ul class="nav navbar-nav navbar-right ">
                                <li class=""><a href="">Ask <span class=""></span></a></li>
                                @if(is_logged_in())
                                    <li class=""><a href="">{{session('username')}} <span class=""></span></a></li>
                                    <li class=""><a href="{{url('/api/logout')}}"> Logout<span class=""></span></a></li>

                                @else
                                    <li class=""><a href="" ui-sref="login">Login <span class=""></span></a></li>
                                    <li class=""><a href="" ui-sref="signup">signup <span class=""></span></a></li>
                                @endif


                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </nav>
            </div>
        </header>
<div>
    <div ui-view></div>
</div>
</body>
</html>