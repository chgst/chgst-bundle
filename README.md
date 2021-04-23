# Symfony bundle for chgst library

<!-- 0.2.1 -->

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

And create default `Changeset\Event\RepositoryInterface` implementation (can be empty for now). Example implementation:

```php
<?php

namespace App\Changeset;

use Changeset\Event\EventInterface;
use Changeset\Event\RepositoryInterface;

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
    Changeset\Event\RepositoryInterface:
        class: App\Changeset\ObjectRepository
```

Finally install the bundle

```bash
composer require chgst/chgst-bundle
```

## Configuration

Set your event repository service for persisting events to data store

```yaml
# config/services.yaml

changeset:
    event_repository: '@Changeset\Event\RepositoryInterface'
    event_bus: '@your.preferred.event_bus.implementation'
    command_handler: '@your.preferred.command_handler.implementation'
    enable_listeners: true

```

Make sure you disable listeners in dev and test env

```yaml
# config/services_(dev|test).yaml

changeset:
    enable_listeners: false
```

* See [chgst/chgst-bundle-example](https://github.com/chgst/chgst-bundle-example)


