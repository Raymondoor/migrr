<?php namespace Raymondoor\Migrr\App\DataType;
use Raymondoor\Migrr\App\ColumnConstraint\PostgresColumnConstraint;
use Raymondoor\Migrr\App\Schema\Schema;
class PostgresDataType extends DataType{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function custom(string $rawtype):PostgresColumnConstraint{
        $this->columnDef .=$rawtype.' ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Numeric
    public function int():PostgresColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function int32():PostgresColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallint():PostgresColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function int16():PostgresColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigint():PostgresColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function int64():PostgresColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function decimal(int $precision = 10, int $scale = 2):PostgresColumnConstraint{
        $this->columnDef .='DECIMAL('.$precision.','.$scale.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function numeric(int $precision = 10, int $scale = 2):PostgresColumnConstraint{
        $this->columnDef .='NUMERIC('.$precision.','.$scale.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function real(int $precision = 10, int $scale = 2):PostgresColumnConstraint{
        $this->columnDef .='REAL('.$precision.','.$scale.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function double_precision():PostgresColumnConstraint{
        $this->columnDef .='DOUBLE PRECISION ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallserial():PostgresColumnConstraint{
        $this->columnDef .='SMALLSERIAL ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function serial():PostgresColumnConstraint{
        $this->columnDef .='SERIAL ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigserial():PostgresColumnConstraint{
        $this->columnDef .='BIGSERIAL ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Monetary
    public function money():PostgresColumnConstraint{
        $this->columnDef .='MONEY ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Character
    public function varchar(int $limit):PostgresColumnConstraint{
        $this->columnDef .='VARCHAR('.$limit.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function char(int $length):PostgresColumnConstraint{
        $this->columnDef .='CHAR('.$length.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function bpchar():PostgresColumnConstraint{
        $this->columnDef .='BPCHAR ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function text():PostgresColumnConstraint{
        $this->columnDef .='TEXT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Binary
    public function bytea():PostgresColumnConstraint{
        $this->columnDef .='BYTEA ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Rate/Time
    public function timestamp(bool $tz = false, int $precision = 6):PostgresColumnConstraint{
        if($precision > 6 || $precision < 0){
            throw new \Exception('Timestamp precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIMESTAMP'.$prq.$tzq;
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function date():PostgresColumnConstraint{
        $this->columnDef .= 'DATE ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function time(bool $tz = false, int $precision = 6):PostgresColumnConstraint{
        if($precision > 6 || $precision < 0){
            throw new \Exception('Time precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIME'.$prq.$tzq;
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function interval(string $field, int $precision = 6):PostgresColumnConstraint{
        $availableFields = ['YEAR','MONTH','DAY','HOUR','MINUTE','SECOND','YEAR TO MONTH','DAY TO HOUR','DAY TO MINUTE','DAY TO SECOND','HOUR TO MINUTE','HOUR TO SECOND','MINUTE TO SECOND'];
        if($precision > 6 || $precision < 0){
            throw new \Exception('Interval precision should range from 0 to 6.');
        }
        $fieldUpper = strtoupper($field);
        if(!in_array($fieldUpper, $availableFields)){
            throw new \Exception('Invalid interval field: '.$field.'. Valid options are: '.implode(', ', $availableFields));
        }
        $prq = $precision ===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='INTERVAL '.$fieldUpper.$prq;
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Boolean
    public function bool():PostgresColumnConstraint{
        $this->columnDef .= 'BOOLEAN ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Enumerated
    public function enum(string $datatype):PostgresColumnConstraint{
        $this->columnDef .= $datatype.' ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Geometric
    public function point():PostgresColumnConstraint{
        $this->columnDef .= 'POINT ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function line():PostgresColumnConstraint{
        $this->columnDef .= 'LINE ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function lseg():PostgresColumnConstraint{
        $this->columnDef .= 'LSEG ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function box():PostgresColumnConstraint{
        $this->columnDef .= 'BOX ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function path():PostgresColumnConstraint{
        $this->columnDef .= 'PATH ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function polygon():PostgresColumnConstraint{
        $this->columnDef .= 'POLYGON ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function circle():PostgresColumnConstraint{
        $this->columnDef .= 'CIRCLE ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Network Addr
    public function cidr():PostgresColumnConstraint{
        $this->columnDef .= 'CIDR ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function inet():PostgresColumnConstraint{
        $this->columnDef .= 'INET ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr():PostgresColumnConstraint{
        $this->columnDef .= 'MACADDR ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr8():PostgresColumnConstraint{
        $this->columnDef .= 'MACADDR8 ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Bit String
    public function bit(int $length,bool $varying=false):PostgresColumnConstraint{
        if($length < 0){
            throw new \InvalidArgumentException('Length cannot be a negative number.');
        }
        $this->columnDef .= 'BIT';
        $this->columnDef .= $varying ? ' VARYING':'';
        $this->columnDef .= '('.$length.') ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    // Json
    public function json():PostgresColumnConstraint{
        $this->columnDef .= 'JSON ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
    public function jsonb():PostgresColumnConstraint{
        $this->columnDef .= 'JSONB ';
        return new PostgresColumnConstraint($this->schema,$this->columnDef);
    }
}