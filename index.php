<?php

use Mateodioev\MultiLang\Cache\InMemoryCache;
use Mateodioev\MultiLang\Injector\NativeInjector;
use Mateodioev\MultiLang\Lang;

require __DIR__ . '/vendor/autoload.php';

$injector = new NativeInjector();
$injector->for('author', fn () => 'Mateodioev ' . date('Y')); // This will injected in the data accessor
// $injector->for('author', 'Mateodioev ' . date('Y'));

Lang::setup(__DIR__ . '/langs', cache: new InMemoryCache(), injector: $injector);

var_dump(Lang::get('es')->data('about')?->format(['title' => 'Lord of the rings']));

Lang::compareData();
