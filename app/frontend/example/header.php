<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $v->title?></title>
    <meta name="description" content="<?php echo $v->description ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php $v->asset('main','css'); ?>

  </head>
  <body>
    <div class="container">
      <div class="personal">
        <h1 style="margin-bottom:5px;"><?php echo $v->personal->name ?></h1>
        <quote>- <?php echo $v->personal->des ?></quote>
      </div>
