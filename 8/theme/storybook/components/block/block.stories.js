export default { title: 'Blocks' }

import drupalAttribute from 'drupal-attribute'
import block from './block.twig'
import './block.css'
import './block.js'

export const default_block = () => {

  return block({
    attributes: new drupalAttribute(),
    title_attributes: new drupalAttribute(),
    plugin_id: "Some plugin",
    title_prefix: "",
    title_suffix: "",
    label: "I'm a block!",
    content: "Lorem ipsum dolor sit amet.",
  })

}
