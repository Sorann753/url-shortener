# URL Shortener

Url Shortener is a website which let you shorten an url, and if you're logged in, it is saved and you can share it with your friends.
if you are logged in you can also upload a file and get an url to download it.

## MySQL Database

As a demo, we left a folder named `database` which contain a zip folder to create the database with a default user called `test` with one url saved to test our services.

## Tables relationship

![Tables relationship](./diagram/database_diagram.png)

## Configuration of PDO

To configure your PDO to communicate with your database. Put your config in `config/database_example_conf.php` and once done, rename the file `database.conf.php`.
Our project works on both Nginx and Apache.

### Logs

We have a log system. So, if you have an error, go to `logs/` to find it.

# Hope you like it !

Enjoy ✨
