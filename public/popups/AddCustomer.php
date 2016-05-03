<?php
$settlements = $this->customerModel->getAllSettlements();
$user = $this->userModel->getUserById($id);
$allAgent = $this->customerModel->getAllAgent();

?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">לקוח חדש</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form id="add_customer_form" class="form-horizontal" role="form" method="post">
            <div class="col-md-6">
                <div class="panel">
                    <div class="form-group">
                        <label for="customer_name" class="col-md-4 control-label">שם לקוח</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="customer_name" id="customer_name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer_name_en" class="col-md-4 control-label">שם לקוח באנגלית</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="customer_name_en" id="customer_name_en" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="settlement" class="col-md-4 control-label">ישוב</label>
                        <div class="col-md-8">
                            <select class="form-control" id="settlement" name="settlement">
                                <option value="0">בחר ישוב</option>
                                <?php foreach($settlements as $settlement) { ?>
                                    <option value="<?php echo $settlement->id ?>"><?php echo $settlement->settlement_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="main_customer" class="col-md-4 control-label">לקוח ראשי</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="main_customer" id="main_customer">
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_number" class="col-md-4 control-label">מספר</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="company_number" id="company_number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="dealer" class="col-md-4 control-label">רכז</label>
                    <div class="col-md-8">
                        <select class="form-control" id="dealer" name="dealer">
                            <option value="0">בחר ישוב</option>
                            <?php foreach($allAgent as $agent) { ?>
                                <option value="<?php echo $agent->id ?>"><?php echo $agent->user_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="panel col-md-12">
                <div class="col-md-offset-5">
                    <button type="submit" class="btn btn-success" id="add_customer_btn">הוסף לקוח</button>
                    <input type="reset" class="btn btn-default" value="אתחל">
                </div>
            </div>


        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>