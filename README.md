# Installation
```
$ git clone git@github.com:cwansart/Zento.git
$ cd Zento
$ composer install
$ cp .env.example .env
$ php artisan key:generate
```
dann die .env die Variablen `DB_DATABASE`, `DB_USERNAME`, und `DB_PASSWORD` anpassen und anschließend die Migration mit den Seedern ausführen:
```
$ php artisan migrate --seed
```
Zum ausführen des Schedulers zur Terminerinnerung muss ein Cronjob angelegt werden. Dazu Cron mit
```
$ crontab -e
```
öffnen und die Zeile
```
* * * * * php <Pfad zu Artisan>/artisan schedule:run >> /dev/null 2>&1
```
eintragen.
