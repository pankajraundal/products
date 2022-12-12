<?php

namespace Drupal\productswithqr\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

/**
 * Provides a 'QR Code' for requested link or string.
 */
class QrCodeGenerater {

  /**
   * Qr generater function user chillerplan library.
   *
   * @param string $url
   *   URL to conver into qr code.
   */
  public function qrGeneraterChillerlan(string $url) {
    $options = new QROptions(
        [
          'eccLevel' => QRCode::ECC_L,
          'outputType' => QRCode::OUTPUT_MARKUP_SVG,
          'version' => 5,
        ]
    );
    $qrcode = (new QRCode($options))->render($url);
    return $qrcode;
  }

}
