Astina Fotolia Bundle
=====================

Symfony 2 bundle integrating the Fotolia API Kit for PHP.

https://github.com/Fotolia/Fotolia-API

## Installation

### Step 1

Add astina/fotolia-bundle in your composer.json:

```js
{
    "require": {
        "astina/fotolia-bundle": "dev-master"
    }
}
```

and install it

``` bash
$ php composer.phar update astina/fotolia-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Astina\Bundle\FotoliaBundle\AstinaFotoliaBundle(),
        // ...
    );
}
```

### Step 3

Configure the client service:

```yaml
astina_fotolia:
    api_key: your_fotolia_api_key
    caching: true|false # whether to cache api requests
```