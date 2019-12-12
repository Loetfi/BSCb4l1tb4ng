<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo @$title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bgslideshow/css/style1.css');?>" / -->
  <style>
  ol,ul {
    list-style:none;
  }
  .global-header {
    width: 100%;
    height: 100%;
    background-size: cover;
    text-align: center;
  }
  .global-header{
    -webkit-animation: fade 4s infinite;
    -moz-animation: fade 4s infinite;
    -o-animation: fade 4s infinite;
    animation: fade 4s infinite;
  }

  .global-header {
    position: relative;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    transition: all .2s ease;
    -webkit-animation: fade 4s infinite;
    -moz-animation: fade 4s infinite;
    -o-animation: fade 4s infinite;
    animation: fade 4s infinite;
  }
  </style>
</head>
