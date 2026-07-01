<?php namespace Raymondoor\Migrr\App\DataType;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\ColumnConstraint\ColumnConstraint;
abstract class DataType{
    public function __construct(public Schema $schema, public string $columnDef){}
    abstract public function custom(string $rawtype):ColumnConstraint;
}