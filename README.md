# Installation
```
$ git clone git@github.com:cwansart/Zento.git
$ cd Zento
$ cp .env.example .env
$ php artisan key:generate
```
dann die .env die Variablen `DB_DATABASE`, `DB_USERNAME`, und `DB_PASSWORD` anpassen und anschließend die Migration mit den Seedern ausführen:
```
$ php artisan migrate --seed
```
