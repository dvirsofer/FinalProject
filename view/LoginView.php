<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 01/12/2015
 * Time: 18:22
 */

/**
 * Class LoginView
 */
class LoginView {

    /**
     * @param $isSuccess
     * @param string $response
     */
    public function showLogin($isSuccess,$response ='')
    {
        $html=
            '<!DOCTYPE html>
        <html lang="en">';
        include("./public/parts/top.php");

        $html.= '<body>

        <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-5 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <!--<div class="row">
        <div class="col-md-4 col-md-offset-4">-->
        ';


        if (!$isSuccess )
        {
            $html.=  '<div class="alert alert-danger">
                    <strong>התראה!</strong>'   . $response .'</div>';
        }


        $html.=
            '<div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">התחברות למערכת</div>
                </div>

                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form class="form-horizontal" role="form" action="" method="post">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="inputId" id="inputId" value="" placeholder="תעודת זהות">
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="סיסמה">
                        </div>

                        <div class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="login-remember" type="checkbox" name="remember" value="1">הישאר מחובר
                                </label>
                            </div>
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button type="submit" class="btn btn-success btn-sm">התחבר</button>
                                <button type="reset" class="btn btn-default btn-sm">אתחול</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>';

        /*$html.=
            '<div class="panel panel-default">
                <div class="panel-heading"> <strong class="">כניסה למערכת</strong>

                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="" method="post">
                        <div class="form-group">
                            <label for="inputId" class="col-sm-4 control-label">תעודת זהות </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="inputId" id="inputId" placeholder="תעודת זהות" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-4 control-label">סיסמה</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="סיסמה" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label class="">
                                        <input type="checkbox" class="">הישאר מחובר</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-sm">התחבר</button>
                                <button type="reset" class="btn btn-default btn-sm">אתחול</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>';*/

        echo $html;
    }

}