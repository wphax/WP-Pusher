WP Pusher
=========

WP Pusher is a simple plugin that (currently) notifies visitors of your WordPress site when a new post is created in real-time using [Pusher](http://pusher.com) and the `publish_post` hook. It creates a small popup on the bottom left of the web page with a message and a link to the new post which appears for 10 seconds, until it finally fades out.

Don't forget to download the [pusher-php-server](https://github.com/pusher/pusher-php-server) submodule as well. It will not authenticate users without it.

Installation
-----

Download this repository and also the [pusher-php-server](http://github.com/pusher/pusher-php-server) submodule. Upload the contents to your `wp-content/plugins` folder and activate like normal in the WordPress dashbaord. For shell users, follow these instructions:

    cd /path/to/wp-content/plugins
    git clone git@github.com:wphax/WP-Pusher.git
    cd WP-Pusher
    git submodule init
    git submodule update

Configuration
-----

The plugin has an options page created called WP Pusher under Settings in the WordPress dashboard. There are a limited amount of options (for now), including Pusher Active, App ID, Key, Secret, and Debug Javascript. If 'Pusher Active' is set to Inactive, the plugin will not function. Debug Javascript will log debugging information to the Javascript console on the frontend. The plugin will not function without the App ID, Key, or Secret.

Changelog
-----

- 2-4-14: Initial commit

Future Updates
-----

- More customizable features
- More notification types than just new posts

Credits
-----

This plugin was created and maintained by Jared Helgeson of [wphax](http://wphax.com). I am accepting feature requests, send an email to [info@wphax.com](mailto:info@wphax.com) to contact me.