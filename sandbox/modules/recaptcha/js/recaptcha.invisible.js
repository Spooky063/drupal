/**
 * @file
 * Invisible reCaptcha behaviors.
 */
/**
 * The submit object that was clicked.
 *
 * @type {object}
 */
var clickedSubmit = '';
var clickedSubmitEvent = '';

/**
 * reCaptcha data-callback that submits the form.
 *
 * @param token
 *   The validation token.
 */
function recapthcaOnInvisibleSubmit(token) {
  jQuery(clickedSubmit).trigger(clickedSubmitEvent);
  clickedSubmit = '';
}

(function ($, Drupal) {
  /**
   * Handles the submission of the form with the invisible reCaptcha.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior for the invisible reCaptcha.
   */
  Drupal.behaviors.invisibleRecaptcha = {
    attach: function (context) {
      if (Drupal.hasOwnProperty('Ajax')) {
        Drupal.Ajax.prototype.beforeSubmit = function (form_values, element, options) {
          if ($(this.element).is(clickedSubmit) && grecaptcha.getResponse().length === 0) {
            options.needsRevalidate = true;
          }
          else if ($(this.element).is(clickedSubmit) && grecaptcha.getResponse().length !== 0) {
            this.progress.type = 'none';
          }
        };
        $(document).ajaxSend(function( event, jqxhr, settings ) {
          if (settings.needsRevalidate) {
            jqxhr.abort();
          }
        });
      }
      $('form', context).each(function () {
        var $form = $(this);
        if ($form.find('.g-recaptcha[data-size="invisible"]').length) {
          $form.find(':submit').on({
            click: function ( e ) {
              preventFormSubmit(e, this);
            }
          });
        }
      });
      function preventFormSubmit(event, elem) {
        if (grecaptcha.getResponse().length === 0) {
          // We need validate form, to avoid prevention of html5 validation.
          if ($(elem).closest('form')[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            clickedSubmitEvent = event.type;
            validateInvisibleCaptcha(elem);
          }
        }
      }
      /**
       * Triggers the reCaptcha to validate the form.
       *
       * @param {object} button
       *   The submit button object was clicked.
       */
      function validateInvisibleCaptcha(button) {
        clickedSubmit = button;
        grecaptcha.execute();
      }
    }
  }
})(jQuery, Drupal);
