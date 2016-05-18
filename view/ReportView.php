<?php

require_once('./model/ReportModel.php');
require_once('./model/WorkerModel.php');
require_once('./Configure.php');

/**
 * Class ReportView
 */
class ReportView
{
    private $reportModel;
    private $workerModel;
    private $userFullName;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->workerModel = new WorkerModel();
    }

    /**
     * show report page.
     */
    public function showReport($workers = '')
    {
        $user = unserialize($_SESSION['user']);
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
        <h1>דו"ח רשומות כפולות</h1>
  	    <hr>
            <div class="row">
            <!-- activity table -->
                <div class="col-md-9 personal-info">
                    <form class="form-horizontal" id="workers_table" role="form" method="post">
                    <input type="hidden" id="worker_id" name="worker_id" value="">
                        <button type="submit" class="btn btn-success">חיפוש</button>
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th> מ"ס</th>
                                        <th> מספר עובד</th>
                                        <th> שם פרטי</th>
                                        <th> שם משפחה</th>
                                        <th> מספר דרכון</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>';

        if(!empty($workers)) {
            $html .= $this->createWorkersTable($workers);
        }

        $html .= '</tbody>

                            </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      ';

        $html .= '
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/worker.js></script>
        </body>
</html>';

        echo $html;

    }

    private function createWorkersTable($workers)
    {
        $str = "";

        for($i = 0; $i < count($workers); $i++) {
            for($j = 0; $j < count($workers[$i]); $j++) {
                if($i % 2 == 0) {
                    $str .= "<tr class='success'>";
                }
                else {
                    $str .= "<tr class='info'>";
                }
                $data = $workers[$i][$j]->worker_id;
                $str .= "<td>" .
                    $workers[$i][$j]->id . "</td><td>" .
                    $workers[$i][$j]->worker_id . "</td><td>" .
                    $workers[$i][$j]->first_name . "</td><td>" .
                    $workers[$i][$j]->last_name . "</td><td>" .
                    $workers[$i][$j]->passport_number . "</td>" .
                    "<td class='button'><a class='btn btn-danger delClass' id='delete_btn' data-id='$data'><span class='glyphicon glyphicon-remove'></span> מחק</a></td>" .
                    "</tr>";
            }
        }
        return $str;
    }

}