<?php namespace Raymondoor\Migrr\App\ColumnConstraint;
use Raymondoor\Migrr\App\ColumnName\MySqlColumnName;
use Raymondoor\Migrr\App\DataType\MySqlDataType;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\Schema\MySqlSchema;
class MySqlColumnConstraint extends ColumnConstraint{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function next():MySqlSchema{
        $this->columnDef = trim($this->columnDef);
        $this->columnDef .=', ';
        $this->schema->query .= $this->columnDef;
        return $this->schema instanceof MySqlSchema ? $this->schema : throw new \RuntimeException('Invalid schema type');
    }
    public function nextColumn():MySqlColumnName{
        return $this->makeColumnName();
    }
    public function nextColumnName(string $columnName):MySqlDataType{
        return $this->makeColumnName()->name($columnName);
    }
    public function makeColumnName():MySqlColumnName{
        $this->next();
        return new MySqlColumnName($this->schema);
    }
    public function endColumns():MySqlSchema{
        $this->schema->query .= trim($this->columnDef);
        $this->schema->query .= ') ';
        return $this->schema instanceof MySqlSchema ? $this->schema : throw new \RuntimeException('Invalid schema type');
    }
    public function unique():MySqlColumnConstraint{
        $this->columnDef .='UNIQUE ';
        return $this;
    }
    public function notnull():MySqlColumnConstraint{
        $this->columnDef .='NOT NULL ';
        return $this;
    }
    public function primaryKey():MySqlColumnConstraint{
        $this->columnDef .='PRIMARY KEY ';
        return $this;
    }
    public function foreignKey(string $referenceTable, string $referenceColumn):MySqlColumnConstraint{
        $this->columnDef .='REFERENCES '.$referenceTable.'('.$referenceColumn.') ';
        return $this;
    }
    public function identity():MySqlColumnConstraint{
        $this->columnDef .='AUTO_INCREMENT ';
        return $this;
    }
    public function check(string $condition):MySqlColumnConstraint{
        $this->columnDef .='CHECK ('.$condition.') ';
        return $this;
    }
    public function checkName(string $name, string $condition):MySqlColumnConstraint{
        $this->columnDef .='CONSTRAINT '.$name.' CHECK ('.$condition.') ';
        return $this;
    }
    public function default(string $value, bool $raw = false):MySqlColumnConstraint{
        $value = ($raw) ? $value : "'".$value."'";
        $this->columnDef .='DEFAULT '.$value.' ';
        return $this;
    }
    public function autoincrement():MySqlColumnConstraint{
        $this->columnDef .='AUTO_INCREMENT ';
        return $this;
    }
}
