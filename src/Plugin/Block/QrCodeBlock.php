<?php
namespace Drupal\products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'QR Code' Block.
 *
 * @Block(
 *   id = "qrcode_block",
 *   admin_label = @Translation("Qr COde block"),
 *   category = @Translation("Qr COde block"),
 * )
 */
class QrCodeBlock extends BlockBase {

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
    * {@inheritdoc}
    */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static (
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('current_route_match')
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

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $current_route_match)
  {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->routeMatch = $current_route_match;
      $this->currentNode = $this->routeMatch->getParameter('node');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
   
        return [
            '#markup' => $this->t('This is for QR code'),
          ];
    
  }

  
}
