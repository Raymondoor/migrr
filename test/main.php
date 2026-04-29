<?php require_once(__DIR__.'/../vendor/autoload.php');
use Raymondoor\Migrr\Schema\SchemaFactory;

// Example 1: Simple table with int and text
$schema = SchemaFactory::create('pgsql');
$schema->create_table('tests',true)
    ->columns()
        ->name('foo')->int()->notnull()
        ->nextcolumn('bar')->text()
    ->endcolumns()
->end();
echo "Example 1 (tests):\n";
echo $schema->query . "\n\n";

// Example 2: Users table with more constraints
$schema2 = SchemaFactory::create('pgsql');
$schema2->create_table('users',true)
    ->columns()
        ->name('id')->int()->primaryKey()->notnull()
        ->nextcolumn('email')->text()->unique()->notnull()
        ->nextcolumn('username')->text()->notnull()
        ->nextcolumn('age')->int()
    ->endcolumns()
->end();
echo "Example 2 (users):\n";
echo $schema2->query . "\n\n";

// Example 3: Products table with default values
$schema3 = SchemaFactory::create('pgsql');
$schema3->create_table('products',true)
    ->columns()
        ->name('id')->int()->primaryKey()
        ->nextcolumn('name')->text()->notnull()
        ->nextcolumn('price')->real()->check('price > 0')
        ->nextcolumn('status')->text()->default('active')
    ->endcolumns()
->end();
echo "Example 3 (products):\n";
echo $schema3->query . "\n\n";

// Example 4: SQLite version
$schema4 = SchemaFactory::create('sqlite');
$schema4->create_table('orders')
    ->columns()
        ->name('id')->int()->primaryKey()->autoincrement()
        ->nextcolumn('product_id')->int()->notnull()
        ->nextcolumn('quantity')->int()->default(1)
        ->nextcolumn('total')->real()
    ->endcolumns()
->end();
echo "Example 4 (orders - SQLite):\n";
echo $schema4->query . "\n";