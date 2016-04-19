<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">עובד חדש</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form id="new_worker_form" class="form-horizontal" role="form" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label">שם פרטי</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="first_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nation" class="col-sm-4 control-label">לאום</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="nation">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-sm-4 control-label">תאריך לידה</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="col-sm-4 control-label">טלפון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="phone_number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="passport_number" class="col-sm-4 control-label">מספר דרכון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="passport_number">
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name" class="col-sm-4 control-label">שם משפחה</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="last_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-sm-4 control-label">מין</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="gender">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrive" class="col-sm-4 control-label">צורת הגעה</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="arrive">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrival_date" class="col-sm-4 control-label">הגעה לארץ</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="arrival_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="exit_date" class="col-sm-4 control-label">יציאה מהארץ</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="exit_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="valid_passport" class="col-sm-4 control-label">תוקף דרכון</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="valid_passport">
                    </div>
                </div>
            </div>

            <div class="panel col-md-12">
                <div class = "form-group">
                    <label for="comments" class="col-sm-2 control-label">הערות</label>
                    <div class="col-md-10">
                        <textarea class = "form-control" rows = "5"></textarea>
                    </div>
                </div>
            </div>

            <div class="panel col-md-12">
                <div class="col-md-offset-5">
                    <button type="submit" class="btn btn-success" id="add_worker_btn">הוסף עובד</button>
                    <input type="reset" class="btn btn-default" value="אתחל">
                </div>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>