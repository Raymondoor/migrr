<?php require_once(__DIR__.'/../vendor/autoload.php');
use Raymondoor\Migrr\Schema\SchemaFactory;

// Example 1: Simple table with int and text
$schema = SchemaFactory::create('pgsql');
$schema->create_table('tests',true)
    ->columns()
        ->id_template()
        ->nextcolumnName('foo')->int()->notnull()
        ->nextcolumnName('bar')->text()->default("A")
        ->nextColumn()->created_at_template(true)
    ->endcolumns()
->end();
echo "Example 1 (tests):\n";
echo $schema->query . "\n\n";