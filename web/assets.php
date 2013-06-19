<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
require dirname(__FILE__).'/../assets.php';

/* Get Application
-------------------------------*/
print assets()

/* Set Autoload
-------------------------------*/
->setLoader(NULL, '/library')

<<<<<<< HEAD
=======
/* Start Filters
-------------------------------*/
->setFilters()
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f

/* Trigger Init Event
-------------------------------*/
->trigger('init')

/* Get the Response
-------------------------------*/
->getResponse();