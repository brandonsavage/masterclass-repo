# Object Oriented PHP Masterclass Repository

Welcome to the code repository for the Object Oriented PHP Masterclass.

You will use this repository to complete the lessons which you will receive daily over the next few weeks.

Warnings and Disclaimers
------------------------

THIS CODE IS PROVIDED WITH NO WARRANTY. IT HAS NOT BEEN SECURITY REVIEWED AND CONTAINS KNOWN SECURITY VULNERABILITIES. DO NOT RUN THIS CODE IN PRODUCTION ENVIRONMENTS.

Installing This Codebase
------------------------

This code base uses Vagrant. To install the code base, use these steps:

# Run `composer install`
# Run `php vendor/bin/homestead make`
# Edit the Homestead.yaml file to your desired configuration settings.
# Run `vagrant up`
# Copy the config.php-init file to config.php. Set the user to 'root' and the password to 'secret'. I use 'localhost' and 'masterclass' as hostname and database name.
# Use `vagrant ssh` to log into the box.
# Use `mysql -uroot -p` to login into MySQL.
# Use `CREATE DATABASE masterclass; USE masterclass; source /home/vagrant/masterclass-repo/schema.sql;` to create the database.
# Navigate to the install in your web browser. You should see the app, and be able to create an account.