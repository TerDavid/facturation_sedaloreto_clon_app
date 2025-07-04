<?php

namespace App\CoreFacturalo\Helpers\QrCode;

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;


class QrCodeGenerate
{
    public function displayPNGBase64($value, $w = 150, $level = 'L', $background = [255, 255, 255], $color = [0, 0, 0], $filename = null, $quality = 1)
    {
        $qrCode = new QrCode($value, $level);
        $output = new Output\Png();

        // Generate PNG data with optimized settings for smaller size
        // Reduced width from 150 to 100, using lowest error correction level 'L'
        $pngData = $output->output($qrCode, $w, $background, $color, $quality);
        // $filename = 'qrcode4.png';
        // Save to file if filename is provided
        if ($filename) {
            file_put_contents(public_path($filename), $pngData);
        }

        return base64_encode($pngData);
    }
}
