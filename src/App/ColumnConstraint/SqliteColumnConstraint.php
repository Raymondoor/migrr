<?php namespace Raymondoor\Migrr\App\ColumnConstraint;
use Raymondoor\Migrr\App\ColumnName\SqliteColumnName;
use Raymondoor\Migrr\App\DataType\SqliteDataType;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\Schema\SqliteSchema;
class SqliteColumnConstraint extends ColumnConstraint{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function nextColumn():SqliteColumnName{
        return $this->makeColumnName();
    }
    public function nextColumnName(string $columnName):SqliteDataType{
        return $this->makeColumnName()->name($columnName);
    }
    function makeColumnName():SqliteColumnName{
        $this->next();
        return new SqliteColumnName($this->schema);
    }
    public function endColumns():SqliteSchema{
        $this->schema->query .= trim($this->columnDef);
        $this->schema->query .= ') ';
        return $this->schema instanceof SqliteSchema ? $this->schema : throw new \RuntimeException('Invalid schema type');
    }
    public function unique():SqliteColumnConstraint{
        $this->columnDef .='UNIQUE ';
        return $this;
    }
    public function notnull():SqliteColumnConstraint{
        $this->columnDef .='NOT NULL ';
        return $this;
    }
    public function primaryKey():SqliteColumnConstraint{
        $this->columnDef .='PRIMARY KEY ';
        return $this;
    }
    public function foreignKey(string $referenceTable, string $referenceColumn):SqliteColumnConstraint{
        $this->columnDef .='REFERENCES '.$referenceTable.'('.$referenceColumn.') ';
        return $this;
    }
    public function identity():SqliteColumnConstraint{
        $this->columnDef .='GENERATED ALWAYS AS IDENTITY ';
        return $this;
    }
    public function check(string $condition):SqliteColumnConstraint{
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function checkName(string $name, string $condition):SqliteColumnConstraint{
        $this->columnDef .='CONSTRAINT '.$name.' CHECK ('.$condition.') ';
        return $this;
    }
    public function default(string $value, bool $raw = false):SqliteColumnConstraint{
        $value = ($raw) ? $value : "'".$value."'";
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement():SqliteColumnConstraint{
        $this->columnDef .='AUTOINCREMENT ';
        return $this;
    }
}