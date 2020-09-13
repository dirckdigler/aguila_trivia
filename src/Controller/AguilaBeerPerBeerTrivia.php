<?php

namespace Drupal\aguila_beer_per_view\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controlDrupal\Core\Field\FieldItemListler.
 */
class AguilaBeerPerBeerTrivia extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function content() {
    $results = [];
    $multiple_answers = [];
    // WIP - It's neccesary to load trivia dinamically, depending $nid.
    $node = \Drupal::entityManager()->getStorage('node')->load(2);
    if ($paragraph_field_items = $node->get('field_questions_answers')->getValue()) {
      $paragraph_storage = \Drupal::entityTypeManager()->getStorage('paragraph');
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
        }

        $question = !empty($paragraph->get('field_question')) ? 
          $paragraph->get('field_question')->value : NULL;
        $correct_answers = !empty($paragraph->get('field_correct_answers')) ?
          $paragraph->get('field_correct_answers')->value : NULL;
        $results = [
          'question' => $question,
          'multiple_options' => $multiple_answers,
          'correct_answers' => $correct_answers,
          'counter' => 1,
        ];
      }
    }

    return [
      '#theme' => 'aguila_beer_per_beer_trivia',
      '#content' => $results,
    ];

  }

}