<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21/12/2015
 * Time: 14:03
 */

require_once('./model/UserModel.php');
require_once('./Configure.php');

/**
 * Class UserProfileView
 */
class UserProfileView
{
    private $userModel;
    private $userType;
    private $userName;
    private $userPassword;
    private $userId;
    private $userPhone;
    private $userEmail;
    private $userFirstName;
    private $userLastName;
    private $userFullName;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show user profile.
     */
    public function showUserProfile()
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;
        $this->userFullName = $user[0]->full_name;
        $this->userPassword = $user[0]->user_password;
        $this->userType = $this->getUserType($user);
        $this->userId = $user[0]->id;
        $this->userPhone = $user[0]->phone_number;
        $this->userEmail = $user[0]->email;
        $this->getFullName($user);

        if (empty($user)) {
            header('Location: index.php');
        }

        $html = '<!DOCTYPE html>
                <html lang="en">';

        include("./public/parts/top.php");

        $html .= '<body>
             <!--NavBar-->';

        include("./public/parts/nav.php");

        $html .= '
    <div class="container">
    <h1>פרטים אישיים</h1>
    <hr>
    <div id="mydiv" class="panel panel-default row">
    <h1 class="panel-title">פרופיל</h1>
        <div class="panel-body">
            <ul class="list-group">
            <li class="list-group-item text-right"><span class="pull-left"><strong>שם פרטי</strong></span>' .$this->userFirstName .' </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>שם משפחה</strong></span>' .$this->userLastName .' </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>תפקיד</strong></span>' .$this->userType .' </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>משתמש</strong></span>' .$this->userName .' </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>מ"ס עובד</strong></span>' .$this->userId .'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>פלאפון</strong></span>' .$this->userPhone .'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>מייל</strong></span>' .$this->userEmail .'</li>
          </ul>
        </div>
    </div>
    </div>';

        $html .= '
</body>
</html>';

        echo $html;
    }

    /**
     * @param string $isSuccess
     * @param string $response
     * Show user settings.
     */
    public function showSettings($isSuccess='',$response ='')
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;
        $this->userFullName = $user[0]->full_name;
        $this->userType = $this->getUserType($user);
        $this->userId = $user[0]->id;
        $this->userPhone = $user[0]->phone_number;
        $this->userEmail = $user[0]->email;
        $this->getFullName($user);

        if (empty($user)) {
            header('Location: index.php');
        }

        $html = '<!DOCTYPE html>
                <html lang="en">';

        include("./public/parts/top.php");

        $html .= '<body>
             <!--NavBar-->';

        include("./public/parts/nav.php");

        $html .= '
        <div class="container">
    <h1>ערוך פרטים אישיים</h1>
  	<hr>
	<div class="row">
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>פרטים אישיים</h3>
        <form id="userInfo" class="form-horizontal" role="form" action="" method="post"
            data-fv-framework="bootstrap"
            data-fv-icon-valid="glyphicon glyphicon-ok"
            data-fv-icon-invalid="glyphicon glyphicon-remove"
            data-fv-icon-validating="glyphicon glyphicon-refresh">
          <div class="form-group">
            <label class="col-lg-3 control-label">שם פרטי:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userFirstName" name="userFirstName" type="text" value=' . $this->userFirstName .'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">שם משפחה:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userLastName" name="userLastName" type="text" value=' . $this->userLastName .'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">משתמש:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userName" name="userName" type="text" value=' .$this->userName .'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">מייל:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userEmail" name="userEmail" type="text" value=' .$this->userEmail .'>
            </div>
          </div>
           <div class="form-group">
            <label class="col-lg-3 control-label">מ"ס פלאפון:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userPhone" name="userPhone" type="text" value=' .$this->userPhone .'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">סיסמה חדשה:</label>
            <div class="col-md-8">
              <input class="form-control" id="userPassword" name="userPassword" type="password" value=""
                data-fv-notempty="true"
                data-fv-notempty-message="The password is required">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">וודא סיסמה:</label>
            <div class="col-md-8">
              <input class="form-control" id="userPasswordC" name="userPasswordC" type="password" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary">שמור שינויים</button>
              <input type="reset" class="btn btn-default" value="אתחל">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>
        ';

        if($isSuccess){
            $html .= '
            <div class="alert alert-success">
                <strong>בוצע! </strong>' . $response .'
            </div>';
        }
        elseif($isSuccess === false){
            $html .= '
            <div class="alert alert-danger">
                <strong>שגיאה! </strong>' . $response .'
            </div>';
        }

        $html .= '
<script src="/public/js/user.js"></script>
</body>
</html>';

        echo $html;
    }

    /**
     * @param string $response
     * Show add user.
     */
    public function showAddUser($response='')
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;
        $this->userFullName = $user[0]->full_name;

        if (empty($user)) {
            header('Location: index.php');
        }

        $html = '<!DOCTYPE html>
                <html lang="en">';

        include("./public/parts/top.php");

        $html .= '<body>
             <!--NavBar-->';

        include("./public/parts/nav.php");

        $html .= '
        <div class="container">
    <h1>הוסף משתמש חדש</h1>
  	<hr>
	<div class="row">
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>פרטים אישיים</h3>
        <form class="form-horizontal" id="add_user_form" role="form" method="post">
           <div class="form-group">
            <label class="col-lg-3 control-label">שם פרטי:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userFirstName" name="userFirstName" type="text" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">שם משפחה:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userLastName" name="userLastName" type="text" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">משתמש:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userName" name="userName" type="text" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">מייל:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userEmail" name="userEmail" type="text" value="">
            </div>
          </div>
           <div class="form-group">
            <label class="col-lg-3 control-label">מ"ס פלאפון:</label>
            <div class="col-lg-8">
              <input class="form-control" id="userPhone" name="userPhone" type="text" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">תפקיד:</label>
            <div class="col-lg-8">
                 <select class="form-control col-sm-4" id="position" name="position">
                    <option value="">בחר תפקיד</option>
                    <option value="1">מנהל</option>
                    <option value="2">סוכן שטח</option>
                    <option value="3">עובד משרד</option>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">סיסמה:</label>
            <div class="col-md-8">
              <input class="form-control" id="userPassword" name="userPassword" type="password" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary" id="add_user_btn">שמור שינויים</button>
              <input type="reset" class="btn btn-default" value="אתחל">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>';
        $html .= '
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/user.js></script>

</body>
</html>';

        echo $html;

    }

    /**
     * @param $user
     */
    private function getFullName($user)
    {
        $fullName = $user[0]->full_name;
        $fullName = array(explode(" ", $fullName, 2));
        $this->userFirstName = $fullName[0][0];
        $this->userLastName = $fullName[0][1];
    }

    /**
     * @param $user
     * @return user type.
     */
    private function getUserType($user)
    {
        $typeId = $user[0]->type_id;
        $userType = $this->userModel->getUserType($typeId);
        $userTypeName = $userType[0]->user_type;
        return $userTypeName;
    }

}