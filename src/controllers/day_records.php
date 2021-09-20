<?php
session_start();
requireValidSession();

loadModel('WorkingHours');

$date = (new Datetime())->getTimeStamp();
$today = strftime('%d de %B de %Y', $date);

loadTemplateView('/day_records', ['today'=> $today,]);
