<?php namespace Raymondoor\Migrr\Schema\ColumnName;
use Raymondoor\Migrr\Schema\ColumnConstraint\ColumnConstraint;
use Raymondoor\Migrr\Schema\DataType\DataType;
use Raymondoor\Migrr\Schema\Schema;
abstract class ColumnName{
    public array $unavailables = [
        'order',
    ];
    private Schema $schema;
    public $columnDef;
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    abstract public function name(string $columnName):DataType;
    abstract public function id_template():ColumnConstraint;
    abstract public function created_at_template(bool $tz = false,int $precision = 6):ColumnConstraint;
}