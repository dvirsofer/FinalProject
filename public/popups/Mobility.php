<?php
$workerInfo = $this->workerModel->getWorkerInfo($id);
$passport = $this->workerModel->getPassportInfo($id);
$customerId = $workerInfo[0]->current_customer_id;
if(!empty($customerId)) {
    $customer = $this->customerModel->getCustomerInfo($customerId);
    $customerName = $customer[0]->customer_name;
}
else {
    $customerName = "";
}
$customers = $this->customerModel->getCustomers();
?>

<?php if(!empty($id)) { ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">ניוד</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form class="form-horizontal" id="mobility_form" role="form" method="post">
            <input type="hidden" id="worker_id" name="worker_id" value="<?php echo $workerInfo[0]->worker_id ?>">
            <div class="col-md-6">
                <div class="panel">
                    <div class="form-group">
                        <label for="old_employer_name" class="col-md-4 control-label">מעסיק נוכחי</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="old_employer_name" name="old_employer_name" value="<?php echo $customerName ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_employer_name" class="col-md-4 control-label">מעסיק קולט</label>
                        <div class="col-md-8">
                            <select class="form-control" id="new_employer_name" name="new_employer_name">
                                <option value="0">בחר מעסיק קולט</option>
                                <?php foreach($customers as $currentCustomer) { ?>
                                <option value="<?php echo $currentCustomer->id ?>"><?php echo $currentCustomer->customer_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passport_number_MOB" class="col-md-6 control-label">מספר דרכון</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="passport_number_MOB" name="passport_number_MOB" value="<?php echo $passport[0]->passport_number ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date" class="col-md-4 control-label">תחילת ניוד</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="start_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="end_date" class="col-md-4 control-label">סיום ניוד</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="end_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="worker_name" class="col-md-4 control-label">שם העובד</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="worker_name" name="worker_name" value="<?php echo $workerInfo[0]->first_name . ' ' . $workerInfo[0]->last_name ?>">
                    </div>
                </div>
            </div>

            <div class="panel col-md-offset-5">
                <button type="submit" class="btn btn-primary" id="send_btn">אישור</button>
            </div>

        </form>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php } ?>