<?php namespace Raymondoor\Migrr\Schema\ColumnConstraint;
use Raymondoor\Migrr\Schema\ColumnName\ColumnName;
use Raymondoor\Migrr\Schema\Schema;
class ColumnConstraint{
    public Schema $schema;
    public string $columnDef;
    public function __construct(Schema $schema, string $columnDef){
        $this->columnDef = $columnDef;
        $this->schema = $schema;
    }
    public function nextcolumn(string $columnName){
        $this->columnDef = trim($this->columnDef);
        $this->columnDef .=', ';
        $this->schema->query .= $this->columnDef;
        return (new ColumnName($this->schema))->name($columnName);
    }
    public function endcolumns(){
        $this->schema->query .= trim($this->columnDef);
        $this->schema->query .= ') ';
        return $this->schema;
    }
    public function unique(){
        $this->columnDef .='UNIQUE ';
        return $this;
    }
    public function notnull(){
        $this->columnDef .='NOT NULL ';
        return $this;
    }
    public function primaryKey(){
        $this->columnDef .='PRIMARY KEY ';
        return $this;
    }
    public function check(string $condition){
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function default(mixed $value){
        $value = is_string($value) ? "'".$value."'" : $value;
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement(){
        $this->columnDef .='AUTOINCREMENT ';
        return $this;
    }
}