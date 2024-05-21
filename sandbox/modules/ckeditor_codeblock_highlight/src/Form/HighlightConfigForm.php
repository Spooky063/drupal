<?php

declare(strict_types=1);

namespace Drupal\ckeditor_codeblock_highlight\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

final class HighlightConfigForm extends ConfigFormBase
{
    public function getFormId(): string
    {
        return 'highlight_config_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state): array
    {
        $form = parent::buildForm($form, $form_state);

        $config = $this->config('ckeditor_codeblock_highlight.settings');

        $form['theme'] = [
            '#type' => 'select',
            '#title' => $this->t('Theme'),
            '#options' => $this->getAllThemes(),
            '#default_value' => $config->get('theme'),
            '#ajax' => [
                'callback' => '::themeChangeCallback',
                'disable-refocus' => false,
                'event' => 'change',
            ]
        ];

        $form['snippet'] = [
            '#title' => $this->t('Preview'),
            '#theme' => 'ckeditor_template',
            '#value' => $config->get('theme'),
            '#styles' => $this->getAllThemes(),
        ];

        $form['#attached']['library'][] = 'ckeditor_codeblock_highlight/admin';

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state): void
    {
        $config = $this->config('ckeditor_codeblock_highlight.settings');

        $config->set('theme', $form_state->getValue('theme'));
        $config->save();

        foreach (Cache::getBins() as $cache_backend) {
            $cache_backend->deleteAll();
        }

        parent::submitForm($form, $form_state);
    }

    public function themeChangeCallback(array &$form, FormStateInterface $form_state): AjaxResponse
    {
        $response = new AjaxResponse();
        $response->addCommand(new InvokeCommand('', 'themeChangeCallback', [$form_state->getValue('theme')]));
        return $response;
    }

    protected function getEditableConfigNames(): array
    {
        return [
            'ckeditor_codeblock_highlight.settings',
        ];
    }

    private function getAllThemes(): array
    {
        return [
            'a11y-dark' => 'a11y-dark' ,
            'a11y-light' => 'a11y-light',
            'agate' => 'agate',
            'an-old-hope' => 'an-old-hope',
            'androidstudio' => 'androidstudio',
            'arduino-light' => 'arduino-light',
            'arta' => 'arta',
            'ascetic' => 'ascetic',
            'atom-one-dark-reasonable' => 'atom-one-dark-reasonable',
            'atom-one-dark' => 'atom-one-dark',
            'atom-one-light' => 'atom-one-light',
            'brown-paper' => 'brown-paper',
            'brown-papersq' => 'brown-papersq',
            'codepen-embed' => 'codepen-embed',
            'color-brewer' => 'color-brewer',
            'dark' => 'dark',
            'default' => 'default',
            'devibeans' => 'devibeans',
            'docco' => 'docco',
            'far' => 'far',
            'felipec' => 'felipec',
            'foundation' => 'foundation',
            'github-dark-dimmed' => 'github-dark-dimmed',
            'github-dark' => 'github-dark',
            'github' => 'github',
            'gml' => 'gml',
            'googlecode' => 'googlecode',
            'gradient-dark' => 'gradient-dark',
            'gradient-light' => 'gradient-light',
            'grayscale' => 'grayscale',
            'hybrid' => 'hybrid',
            'idea' => 'idea',
            'intellij-light' => 'intellij-light',
            'ir-black' => 'ir-black',
            'isbl-editor-dark' => 'isbl-editor-dark',
            'isbl-editor-light' => 'isbl-editor-light',
            'kimbie-dark' => 'kimbie-dark',
            'kimbie-light' => 'kimbie-light',
            'lightfair' => 'lightfair',
            'lioshi' => 'lioshi',
            'magula' => 'magula',
            'mono-blue' => 'mono-blue',
            'monokai-sublime' => 'monokai-sublime',
            'monokai' => 'monokai',
            'night-owl' => 'night-owl',
            'nnfx-dark' => 'nnfx-dark',
            'nnfx-light' => 'nnfx-light',
            'nord' => 'nord',
            'obsidian' => 'obsidian',
            'panda-syntax-dark' => 'panda-syntax-dark',
            'panda-syntax-light' => 'panda-syntax-light',
            'paraiso-dark' => 'paraiso-dark',
            'paraiso-light' => 'paraiso-light',
            'pojoaque' => 'pojoaque',
            'pojoaque.jpg' => 'pojoaque.jpg',
            'purebasic' => 'purebasic',
            'qtcreator-dark' => 'qtcreator-dark',
            'qtcreator-light' => 'qtcreator-light',
            'rainbow' => 'rainbow',
            'routeros' => 'routeros',
            'school-book' => 'school-book',
            'shades-of-purple' => 'shades-of-purple',
            'srcery' => 'srcery',
            'stackoverflow-dark' => 'stackoverflow-dark',
            'stackoverflow-light' => 'stackoverflow-light',
            'sunburst' => 'sunburst',
            'tokyo-night-dark' => 'tokyo-night-dark',
            'tokyo-night-light' => 'tokyo-night-light',
            'tomorrow-night-blue' => 'tomorrow-night-blue',
            'tomorrow-night-bright' => 'tomorrow-night-bright',
            'vs' => 'vs',
            'vs2015' => 'vs2015',
            'xcode' => 'xcode',
            'xt256' => 'xt256',
        ];
    }
}
