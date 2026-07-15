<?php namespace Raymondoor\Migrr\App\ColumnName;
use Raymondoor\Migrr\App\ColumnConstraint\PostgresColumnConstraint;
use Raymondoor\Migrr\App\DataType\PostgresDataType;
use Raymondoor\Migrr\App\Schema\Schema;
class PostgresColumnName extends ColumnName{
    public array $unavailables = [
        'order',
    ];
    
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    public function name(string $columnName):PostgresDataType{
        $this->columnDef .= "\n  ".$columnName.' ';
        return new PostgresDataType($this->schema,$this->columnDef);
    }
    public function id_template():PostgresColumnConstraint{
        return $this->name('id')->bigserial()
            ->primaryKey()->identity();
    }
    public function created_at_template(bool $tz = false,int $precision = 6):PostgresColumnConstraint{
        $this->columnDef = 'created_at ';
        return (new PostgresDataType($this->schema,$this->columnDef)->timestamp($tz,$precision)
            ->default('CURRENT_TIMESTAMP',true));
    }
}