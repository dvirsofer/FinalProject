<?php
$workerInfo = $this->workerModel->getWorkerInfo($id);
$passport = $this->workerModel->getPassportInfo($id);
$customerId = $workerInfo[0]->current_customer_id;
$customer = $this->customerModel->getCustomerInfo($customerId);
$customers = $this->customerModel->getCustomers();
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">מנה</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form class="form-horizontal">
            <div class="col-md-6">
                <div class="panel">
                    <div class="form-group">
                        <label for="employer_name_MNA" class="col-md-4 control-label">מעסיק חדש</label>
                        <div class="col-md-8">
                            <select class="form-control" id="employer_name_MNA" name="employer_name_MNA">
                                <option value="0">בחר מעסיק חדש</option>
                                <?php foreach($customers as $currentCustomer) { ?>
                                <option value="<?php echo $currentCustomer->id ?>"><?php echo $currentCustomer->customer_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passport_number_MNA" class="col-md-4 control-label">מספר דרכון</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="passport_number_MNA" value="<?php echo $passport[0]->passport_number ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="old_employer_name_MNA" class="col-md-4 control-label">מעסיק קודם</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="old_employer_name_MNA" value="<?php echo $customer[0]->customer_name ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="worker_name_MNA" class="col-md-4 control-label">שם העובד</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="worker_name_MNA" value="<?php echo $workerInfo[0]->first_name . ' ' . $workerInfo[0]->last_name ?>">
                    </div>
                </div>
            </div>

            <div class="panel col-md-6">
                <button type="button" class="btn btn-primary">שלח מנה למת"ש</button>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>