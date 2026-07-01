<?php require_once(__DIR__.'/../vendor/autoload.php');

// use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\SchemaFactory;

$schema = SchemaFactory::create('pgsql');
$schema->create_table('tests',true)
    ->columns()
        ->id_template()
        ->nextcolumnName('foo')->int()->notnull()
        ->nextcolumnName('bar')->text()->default("A")
        ->nextColumn()->created_at_template(true)
    ->endcolumns()
->end();
echo $schema->query.PHP_EOL;

$schema = SchemaFactory::create('sqlite');
$schema->create_table('tests',true)
    ->columns()
        ->id_template()
        ->nextcolumnName('foo')->int()->notnull()
        ->nextcolumnName('bar')->text()->default("A")
        ->nextColumn()->created_at_template(true)
    ->endcolumns()
->end();
echo $schema->query.PHP_EOL;

$schema = SchemaFactory::create('mysql');
$schema->create_table('tests',true)
    ->columns()
        ->id_template()
        ->nextcolumnName('foo')->int()->notnull()
        ->nextcolumnName('bar')->text()->default("A")
        ->nextColumn()->created_at_template(true)
    ->endcolumns()
->end();
echo $schema->query.PHP_EOL;