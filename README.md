# Symfony bundle for chgst library


[![Version](https://img.shields.io/packagist/v/chgst/chgst-bundle.svg?style=flat-square)](https://packagist.org/packages/chgst/chgst-bundle)
[![CircleCI](https://dl.circleci.com/status-badge/img/circleci/UiMSDe5Q43N7rRZKowVuq2/KG7zvGbQ5rbm5RXcsiBcaW/tree/develop.svg?style=shield)](https://dl.circleci.com/status-badge/redirect/circleci/UiMSDe5Q43N7rRZKowVuq2/KG7zvGbQ5rbm5RXcsiBcaW/tree/develop)
[![Coverage Status](https://coveralls.io/repos/github/chgst/chgst-bundle/badge.svg?branch=develop)](https://coveralls.io/github/chgst/chgst-bundle?branch=develop)
[![License](https://poser.pugx.org/chgst/chgst-bundle/license.svg)](https://packagist.org/packages/chgst/chgst-bundle)

## Before Install

Make sure you have Symfony Security installed:

```bash
composer require security
```

## Installation

```bash
composer require chgst/chgst-bundle
```

## Configuration

Set your event repository service for persisting events to data store

```yaml
# config/packages/chgst.yaml
chgst:
  enable_listeners: true

# Make sure you disable listeners in test/dev environment
when@dev:
  chgst:
    enable_listeners: false

when@test:
  chgst:
    enable_listeners: false
```

Add repository service to your services configuration

```yaml
# config/services.yaml
services:

    Chgst\Event\RepositoryInterface:
        public: true
        class: Chgst\Event\ObjectRepository
        arguments: [ '@doctrine_mongodb.odm.document_manager', 'App\Document\DefaultEvent' ] # or '@doctrine.orm.entity_manager'
```

Create Doctrine model class for your events

```php
<?php
// src/Document/DefaultEvent.php

namespace App\Document;

use Chgst\Event\Event;

class DefaultEvent extends Event
{
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
```

And add XML mapping

```xml
<doctrine-mongo-mapping xmlns="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping
                    https://doctrine-project.org/schemas/odm/doctrine-mongo-mapping.xsd">

    <document name="App\Document\DefaultEvent">
        <id />
        <field field-name="name" type="string" nullable="false" />
        <field field-name="aggregateType" type="string" nullable="false" />
        <field field-name="aggregateId" type="string" nullable="false" />
        <field field-name="createdAt" type="date" nullable="false" />
        <field field-name="createdBy" type="string" nullable="false" />
        <field field-name="payload" type="hash" nullable="false" />
    </document>
</doctrine-mongo-mapping>
```