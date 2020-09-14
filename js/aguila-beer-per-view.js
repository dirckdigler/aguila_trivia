(function ($, Drupal) {
 
  /**
   * Display a symbol in the option that was wrong next to the label.
   *
   * @param {Drupal.Ajax} [ajax]
   *   A {@link Drupal.ajax} object.
   * @param {object} response
   *   Ajax response.
   * @param {string} response.qualify
   *   A boolean value that determines if the answer was correct.
   * @param status
   */
  Drupal.AjaxCommands.prototype.qualifyResponseTrivia = function (ajax, response, status) {
    console.log(response.qualify);
  }
  })(jQuery, Drupal);