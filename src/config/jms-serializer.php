<?php

return [
    'debug' => true,
    'cache_dir' => base_path('storage/framework/cache/jms-serializer'),

    'naming_strategy' => [
      'default' => 'annotation',
      'annotation_delegate' => 'identical',
      'cache_delegate' => 'annotation',
    ],

    'default_handlers' => true,
    'default_serialization_visitors' => true,
    'default_deserialization_visitors' => true,
    'default_listeners' => true,

    'custom_handlers' => [
        // add custom handlers here
        // example: uncomment below to serialize DateTime into timestamp for json
        /*[
            'direction' => 'serialization',
            'type' => 'DateTime',
            'format' => 'json',
            'handler' =>
                function($visitor, \DateTime $obj, array $type) {
                    return $obj->getTimestamp();
                }
        ],*/
    ],
];