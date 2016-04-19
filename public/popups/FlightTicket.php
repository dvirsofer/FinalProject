<?php
/*if (mail ($to, $subject, $body, $from)) {
    $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
} else {
    $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
}*/

//if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
    <?php
$workerInfo = $this->workerModel->getWorkerInfo($id);
$passport = $this->workerModel->getPassportInfo($id);
$customerId = $workerInfo[0]->current_customer_id;
$customer = $this->customerModel->getCustomerInfo($customerId);
?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">כרטיס טיסה</h4>
</div>
    <div class="modal-body">
        <div class="row">
            <form id="flight-ticket-form" class="form-horizontal" role="form">
                <input type="hidden" id="mail-address" name="mail-address" value="">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="form-group">
                            <label for="first_name_FT" class="col-md-4 control-label">שם פרטי</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="first_name_FT" id="first_name_FT" value="<?php echo $workerInfo[0]->first_name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name_FT" class="col-md-4 control-label">שם משפחה</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="last_name_FT" id="last_name_FT" value="<?php echo $workerInfo[0]->last_name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passport_number_FT" class="col-md-4 control-label">מספר דרכון</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="passport_number_FT" id="passport_number_FT" value="<?php echo $passport[0]->passport_number ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="employer_name_FT" class="col-md-4 control-label">שם מעסיק</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="employer_name_FT" id="employer_name_FT" value="<?php echo $customer[0]->customer_name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_FT" class="col-md-4 control-label">איש קשר</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="contact_FT" id="contact_FT">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_contact_FT" class="col-md-4 control-label">טלפון איש קשר</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="phone_contact_FT" id="phone_contact_FT">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_FT" class="col-md-4 control-label">סוג כרטיס</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="type_FT" id="type_FT">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="target_FT" class="col-md-4 control-label">יעד</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="target_FT" id="target_FT">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dereliction_date_FT" class="col-md-4 control-label">תאריך יציאה</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="dereliction_date_FT" id="dereliction_date_FT">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="arrival_date_FT" class="col-md-4 control-label">תאריך חזרה</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="arrival_date_FT" id="arrival_date_FT">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comments_FT" class="col-md-4 control-label">הערה</label>
                        <div class="col-md-8">
                            <textarea class = "form-control" rows = "5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="panel col-md-12">
                    <div class="col-md-6 col-md-offset-3">
                        <button id="alon-turs-btn" type="button" class="btn btn-primary">שלח לאלון טורס</button>
                        <button id="hilel-turs-btn" type="button" class="btn btn-primary">שלח להלל טורס</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

<?php //} ?>