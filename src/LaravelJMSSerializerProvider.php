<?php namespace Pwm\LaravelJMSSerializer;

use JMS\Serializer;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;

class LaravelJMSSerializerProvider extends ServiceProvider {

    public function register()
    {
        // pull in config from app merged with package
        $config = $this->app['config']['jms-serializer'];

        // register JMS annotations
        AnnotationRegistry::registerFile(
            base_path('vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php')
        );
        AnnotationRegistry::registerAutoloadNamespace(
            'JMS\Serializer\Annotation',
            base_path('vendor/jms/serializer/src')
        );

        // set up naming strategies as per config
        $this->app->bind('serializer.naming-strategy.identical', Serializer\Naming\IdenticalPropertyNamingStrategy::class);
        $this->app->bind('serializer.naming-strategy.camel-case', Serializer\Naming\CamelCaseNamingStrategy::class);
        $this->app->bind('serializer.naming-strategy.annotation', function() use ($config) {
            return new Serializer\Naming\SerializedNameAnnotationStrategy(
                $this->app->make('serializer.naming-strategy.'.$config['naming_strategy']['annotation_delegate'])
            );
        });
        $this->app->bind('serializer.naming-strategy.cache', function() use ($config) {
            return new Serializer\Naming\CacheNamingStrategy(
                $this->app->make('serializer.naming-strategy.'.$config['naming_strategy']['cache_delegate'])
            );
        });

        // build serializer
        $this->app->singleton(Serializer\Serializer::class,function() use ($config) {
            $builder = new Serializer\SerializerBuilder();
            $builder->setDebug($config['debug']);
            $builder->setCacheDir($config['cache_dir']);
            $builder->setPropertyNamingStrategy(
                $this->app->make('serializer.naming-strategy.'.$config['naming_strategy']['default'])
            );
            if ($config['default_handlers']) $builder->addDefaultHandlers();
            $builder->configureHandlers(function(Serializer\Handler\HandlerRegistry $registry) {
                $registry->registerHandler('serialization', 'DateTime', 'json',
                    function($visitor, \DateTime $obj, array $type) {
                        return $obj->getTimestamp();
                    }
                );
            });
            if ($config['default_serialization_visitors']) $builder->addDefaultSerializationVisitors();
            if ($config['default_deserialization_visitors']) $builder->addDefaultDeserializationVisitors();
            if ($config['default_listeners']) $builder->addDefaultListeners();
            return $builder->build();
        });

        // for easy access
        $this->app->singleton('serializer', Serializer\Serializer::class);

        $this->mergeConfigFrom(
            __DIR__.'/config/jms-serializer.php', 'jms-serializer.php'
        );
    }

    public function boot() {
        $this->publishes([
            __DIR__.'/config/jms-serializer.php' => config_path('jms-serializer.php'),
        ]);
    }

}