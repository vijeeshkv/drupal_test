<?php

namespace Drupal\administration\Plugin\Block;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Block\BlockBase;
use DateTime;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\administration\Service\DateDisplayService;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a 'DateDisplay' Block.
 *
 * @Block(
 *   id = "date_display_block",
 *   admin_label = @Translation("Date Display Block"),
 *   category = @Translation("Custom Block"),
 * )
 */
class DateDisplayBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Date Display Service block object.
   * 
   * @var \Drupal\administration\Service\DateDisplayService
   */
  protected $dateDisplayService;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The HTTP request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * Constructs a new DateDisplayBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\administration\Service\DateDisplayService $date_display_service
   *   The Date Display Service block utility.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The Renderer service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   The Request stack service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DateDisplayService $date_display_service, RendererInterface $renderer,
  RequestStack $requestStack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, );
    $this->dateDisplayService = $date_display_service;
    $this->renderer = $renderer;
    $this->request = $requestStack->getCurrentRequest();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('customdatedisplay'),
      $container->get('renderer'),
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    try {
      $timezone = $this->dateDisplayService->getConfigTimeZone();
      $langcode = NULL;
      $formatted = \Drupal::service('date.formatter')->format(time(), 'custom', 'jS M Y h:i:s A', $timezone, $langcode);
      $markup = 'Block Current Date and Time: ';
      $markup .= $formatted;
      $service_data = $this->dateDisplayService->getValue();
      //$markup .= $service_data;
      $build = [
        '#theme' => 'date_display_service_block',
        '#block_data' => $markup,
        '#service_data' => $service_data,
        '#time_zone' =>  $timezone
      ];      
    }
    catch (InvalidPluginDefinitionException $e) {
    }
    catch (PluginNotFoundException $e) {
    }

    return $build;
    /*return [
      '#markup' => $markup,
    ];*/
  }

}