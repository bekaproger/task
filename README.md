# beejee-test

<pre>composer install</pre>

Rename .env to .env.local file and configure database options

Create database tables: 
<pre>vendor/bin/doctrine orm:schema-tool:create</pre>

Run server
<pre>php -S localhost:8000 -t public/</pre>
