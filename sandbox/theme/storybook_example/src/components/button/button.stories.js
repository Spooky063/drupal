import button from './button.twig'
import './button.css'

(async () => {
  if (button) {
    await import("./button.js");
  }
})();

import { within, userEvent } from '@storybook/test';

export default {
  title: 'Atom/Button',
  component: button,
  parameters: {
    content: {
      description: 'Another description, overriding the comments'
    }
  },
  args: {
    content: 'Click me',
  },
}

export const Default = {
  play: async ({ canvasElement }) => {
    const canvas = within(canvasElement);
    const button = await canvas.getByRole("button");
    await userEvent.click(button);
  },
}
