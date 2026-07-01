<?php namespace Raymondoor\Migrr\App\ColumnName;
use Raymondoor\Migrr\App\ColumnConstraint\SqliteColumnConstraint;
use Raymondoor\Migrr\App\DataType\SqliteDataType;
use Raymondoor\Migrr\App\Schema\Schema;
class SqliteColumnName extends ColumnName{
    public array $unavailables = [
        'order',
    ];
    
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    public function name(string $columnName):SqliteDataType{
        $this->columnDef .= $columnName.' ';
        return new SqliteDataType($this->schema,$this->columnDef);
    }
    public function id_template():SqliteColumnConstraint{
        $this->columnDef = 'id ';
        return ((new SqliteDataType($this->schema,$this->columnDef))->int())
            ->primaryKey()->identity();
    }
    public function created_at_template(bool $tz = false,int $precision = 6):SqliteColumnConstraint{
        $this->columnDef = 'created_at ';
        return (new SqliteDataType($this->schema,$this->columnDef)->date()
            ->default('CURRENT_TIMESTAMP',true));
    }
}