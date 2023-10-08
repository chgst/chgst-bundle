# Symfony bundle for chgst library


[![Version](https://img.shields.io/packagist/v/chgst/chgst-bundle.svg?style=flat-square)](https://packagist.org/packages/chgst/chgst-bundle)
[![Build Status](https://travis-ci.org/chgst/chgst-bundle.svg?branch=develop)](https://travis-ci.org/chgst/chgst-bundle)
[![Coverage Status](https://coveralls.io/repos/github/chgst/chgst-bundle/badge.svg?branch=develop)](https://coveralls.io/github/chgst/chgst-bundle?branch=develop)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chgst/chgst-bundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/chgst/chgst-bundle/?branch=develop)
[![License](https://poser.pugx.org/chgst/chgst-bundle/license.svg)](https://packagist.org/packages/chgst/chgst-bundle)

## Before Install

Make sure you have Symfony Security installed:

```bash
composer require security
```

## Installation

Install the `chgst/chgst` first:

```bash
composer require chgst/chgst
```

And create default `Chgst\Event\RepositoryInterface` implementation (can be empty for now). Example implementation:

```php
<?php

namespace App\Chgst;

use Chgst\Event\EventInterface;
use Chgst\Event\RepositoryInterface;

class ObjectRepository implements RepositoryInterface
{
    public function create(): EventInterface
    {
    }

    public function append(EventInterface $event)
    {
    }

    public function getIterator(): \Iterator
    {
    }
}
```

Create service from the implementation;

```yaml
# config/services.yaml
services:
    Chgst\Event\RepositoryInterface:
        class: App\Chgst\ObjectRepository
```

Finally install the bundle

```bash
composer require chgst/chgst-bundle
```

## Configuration

Set your event repository service for persisting events to data store

```yaml
# config/services.yaml

chgst:
    event_repository: '@Chgst\Event\RepositoryInterface'
    event_bus: '@your.preferred.event_bus.implementation'
    command_handler: '@your.preferred.command_handler.implementation'
    enable_listeners: true

```

Make sure you disable listeners in dev and test env

```yaml
# config/services_(dev|test).yaml

chgst:
    enable_listeners: false
```

