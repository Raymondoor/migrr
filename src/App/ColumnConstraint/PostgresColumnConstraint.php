<?php namespace Raymondoor\Migrr\App\ColumnConstraint;
use Raymondoor\Migrr\App\ColumnName\PostgresColumnName;
use Raymondoor\Migrr\App\DataType\PostgresDataType;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
class PostgresColumnConstraint extends ColumnConstraint{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function next():PostgresSchema{
        $this->columnDef = trim($this->columnDef);
        $this->columnDef .=', ';
        $this->schema->query .= $this->columnDef;
        return $this->schema instanceof PostgresSchema ? $this->schema : throw new \RuntimeException('Invalid schema type');
    }
    public function nextColumn():PostgresColumnName{
        return $this->makeColumnName();
    }
    public function nextColumnName(string $columnName):PostgresDataType{
        return $this->makeColumnName()->name($columnName);
    }
    public function makeColumnName():PostgresColumnName{
        $this->next();
        return new PostgresColumnName($this->schema);
    }
    public function endColumns():PostgresSchema{
        $this->schema->query .= trim($this->columnDef);
        $this->schema->query .= ') ';
        return $this->schema instanceof PostgresSchema ? $this->schema : throw new \RuntimeException('Invalid schema type');
    }
    public function unique():PostgresColumnConstraint{
        $this->columnDef .='UNIQUE ';
        return $this;
    }
    public function notnull():PostgresColumnConstraint{
        $this->columnDef .='NOT NULL ';
        return $this;
    }
    public function primaryKey():PostgresColumnConstraint{
        $this->columnDef .='PRIMARY KEY ';
        return $this;
    }
    public function foreignKey(string $referenceTable, string $referenceColumn):PostgresColumnConstraint{
        $this->columnDef .='REFERENCES '.$referenceTable.'('.$referenceColumn.') ';
        return $this;
    }
    public function identity():PostgresColumnConstraint{
        $this->columnDef .='GENERATED ALWAYS AS IDENTITY ';
        return $this;
    }
    public function check(string $condition):PostgresColumnConstraint{
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function checkName(string $name, string $condition):PostgresColumnConstraint{
        $this->columnDef .='CONSTRAINT '.$name.' CHECK ('.$condition.') ';
        return $this;
    }
    public function default(string $value, bool $raw = false):PostgresColumnConstraint{
        $value = ($raw) ? $value : "'".$value."'";
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement():PostgresColumnConstraint{
        $this->columnDef .='AUTOINCREMENT ';
        return $this;
    }
}