<?php namespace Raymondoor\Migrr\Schema\ColumnName;
use Raymondoor\Migrr\Schema\ColumnConstraint\PostgresColumnConstraint;
use Raymondoor\Migrr\Schema\DataType\DataType;
use Raymondoor\Migrr\Schema\DataType\PostgresDataType;
use Raymondoor\Migrr\Schema\Schema;
class PostgresColumnName extends ColumnName{
    public array $unavailables = [
        'order',
    ];
    private Schema $schema;
    public $columnDef;
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    public function name(string $columnName):DataType{
        $this->columnDef .= $columnName.' ';
        return new PostgresDataType($this->schema,$this->columnDef);
    }
    public function id_template():PostgresColumnConstraint{
        $this->columnDef = 'id ';
        return ((new PostgresDataType($this->schema,$this->columnDef))->int()
            ->primaryKey()->identity());
    }
    public function created_at_template(bool $tz = false,int $precision = 6):PostgresColumnConstraint{
        $this->columnDef = 'created_at ';
        return (new PostgresDataType($this->schema,$this->columnDef)->timestamp($tz,$precision)
            ->default('CURRENT_TIMESTAMP',true));
    }
}