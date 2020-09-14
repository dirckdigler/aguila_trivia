<?php

namespace Drupal\aguila_beer_per_view\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\aguila_beer_per_view\Service\AguilaBeerPerViewGetStorage;
use Drupal\aguila_beer_per_view\Ajax\AguilaBeerPerViewQualifyCommand;
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
    $nid_trivia = 3;
    $get_question = $this->storageTrivia->build($nid_trivia); 

    return [
      '#theme' => 'aguila_beer_per_view_trivia',
      '#content' => $get_question,
    ];
  } 

  /**
   * Determine if the answer was correct.
   * 
   * @param string $option
   *  Option who user selected.
   */
  public function qualify($option) {
    if ($option) {
      try {
        $qualify_trivia = $this->storageTrivia->qualify_trivia($option); 
        if (!$qualify_trivia) {
          $result_trivia = 'error';
        }
        else {
          $result_trivia = 'true';
        }
      }
      catch (\LogicException $e) {
        // Do nothing on fail.
      }
    }
    
    return $this->response($qualify_trivia);

  }

  /**
   * Call Ajax Command.
   * 
   * @param string $qualify_trivia
   *  Final qualify.
   */ 
  public function response($qualify_trivia) {
    $response = new AjaxResponse();
    $response->addCommand(new AguilaBeerPerViewQualifyCommand($qualify_trivia));
    return $response;
  }

}