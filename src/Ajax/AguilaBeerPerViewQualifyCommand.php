<?php

namespace Drupal\aguila_beer_per_view\Ajax;

use Drupal\Core\Ajax\CommandInterface;

 /**
 * Class AguilaBeerPerViewQualifyCommand.
 */
 class AguilaBeerPerViewQualifyCommand implements CommandInterface {

  protected $qualifyTrivia;

  public function __construct($qualify_trivia) {
    $this->qualifyTrivia = $qualify_trivia;
  }

  /**
   * Render custom ajax command.
   *
   * @return ajax command function
   */
  public function render() {
      return [
          'command' => 'qualifyResponseTrivia',
          'qualify' => $this->qualifyTrivia,
      ];
  }

}