<?php
/**
  * Generate a QR Code
  * Author: Feng Zhibin
  * Last modified: 2014.12.27
  * Important: GD libarary for php needed
  */
require_once "lib/phpqrcode.php";
class QRCodeGenerator{
    public function generate($studentId, $ticketId){
        $qrcodeInfo = $studentId . "\n" . $ticketId; //Information in QR Code
        $qrcodePath = "qrcode/$ticketId.png"; //Path of the QR Code generated
        $errorCorrectionLevel = "L"; //"L", "M", "Q", "H"
        $matrixPointSize = 4; //1 to 10
        QRCode::png($qrcodeInfo, $qrcodePath, $errorCorrectionLevel, $matrixPointSize, 2); //Generate
    }
}
?>
