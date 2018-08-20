
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

```yaml
#app/config/config.yml

chgst_bundle:
    event_repository: '@your.prefered.implementation'

```