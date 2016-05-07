
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
                    <li><a href=<?php echo(SERVER_NAME) ."/Customers/index"?>><span class="fa fa-book"></span> אלפון</a></li>
                    <li><a href=<?php echo(SERVER_NAME) ."/Customers/showCustomersTable"?>><span class="fa fa-table"></span> טבלה</a></li>
                </ul>
            </li>

            <?php if($user[0]->type_id != 2) { ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">עובדים<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/Worker/index"?>><span class="fa fa-book"></span> אלפון</a></li>
                    <li><a href=<?php echo(SERVER_NAME) ."/Worker/showWorkersTable"?>><span class="fa fa-table"></span> טבלה</a></li>
                </ul>
            </li>
            <?php } ?>

            <?php if($user[0]->type_id != 2) { ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">פעולות<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/ActivityController/index"?>><span class="fa fa-table"></span> אישור פעולות</a></li>
                    <li><a href=<?php echo(SERVER_NAME) ."/ActivityController/allActivities"?>><span class="fa fa-table"></span> כל הפעולות</a></li>
                </ul>
            </li>
            <?php } ?>

        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo $this->userFullName; ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/index"?>><span class="fa fa-user"></span>פרופיל</a></i></li>
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/settings"?>><span class="fa fa-wrench"></span>הגדרות</a></li>
                    <?php if($user[0]->type_id == 1) { ?>
                    <li><a href=<?php echo(SERVER_NAME) ."/UserProfileController/addUser"?>><span class="fa fa-plus"></span>הוסף משתמש</a></li>
                    <?php } ?>
                    <li><a href=<?php echo(SERVER_NAME) ."/Login/logout"?>><span class="glyphicon glyphicon-log-out"></span>התנתק</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>