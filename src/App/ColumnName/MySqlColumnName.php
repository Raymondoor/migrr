<?php namespace Raymondoor\Migrr\App\ColumnName;
use Raymondoor\Migrr\App\ColumnConstraint\MySqlColumnConstraint;
use Raymondoor\Migrr\App\DataType\MySqlDataType;
use Raymondoor\Migrr\App\Schema\Schema;
class MySqlColumnName extends ColumnName{
    public array $unavailables = [
        'order',
    ];
    
    public function __construct(Schema $schema){
        $this->schema = $schema;
    }
    public function name(string $columnName):MySqlDataType{
        $this->columnDef .= $columnName.' ';
        return new MySqlDataType($this->schema,$this->columnDef);
    }
    public function id_template():MySqlColumnConstraint{
        $this->columnDef = 'id ';
        return ((new MySqlDataType($this->schema,$this->columnDef))->int()
            ->primaryKey()->identity());
    }
    public function created_at_template(bool $tz = false,int $precision = 6):MySqlColumnConstraint{
        $this->columnDef = 'created_at ';
        return (new MySqlDataType($this->schema,$this->columnDef)->timestamp($tz,$precision)->default('CURRENT_TIMESTAMP',true));
    }
}