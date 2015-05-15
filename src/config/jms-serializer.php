<?php

return [
    'debug' => true,
    'cache_dir' => base_path('storage/framework/cache/jms-serializer'),

    // identical | camel-case | annotation | 'any custom service registered at serializer.naming-strategy.'
    'naming_strategy' => [
      'default' => 'annotation',
      'annotation_delegate' => 'identical',
      'cache_delegate' => 'annotation',
    ],

    'default_handlers' => true,
    'default_serialization_visitors' => true,
    'default_deserialization_visitors' => true,
    'default_listeners' => true,

];