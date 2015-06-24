<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-info">

    <div class="panel-heading">

        <h4 class="panel-title">Add Categories</h4>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="form-group <?php if(form_error('name')){echo 'has-error';} ?>">

            {name_label}
            {name_field}
            {name_error}

        </div>

        <div class="form-group">

            {add_hidden_field}

            {btn_add}

        </div>

        {form_close}

    </div>

</div>

<div class="panel panel-success">

    <div class="panel-heading">

        <h3 class="panel-title">Edit Categories</h3>

    </div>

    <div class="panel-body">

        {form_open}

        {categories}

            <div class="form-group">

                {category}
                {hidden}

            </div>

        {/categories}

        <div class="form-group">

            {edit_hidden_field}

            {btn_edit}

        </div>

        {form_close}

    </div>

</div>

<div class="panel panel-danger">

    <div class="panel-heading">

        <h3 class="panel-title">Delete Categories</h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="form-group <?php if(form_error('category')){echo 'has-error';} ?>">

            {category_label}
            {category_field}
            {category_error}

        </div>

        <div class="form-group">

            {delete_hidden_field}

            {btn_delete}

        </div>

        {form_close}

    </div>

</div>