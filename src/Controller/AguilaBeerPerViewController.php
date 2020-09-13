<?php

namespace Drupal\aguila_beer_per_view\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\aguila_beer_per_view\Service\AguilaBeerPerViewGetStorage;
use Drupal\aguila_beer_per_view\Ajax\AguilaBeerPerViewCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Class AguilaBeerPerViewController.
 */
class AguilaBeerPerViewController extends ControllerBase {

  /**
   * @var Drupal\aguila_beer_per_view\Service\AguilaBeerPerViewGetStorage
   */
  protected $storageTrivia;

  /**
   * AguilaBeerPerViewController constructor.
   * @param AguilaBeerPerViewGetStorage $storage_trivia
   */
  public function __construct(AguilaBeerPerViewGetStorage $storage_trivia) {
    $this->storageTrivia = $storage_trivia;
  }

  /**
   * @param ContainerInterface $container
   * @return AguilaBeerPerViewController|static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('aguila_beer_per_view.storage_trivia')
    );
  }

  /**
   * Returns question Trivia.
   */
  public function content() {
    // WIP - it's necessary elaborate the trivia id dinamically
    // and set as a parameter.
    $nid_trivia = 2;
    $get_question = $this->storageTrivia->build($nid_trivia); 

    return [
      '#theme' => 'aguila_beer_per_view_trivia',
      '#content' => $get_question,
    ];
  } 

    /**
   * Like action.
   *
   * @param string $entity
   *   Target entity name.
   * @param string $id
   *   Target entity id.
   * @param string $html_id
   *   Link DOM id.
   * @param string $token
   *   Csrf token.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Return response string.
   */
  public function qualify($token) {
    
    $response = new AjaxResponse();
    $response->addCommand(new AguilaBeerPerViewCommand($token));
    return $response;
  }

}