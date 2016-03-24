Installation
------------

Installation will not be necessary, the system will be hosted at:
jordanlord.zapto.org/league-system.

However, if you are wanting to host the system yourself, please follow
the following steps. The following will show you how to install on a
GNU/Linux based server; the steps should mostly be the same for other
operating systems.

Requirements:
 - Git
 - PHP version 5.5 or later
 - MySQL version 14 or later

The first step is to clone the repository from GitHub. You must be in
the `var/www/` directory, or elsewhere depending on how your webserver
is setup.

`$ git clone https://github.com/logiclogue/A2-Project-League-System.git`

You should now have a folder called `A2-Project-League-System/` you may
rename it to whatever you want. The domain name that you are using must
be pointed to your server and redirected to the location of
`A2-Project-League-System/`.

A database must be setup for the system. To do this, log into MySQL and
create a database for the system using the following command:

`mysql> CREATE DATABASE squash-league-system;`

You can call the database whatever you want.

Create a file called `env.json` is the root of
`A2-Project-League-System`. This file will be read by the system to
connect to the database. It must be structured in the following manner:

    {
        "database": {
            "servername": "<Name of your server>",
            "username": "<username for MySQL>",
            "password": "<Password for MySQL>",
            "database": "<Name of the database for the system>"
        }
    }

Once you have `env.json` setup, you must now test to see if the system
is working. The unit tests will also generate all the tables in the
database. To do this, you must visit the URL that directs us to the web
application, using a web browser visit:
`http://localhost/A2-Project-League-System/php/Test.php`. Obviously this
URL will be different depending on what domain name you have pointing to
your server. You will see a list of all the unit tests. If they are all
highlighted green, then you are good to go!

Beware, hackers can easily execute `Test.php` to reset the server!
`Test.php` **MUST BE DELETED**!

Congratulations, you have successfully installed the Squash League
System!