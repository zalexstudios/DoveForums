{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">Add Group</h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('name')){echo 'has-error';} ?>">
                    {name_label}
                    {name_field}
                    {name_error}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('description')){echo 'has-error';} ?>">
                    {description_label}
                    {description_field}
                    {description_error}
                </div>

            </div>

        </div>

        <div class="form-group">
            {btn_add_edit_group}
        </div>

        {form_close}

    </div>

</div>