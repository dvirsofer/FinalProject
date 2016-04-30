<?php

require_once('./model/ActivityModel.php');
require_once('./Configure.php');

/**
 * Class ActivityView
 */
class ActivityView
{
    private $activityModel;
    private $userName;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->activityModel = new ActivityModel();
    }

    /**
     * show activity.
     */
    public function showActivity()
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;

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
            <div class="row">
            <!-- activity table -->
                <div class="col-md-9 personal-info">
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="activity">
                            <thead>
                                <tr>
                                    <th>מ"ס</th>
                                    <th>פעולה</th>
                                    <th>מצב הפעולה</th>
                                    <th>תיאור הפעולה</th>
                                </tr>
                            </thead>

                            <tbody>';

        $html .= $this->createActivityTable();

        $html .= '</tbody>

                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      ';


        $html .= '
<script src='.SERVER_NAME .'/public/js/activity.js></script>
        </body>
</html>';

        echo $html;

    }

    private function createActivityTable()
    {
        $activities = $this->activityModel->getAllActivities();
        $str = "";

        foreach ($activities as $activity) {
            $activityType = $this->activityModel->getActivityType($activity->description_id);
            $str .= "<tr><td>" .
                $activity->id . "</td><td>" .
                $activityType[0]->name . "</tb><td>" .
                $activity->status_description . "</td><td>" .
                $activity->description .
                "</td></tr>";
        }
        return $str;
    }

}