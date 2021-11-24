# Redirection d'un formulaire vers la même page après soumission

```php
/**
 * Form submission handler.
 *
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 */
public function submitForm(array &$form, FormStateInterface $form_state) {
    ...
    $current_path     = \Drupal::service('path.current')->getPath();
    $url_object       = \Drupal::service('path.validator')->getUrlIfValid($current_path);
    $route_name       = $url_object->getRouteName();        //eg: entity.node.canonical
    $route_parameters = $url_object->getrouteParameters();  //eg: ['node' => '1']

    $form_state->setRedirect($route_name, $route_parameters);
}
```
