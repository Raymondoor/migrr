<?php namespace Raymondoor\Migrr\Schema\DataType;
use Raymondoor\Migrr\Schema\ColumnConstraint\ColumnConstraint;
use Raymondoor\Migrr\Schema\Schema;
class DataType{
    public Schema $schema;
    public string $columnDef;
    public function __construct(Schema $schema, string $columnDef){
        $this->columnDef = $columnDef;
        $this->schema = $schema;
    }
    public function int(){
        $this->columnDef .='INTEGER ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function text(){
        $this->columnDef .='TEXT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function real(){
        $this->columnDef .='REAL ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function blob(){
        $this->columnDef .='BLOB ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function numeric(int $precision = 10, int $scale = 2){
        $this->columnDef .='NUMERIC('.$precision.','.$scale.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
}