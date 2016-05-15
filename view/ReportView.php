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
    public function showReport()
    {
        $user = unserialize($_SESSION['user']);
        $this->userFullName = $user[0]->full_name;

        //$allWorkers = $this->workerModel->getAllWorkersDetails();
        //error_log(print_r($allWorkers, TRUE));
       /* for($i = 0; $i < count($allWorkers); $i++) {
            $worker = $allWorkers[$i];
            $sameWorkers = $this->reportModel->getAllSameWorkers($allWorkers, $worker);
            error_log(print_r($sameWorkers, TRUE));
        }*/
        //$sameWorkers = $this->reportModel->getAllSameWorkers($allWorkers);
        //error_log(print_r($sameWorkers, TRUE));


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
        <h3>דו"ח רשימות כפולות</h3>
            <div class="row">
            <!-- activity table -->
                <div class="col-md-9 personal-info">
                    <form class="form-horizontal" id="workers_table" role="form" method="post">
                        <button type="submit" class="btn btn-success">חיפוש</button>

                    </form>
                </div>
            </div>
        </div>
      ';

        $html .= '
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/report.js></script>
        </body>
</html>';

        echo $html;

    }



}