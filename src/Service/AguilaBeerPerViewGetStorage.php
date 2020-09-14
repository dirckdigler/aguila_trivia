<?php

namespace Drupal\aguila_beer_per_view\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class AguilaBeerPerViewGetStorage.
 */
class AguilaBeerPerViewGetStorage {

  /**
   * A Node Interface.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  public function __construct(EntityTypeManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;;
  }


  /**
   * Builds an array with information related to Likeit for a specific entity.
   *
   * @param int $nid_trivia
   *
   * @return array
   *   Array with information related to the Trivia Question.
   */
  public function build($nid_trivia) {
    $results = [];
    $multiple_answers = [];
    // WIP - It's neccesary to load trivia dinamically, depending $nid.
    $node = $this->entityManager->getStorage('node')->load($nid_trivia);
    if ($paragraph_field_items = $node->get('field_questions_answers')->getValue()) {
      $paragraph_storage = $this->entityManager->getStorage('paragraph');
      $ids = array_column($paragraph_field_items, 'target_id');
      $paragraphs_objects = $paragraph_storage->loadMultiple($ids);
      
      /** @var \Drupal\paragraphs\Entity\Paragraph $paragraph */
      foreach ($paragraphs_objects as $paragraph) {
       
        $multiple_answers = !empty($paragraph->get('field_multiple_answers')) ? 
          $paragraph->get('field_multiple_answers') : NULL;
        
        // Validate if exist values for field_multiple_answers.
        if ($multiple_answers) {
          foreach ($multiple_answers as $key) {
            $values = $key->value;
            $group_answers[$paragraph->id->value][] = $values;
          }
        
          $multiple_answers = $group_answers[$paragraph->id->value];
          //kint($multiple_answers);

        }

        $question = !empty($paragraph->get('field_question')) ? 
          $paragraph->get('field_question')->value : NULL;
        $correct_answers = !empty($paragraph->get('field_correct_answers')) ?
          $paragraph->get('field_correct_answers')->value : NULL;
        $url_controller = '/aguila_beer_per_view/qualify/';

        $results = [
          'question' => $question,
          'multiple_options' => $multiple_answers,
          'correct_answers' => $correct_answers,
          'counter' => 1,
          'url' => $url_controller,
        ];
      }
    }

    return $results;
  }

  /**
   * Validate the match between option selected by the user
   * and array with the correct answer.
   *
   * @param string $option
   *
   * @return bool
   * 
   */
  public function qualify_trivia($option) {
    // WIP - it's necessary elaborate the trivia id dinamically
    // and set as a parameter.
    $result = $this->build(3);
    $get_option_key = array_search($option, $result['multiple_options']);
    if ($get_option_key == $result['correct_answers']) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

}
