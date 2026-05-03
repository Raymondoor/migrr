<?php namespace Raymondoor\Migrr\Schema\DataType;
use Raymondoor\Migrr\Schema\ColumnConstraint\ColumnConstraint;
use Raymondoor\Migrr\Schema\Schema;
abstract class DataType{
    public Schema $schema;
    public string $columnDef;
    public function __construct(Schema $schema, string $columnDef){
        $this->columnDef = $columnDef;
        $this->schema = $schema;
    }
    abstract public function __call($method, $args):ColumnConstraint;
    abstract public function custom(string $rawtype):ColumnConstraint;
}