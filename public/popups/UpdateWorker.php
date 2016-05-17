<?php
$worker = $this->workerModel->getWorkerInfo($id);
$passport = $this->workerModel->getPassportInfo($id);

?>

<?php if(!empty($id)) { ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">עדכן עובד</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form id="update_worker_form" class="form-horizontal" role="form" method="post">
            <input type="hidden" id="worker_id" name="worker_id" value="<?php echo $worker[0]->worker_id ?>">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label">שם פרטי</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $worker[0]->first_name ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nation" class="col-sm-4 control-label">לאום</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="nation" name="nation" value="<?php echo $worker[0]->citizen ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-sm-4 control-label">תאריך לידה</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $worker[0]->birthday_date ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="col-sm-4 control-label">פלאפון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $worker[0]->phone_number ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="passport_number" class="col-sm-4 control-label">מספר דרכון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="passport_number" name="passport_number" value="<?php echo $passport[0]->passport_number ?>">
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name" class="col-sm-4 control-label">שם משפחה</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $worker[0]->last_name ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-sm-4 control-label">מין</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $worker[0]->gender ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrive" class="col-sm-4 control-label">צורת הגעה</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="arrive" name="arrive" value="<?php echo $worker[0]->form_of_eravel ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrival_date" class="col-sm-4 control-label">תאריך הגעה</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="arrival_date" name="arrival_date" value="<?php echo $worker[0]->entrance_date ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="valid_passport" class="col-sm-4 control-label">תוקף דרכון</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="valid_passport" name="valid_passport" value="<?php echo $passport[0]->validation_date ?>">
                    </div>
                </div>
            </div>

            <div class="panel col-md-12">
                <div class = "form-group">
                    <label for="comments" class="col-sm-2 control-label">הערה</label>
                    <div class="col-md-10">
                        <textarea class = "form-control" id="comments" name="comments" rows = "5"></textarea>
                    </div>
                </div>
            </div>

            <div class="panel col-md-12">
                <div class="col-md-offset-5">
                    <button type="submit" class="btn btn-success" id="update_worker_btn">עדכן עובד</button>
                    <input type="reset" class="btn btn-default" value="אתחל">
                </div>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php } ?>