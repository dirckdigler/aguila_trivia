<?php

namespace Drupal\aguila_beer_per_view\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Class AguilaBeerPerViewCommand.
 */
class AguilaBeerPerViewCommand implements CommandInterface {

  protected $snackbarData;

  /**
   * Constructs a WmiSnackbarCommand object.
   *
   * @param array $snackbar_data
   *   Array with data needed to build a Snackbar notification.
   *   It can include the following elements:
   *   - 'type': (required) The type of the Snackbar. It can be one of these
   *     values: 'info', 'error', 'success'.
   *   - 'message': The text of the message of the Snackbar.
   *   - 'action': An associative array with information to build the action
   *     link in the Snackbar. Allowed keys:
   *     -- url: The URL where the action element must link.
   *     -- text: The text of the action link.
   *     -- class: A string with additional classes to be added to the action
   *
   *   Example:
   *
   *   [
   *     'type' => 'success',
   *     'message' => 'Saved to your liked posts',
   *     'action' => [
   *       'url' => 'http://example.com',
   *       'text' => 'Undo',
   *       'class' => 'use-ajax highlighted',
   *     ],
   *   ];
   */
  public function __construct($snackbar_data) {
    $this->snackbarData = $snackbar_data;
  }

  /**
   * Implements \Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    return [
      'command' => 'qualifyResponseTrivia',
      'snackbarData' => $this->snackbarData,
    ];
  }

}

