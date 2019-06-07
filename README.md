# SourceFramework
Current version 2.2.0

### What is SourceFramework?
SourceFramework is an extensible object-oriented tools for WordPress that helps you to develop themes and plugins.

If you only want install the latest version please download the zip of the most recent release in https://github.com/jprieton/source-framework/releases

### Development
* Must have NodeJS installed
* Must have NPM installed
* Must have Grunt installed
* Must have LESS installed
* The plugin folder should be located in **/wp-content/plugins/**

From the plugin root directory run the following commands:

``` bash
npm install
npm start
```

To watch for css and js file changes run:

```bash
npm run watch
```

### Deployment
From the plugin root directory run the following command:

```bash
npm run build
```

### PHPUnit tests
* Must have PHPUnit installed
* Must have WP-CLI installed

From the plugin root directory run the following command:

``` bash
bin/install-wp-tests.sh wordpress_test root password localhost latest
```

Where

* `wordpress_test` – This is the name of the database that will be created.
* `root` - Our MySQL username.
* `password` - Our MySQL password.
* `localhost` - The MySQL server host.
* `lastest` - The version of WordPress to install.

#### Run the Sample Unit Test

To run the tests associated with our plugin, we can navigate to our plugin folder in the terminal and run the following command:

```bash
phpunit
```

### Bug tracker?
Have a bug? Please create an issue on GitHub at https://github.com/jprieton/source-framework/issues