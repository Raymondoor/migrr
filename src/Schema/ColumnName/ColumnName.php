<?php namespace Raymondoor\Migrr\Schema\ColumnName;
use Raymondoor\Migrr\Schema\DataType\DataType;
use Raymondoor\Migrr\Schema\Schema;
class ColumnName{
    public array $unavailables = [
        'order',
    ];
    private Schema $schema;
    public $columnDef;
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    public function name(string $columnName){
        $this->columnDef .= $columnName.' ';
        return new DataType($this->schema,$this->columnDef);
    }
}