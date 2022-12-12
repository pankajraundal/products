<?php
namespace Drupal\products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\products\Service\QrCodeGenerater;
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
    * Get the current node id
    * 
    * @var \Drupal\node\Entity\Node
    */
  protected $currentNode;

  /**
    * Qr code generater.
    *
    * @var \Drupal\products\Service\QrCodeGenerater;
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
        return new static (
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
   */

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $current_route_match, QrCodeGenerater $qrCodeGenerater)
  {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->routeMatch = $current_route_match;
      $this->currentNode = $this->routeMatch->getParameter('node');
      $this->qrCodeGenerater = $qrCodeGenerater;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
      
      $link_url = $this->currentNode->field_product_link->first()->toArray()['uri'];
      $qrCodeChillerlan = $this->qrCodeGenerater->qrGeneraterChillerlan($link_url);
      $qrCode = $this->qrCodeGenerater->qrGenerater($link_url);

      echo $qrCodeChillerlan;
      echo "<br>-----------------------------------<br>";
      echo $qrCode;
     
      return [
        '#theme' => 'qr_code_block',
        '#qr_code' => $qrCodeChillerlan,
      ];
      // return [
      //   '#markup' => '<div style="border:3px;">
      //     <img src="'. $qrCodeChillerlan .'" height="100" width="100"  alt="star" />
      //   </div>
      //   <div style="border:10px;">
      //   <img src="'. $qrCode .'" height="100" width="100"  alt="star1" />
      //   </div>',
      // ]; 
  }

  /**
   * @return int
   */
  public function getCacheMaxAge() {
    return 0;
  }

  
}
