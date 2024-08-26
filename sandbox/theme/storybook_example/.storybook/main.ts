import type { StorybookConfig } from "@storybook/html-vite";
import Twig from 'twig';
import twigDrupal from "twig-drupal-filters"

twigDrupal(Twig);

const config: StorybookConfig = {
  stories: [
    "../src/components/**/*.mdx",
    "../src/components/**/*.stories.@(js|jsx|mjs|ts|tsx)"
  ],
  addons: [
    "@storybook/addon-links",
    "@storybook/addon-essentials",
    "@storybook/addon-a11y",
    "@storybook/addon-interactions",
    "@chromatic-com/storybook",
  ],
  framework: {
    name: "@storybook/html-vite",
    options: {},
  },
  staticDirs: [
    "../public",
  ],
};
export default config;
