<?php

require 'public/bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app->get('doctrine_manager'));

