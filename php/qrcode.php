<?php
/**
  * Generate a QR Code
  * Author: Feng Zhibin
  * Last modified: 2014.1.8
  * Important: GD libarary for php needed
  */
require_once "phpqrcode.php";
class QRCodeGenerator{
    public function generate($studentId, $ticketId){
        //Information in QR Code
        $qrcodeInfo = $studentId . "\n" . $ticketId;
        //Path of the QR Code generated
        $qrcodePath = "./resource/qrcode/$ticketId.png";
        //"L", "M", "Q", "H"
        $errorCorrectionLevel = "L";
        //1 to 10
        $matrixPointSize = 4;
        //Generate
        QRCode::png($qrcodeInfo, $qrcodePath, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}
?>
