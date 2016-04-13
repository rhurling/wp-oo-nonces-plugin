WordPress Object Oriented Nonces Plugin
=======================================

WordPress Plugin that uses the `rhurling/nonces` composer package to overwrite the pluggable WP functions `wp_create_nonce` and `wp_verify_nonce`.

[![Build Status](https://travis-ci.org/rhurling/wp-oo-nonces-plugin.svg?branch=master)](https://travis-ci.org/rhurling/wp-oo-nonces-plugin)
[![Coverage Status](https://coveralls.io/repos/github/rhurling/wp-oo-nonces-plugin/badge.svg?branch=master)](https://coveralls.io/github/rhurling/wp-oo-nonces-plugin?branch=master)

Installation
------------

### Load as dependency in another Plugin

```
composer require rhurling/wp-oo-nonces-plugin
```

### As WordPress Plugin

1. [Download Zip File](https://github.com/rhurling/wp-oo-nonces-plugin/archive/master.zip)
2. Unpack into plugins directory
4. Run `composer install` inside the Plugin directory from command line
