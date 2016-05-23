
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">איש קשר</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form id="new_contact_form" class="form-horizontal" role="form" method="post">
            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $id ?>">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact_name" class="col-sm-4 control-label">שם האיש קשר</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="contact_name" name="contact_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="col-sm-4 control-label">פלאפון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="phone_number" name="phone_number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact_fax" class="col-sm-4 control-label">פקס</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="contact_fax" name="contact_fax">
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="position" class="col-sm-4 control-label">תפקיד</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="position" name="position">
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact_mail" class="col-sm-4 control-label">מייל</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="contact_mail" name="contact_mail">
                    </div>
                </div>

                <div class = "form-group">
                    <label for="comments" class="col-sm-2 control-label">הערה</label>
                    <div class="col-md-10">
                        <textarea class = "form-control" id="comments" name="comments" rows = "5"></textarea>
                    </div>
                </div>

            <div class="panel col-md-12">
                <div class="col-md-offset-5">
                    <button type="submit" class="btn btn-success" id="add_worker_btn">הוסף איש קשר</button>
                    <input type="reset" class="btn btn-default" value="אתחל">
                </div>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>