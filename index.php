<?php

include 'app/DailyLiturgyPage.php';
include 'app/ReadingBuilder.php';
include 'app/DailyLiturgy.php';
include 'app/Reading.php';
include 'app/HTMLUtils.php';

@header("Content-Type: text/html; charset=utf-8");

$liturgy = new DailyLiturgy((int)isset($_GET['day']) ? (int)$_GET['day'] : (int)date('d'),
    (int)isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m'),
      (int)isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y'));

echo json_encode($liturgy->toArray());
