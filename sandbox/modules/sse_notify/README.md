# SSE Notify

The idea is to use SSE to notify the client when a node is updated.

## Prerequisites

The module requires the package [symfony/mercure-bundle](https://github.com/dunglas/MercureBundle) to work.
To do this, we need to install the `mercure` Drupal module.

```bash
composer require drupal/mercure
```

### Mercure

You need to have a mercure installed. I do it via Docker with this example.

```yaml
services:
  mercure:
    restart: unless-stopped
    image: dunglas/mercure
    environment:
      SERVER_NAME: ':80'
      MERCURE_EXTRA_DIRECTIVES: |
        cors_origins http://drupal10.localhost
      MERCURE_SUBSCRIBER_JWT_KEY: MercureSubscriberJWTSecretForDebugPurpose
      MERCURE_PUBLISHER_JWT_KEY: MercurePublisherJWTSecretForDebugPurpose
      GLOBAL_OPTIONS: debug
    ports:
      - 8001:80
```

Then change the environment variable `MERCURE_EXTRA_DIRECTIVES` with you PHP server URI. Change the JWT_KEY for both of them.
You can open your browser and go to `http://drupal10.localhost:8001/.well-known/mercure` to see the Mercure hub. If you want to check your topic, you can go to `http://drupal10.localhost:8001/.well-known/mercure?topic=/notification/node` and see the topic event stream.

### Services

You have to change the `services.yml` file to add the Mercure hub.

```yaml
parameters:
  mercure:
    hubs:
      default:
        url: 'http://mercure/.well-known/mercure'
        public_url: 'http://drupal10.localhost:8001/.well-known/mercure'
        jwt:
          secret: 'MercurePublisherJWTSecretForDebugPurpose'
          publish: '*'
```

Be sure to change the `public_url` with your Mercure server URI with the prefix `/.well-known/mercure`. Don't forget the `secret` with the one you have set in the Mercure container (MERCURE_PUBLISHER_JWT_KEY).

### PHP

You have to set the `MERCURE_SUBSCRIBER_SECRET` environment variable with the secret you have set in the Mercure container (MERCURE_SUBSCRIBER_JWT_KEY).
You need to check if the package [syymfony/mercure-bundle](https://github.com/symfony/mercure-bundle) is installed.

## Installation

Install the module with Drush.

```bash
drush en sse_notify
```

## Usage

The module will add a new event listener to the `node_update` event.
