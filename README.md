# Symfony bundle for chgst library

[![Version](https://img.shields.io/packagist/v/chgst/chgst-bundle.svg?style=flat-square)](https://packagist.org/packages/chgst/chgst-bundle)
[![Build Status](https://travis-ci.org/chgst/chgst-bundle.svg?branch=develop)](https://travis-ci.org/chgst/chgst-bundle)
[![Coverage Status](https://coveralls.io/repos/github/chgst/chgst-bundle/badge.svg?branch=develop)](https://coveralls.io/github/chgst/chgst-bundle?branch=develop)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chgst/chgst-bundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/chgst/chgst-bundle/?branch=develop)
[![License](https://poser.pugx.org/chgst/chgst-bundle/license.svg)](https://packagist.org/packages/chgst/chgst-bundle)

## Installation

```bash
composer require chgst/chgst-bundle
```

```php
# AppKernel.php
<?php

class AppKernel extends Kernel
{
   public function registerBundles()
   {
       $bundles = [
           // ...
           new Changeset\ChangesetBundle\ChangesetBundle(),
           // ...
       ];

}
```


## Configuration

Set your event repository service for persisting events to data store

```yaml
#app/config/config.yml

changeset:
    event_repository: '@your.preferred.implementation'
    event_bus: '@your.preferred.event_bus.implementation'

```

Wire your command handlers

```yaml
#app/config/services.yml

services:

  AppBundle\Command\Handler\:
    resource: '%kernel.root_dir%/../src/AppBundle/Command/Handler'
    public: true
    autowire: true
    tags: [ 'changeset.command.handler' ]
```
