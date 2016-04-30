
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href=<?php echo(SERVER_NAME) ."/Login"?>>מבט המושבים</a>
    </div>
    <div class="collapse navbar-collapse" id="example-navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">לקוחות<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/Customers/index"?>>אלפון</a></li>
                    <li><a href="#">טבלה</a></li>
                </ul>
            </li>
            <?php if($user[0]->type_id != 2) { ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">עובדים<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/Worker/index"?>>אלפון</a></li>
                    <li><a href="#">טבלה</a></li>
                </ul>
            </li>
            <?php } ?>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">פעולות<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/ActivityController/index"?>>אישור פעולות</a></li>
                </ul>
            </li>

            <li><a href="#">הזמנות</a></li>
            <li><a href="#">חוזים</a></li>
            <li><a href="#">ניודים</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo $this->userName; ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/index"?>>פרופיל</a></li>
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/settings"?>>הגדרות</a></li>
                    <?php if($user[0]->type_id == 1) { ?>
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/addUser"?>>הוסף משתמש</a></li>
                    <?php } ?>
                    <li><a href=<?php echo(SERVER_NAME) ."/Login/logout"?>>התנתק</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>