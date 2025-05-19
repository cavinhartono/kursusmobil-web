<?php
ob_start();
include_once('../certification/tcpdf/tcpdf.php');

$certification = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);
$certification->setTitle('Certificate of Courses Indonesia Mandiri');
$certification->AddPage();
$certification->setFont('dejavusans', '', 16);
