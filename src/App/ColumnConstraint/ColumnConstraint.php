<?php namespace Raymondoor\Migrr\App\ColumnConstraint;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\DataType\DataType;
use Raymondoor\Migrr\App\ColumnName\ColumnName;
abstract class ColumnConstraint{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function next():Schema{
        $this->columnDef = trim($this->columnDef);
        $this->columnDef .=', ';
        $this->schema->query .= $this->columnDef;
        return $this->schema;
    }
    public function nextColumn():ColumnName{
        return $this->makeColumnName();
    }
    public function nextColumnName(string $columnName):DataType{
        return $this->makeColumnName()->name($columnName);
    }
    abstract public function makeColumnName():ColumnName;
    public function endColumns():Schema{
        $this->schema->query .= trim($this->columnDef);
        $this->schema->query .= ') ';
        return $this->schema;
    }
    public function unique():ColumnConstraint{
        $this->columnDef .='UNIQUE ';
        return $this;
    }
    public function notnull():ColumnConstraint{
        $this->columnDef .='NOT NULL ';
        return $this;
    }
    public function primaryKey():ColumnConstraint{
        $this->columnDef .='PRIMARY KEY ';
        return $this;
    }
    public function foreignKey(string $referenceTable, string $referenceColumn):ColumnConstraint{
        $this->columnDef .='REFERENCES '.$referenceTable.'('.$referenceColumn.') ';
        return $this;
    }
    public function check(string $condition):ColumnConstraint{
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function default(string $value, bool $raw = false):ColumnConstraint{
        $value = ($raw) ? $value : "'".$value."'";
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement():ColumnConstraint{
        $this->columnDef .='AUTOINCREMENT ';
        return $this;
    }
}