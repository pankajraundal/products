<?php

namespace Drupal\productswithqr\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\productswithqr\Service\QrCodeGenerater;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'QR Code' Block.
 *
 * @Block(
 *   id = "qrcode_block",
 *   admin_label = @Translation("Qr Code block"),
 *   category = @Translation("Qr Code block"),
 * )
 */
class QrCodeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Match the current route.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * Get the current node id.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $currentNode;

  /**
   * Qr code generater.
   *
   * @var \Drupal\products\Service\QrCodeGenerater
   */
  protected $qrCodeGenerater;

  /**
   * {@inheritdoc}
   */
  public static function create(
      ContainerInterface $container,
      array $configuration,
      $plugin_id,
      $plugin_definition
      ) {
    return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('current_route_match'),
          $container->get('qr_generater')
      );
  }

  /**
   * Creates a BLockUserInfo instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The current request.
   * @param Drupal\productswithqr\Service\QrCodeGenerater $qrCodeGenerater
   *   Qr generator service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $current_route_match, QrCodeGenerater $qrCodeGenerater) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $current_route_match;
    $this->currentNode = $this->routeMatch->getParameter('node');
    $this->qrCodeGenerater = $qrCodeGenerater;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get conten URL for which QR code needs to generate.
    $link_url = $this->currentNode->field_product_link->first()->toArray()['uri'];
    // Call qr generater service to generat qr.
    $qrCodeChillerlan = $this->qrCodeGenerater->qrGeneraterChillerlan($link_url);
    // Return array with template name and qr code.
    return [
      '#theme' => 'qr_code_block',
      '#qr_code' => $qrCodeChillerlan,
    ];
  }

  /**
   * Disable cache for this block.
   */
  public function getCacheMaxAge() {
    // Avoid caching data uri image, this will vary product.
    return 0;
  }

}
