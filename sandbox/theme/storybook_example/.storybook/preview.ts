import { Preview } from "@storybook/html";
import { GlobalTypes } from "storybook/internal/types";
import theme from './storybook_example'

import '../src/css/reset.css';
import '../src/css/variable.css';
import '../src/css/font.css';
import '../src/css/base.css';

export const preview: Preview = {
  parameters: {
    docs: {
      theme,
    },
    controls: {
      matchers: {
        color: /(background|color)$/i,
        date: /Date$/i,
      },
    },
  }
};

export const globalTypes: GlobalTypes = {
  theme: {
    name: 'Theme',
    description: 'Global theme for components',
    defaultValue: 'light',
    toolbar: {
      icon: 'circlehollow',
      items: [
        { value: 'light', title: 'Light' },
        { value: 'dark', title: 'Dark' },
      ],
    },
  },
};

export const decorators = [(story, context) => {
  const theme = context.globals.theme;
  return `<div style="color-scheme: ${theme}">${story()}</div>`
}]
