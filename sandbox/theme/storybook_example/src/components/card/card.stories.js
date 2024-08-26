import card from './card.twig'
import './card.css'

import drupalAttribute from 'drupal-attribute'

export default {
  title: 'Component/Card',
  component: card,
  parameters: {},
  args: {
    attributes: new drupalAttribute(),
    title_attributes: new drupalAttribute(),
    plugin_id: "Some plugin",
    title_prefix: "",
    title_suffix: "",
    image: {
      source: '/images/377-400x300.jpg',
      alt: ''
    },
    label: 'Design Systems',
    content: '<p>This is an example of a card created with storybook and integrate in Drupal.</p>',
    configuration: {
      provider: "Some module"
    }
  },
}

export const Default = {}
