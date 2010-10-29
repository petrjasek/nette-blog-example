<?php

/**
 * My Application bootstrap file.
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */


use Nette\Debug;
use Nette\Environment;
use Nette\Application\Route;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;


// Step 1: Load Nette Framework
// this allows load Nette Framework classes automatically so that
// you don't have to litter your code with 'require' statements
require LIBS_DIR . '/Nette/Nette/loader.php';



// Step 2: Configure environment
// 2a) enable Nette\Debug for better exception and error visualisation
Debug::$strictMode = TRUE;
Debug::enable();

// 2b) load configuration from config.ini file
Environment::loadConfig();



// Step 3: Configure application
// 3a) get and setup a front controller
$application = Environment::getApplication();
$application->errorPresenter = 'Error';
//$application->catchExceptions = TRUE;



// Step 4: Setup application router
$router = $application->getRouter();

$router[] = new Route('index.php', array(
	'presenter' => 'Homepage',
	'action' => 'default',
), Route::ONE_WAY);

$router[] = new Route('<presenter>/<action>/<id>', array(
	'presenter' => 'Homepage',
	'action' => 'default',
	'id' => NULL,
));

// setup Doctrine
$config = new Configuration;
$metadata = $config->newDefaultAnnotationDriver(APP_DIR . '/models');
$config->setMetadataDriverImpl($metadata);
$config->setProxyNamespace('Blog\Proxy');
$config->setProxyDir(APP_DIR . '/proxy');
$em = EntityManager::create((array) Environment::getConfig('database'),
    $config);

// Step 5: Run the application!
$application->run();
