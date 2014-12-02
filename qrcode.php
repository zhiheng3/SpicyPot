<?php
/**
  * Generate a QR Code
  * Author: Feng Zhibin
  * Last modified: 2014.12.02
  */
require_once "lib/phpqrcode.php";
class QRCodeGenerator{
    public function generate($studentId, $ticketId){
        $qrcodeInfo = $studentId . "\n" . $ticketId;
        $qrcodePath = "qrcode/$ticketId.png";
        $errorCorrectionLevel = "L";
        $matrixPointSize = 4;
        QRCode::png($qrcodeInfo, $qrcodePath, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}
?>
