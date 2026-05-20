<?php namespace Raymondoor\Migrr\Schema\ColumnConstraint;
use Raymondoor\Migrr\Schema\ColumnName\ColumnName;
use Raymondoor\Migrr\Schema\ColumnName\PostgresColumnName;
use Raymondoor\Migrr\Schema\DataType\PostgresDataType;
use Raymondoor\Migrr\Schema\PostgresSchema;
use Raymondoor\Migrr\Schema\Schema;
class PostgresColumnConstraint extends ColumnConstraint{
    public Schema $schema;
    public string $columnDef;
    public function __construct(Schema $schema, string $columnDef){
        $this->columnDef = $columnDef;
        $this->schema = $schema;
    }
    public function nextColumn():PostgresColumnName{
        return $this->makeColumnName();
    }
    public function nextColumnName(string $columnName):PostgresDataType{
        return $this->makeColumnName()->name($columnName);
    }
    function makeColumnName():PostgresColumnName{
        $this->next();
        return new PostgresColumnName($this->schema);
    }
    public function endColumns():PostgresSchema{
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
    public function foreignKey(string $referenceTable, string $referenceColumn){
        $this->columnDef .='REFERENCES '.$referenceTable.'('.$referenceColumn.') ';
        return $this;
    }
    public function identity(){
        $this->columnDef .='GENERATED ALWAYS AS IDENTITY ';
        return $this;
    }
    public function check(string $condition){
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function default(string $value, bool $raw = false){
        $value = ($raw) ? $value : "'".$value."'";
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement(){
        $this->columnDef .='AUTOINCREMENT ';
        return $this;
    }
}