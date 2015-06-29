<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{title}</title>

    {meta}{meta}{/meta}

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    {css}{link}{/css}
    {theme}
</head>

<body>
{navigation}

<div class="container">

    <div class="row">

        <div class="col-md-3">

            {sidebar}

        </div>

        <div class="col-md-9">

            <?= $this->messageci->display(); ?>

            {content}

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            {footer}

        </div>

    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
{js}{script}{/js}

</body>

</html>