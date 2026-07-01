<?php namespace Raymondoor\Migrr\App\DataType;
use Raymondoor\Migrr\App\ColumnConstraint\SqliteColumnConstraint;
use Raymondoor\Migrr\App\Schema\Schema;
class SqliteDataType extends DataType{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function custom(string $rawtype):SqliteColumnConstraint{
        $this->columnDef .=$rawtype.' ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Numeric
    public function int():SqliteColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function int32():SqliteColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallint():SqliteColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function int16():SqliteColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigint():SqliteColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function int64():SqliteColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function decimal(int $precision = 10, int $scale = 2):SqliteColumnConstraint{
        $this->columnDef .='DECIMAL('.$precision.','.$scale.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function numeric(int $precision = 10, int $scale = 2):SqliteColumnConstraint{
        $this->columnDef .='NUMERIC('.$precision.','.$scale.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function real(int $precision = 10, int $scale = 2):SqliteColumnConstraint{
        $this->columnDef .='REAL('.$precision.','.$scale.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function double_precision():SqliteColumnConstraint{
        $this->columnDef .='DOUBLE PRECISION ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallserial():SqliteColumnConstraint{
        $this->columnDef .='SMALLSERIAL ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function serial():SqliteColumnConstraint{
        $this->columnDef .='SERIAL ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigserial():SqliteColumnConstraint{
        $this->columnDef .='BIGSERIAL ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Monetary
    public function money():SqliteColumnConstraint{
        $this->columnDef .='MONEY ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Character
    public function varchar(int $limit):SqliteColumnConstraint{
        $this->columnDef .='VARCHAR('.$limit.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function char(int $length):SqliteColumnConstraint{
        $this->columnDef .='CHAR('.$length.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function bpchar():SqliteColumnConstraint{
        $this->columnDef .='BPCHAR ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function text():SqliteColumnConstraint{
        $this->columnDef .='TEXT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Binary
    public function bytea():SqliteColumnConstraint{
        $this->columnDef .='BYTEA ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Rate/Time
    public function timestamp(bool $tz = false, int $precision = 6):SqliteColumnConstraint{
        if($precision > 6 || $precision < 0){
            throw new \Exception('Timestamp precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIMESTAMP'.$prq.$tzq;
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function date():SqliteColumnConstraint{
        $this->columnDef .= 'DATE ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function time(bool $tz = false, int $precision = 6):SqliteColumnConstraint{
        if($precision > 6 || $precision < 0){
            throw new \Exception('Time precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIME'.$prq.$tzq;
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function interval(string $field, int $precision = 6):SqliteColumnConstraint{
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
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Boolean
    public function bool():SqliteColumnConstraint{
        $this->columnDef .= 'BOOLEAN ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Enumerated
    public function enum(string $datatype):SqliteColumnConstraint{
        $this->columnDef .= $datatype.' ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Geometric
    public function point():SqliteColumnConstraint{
        $this->columnDef .= 'POINT ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function line():SqliteColumnConstraint{
        $this->columnDef .= 'LINE ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function lseg():SqliteColumnConstraint{
        $this->columnDef .= 'LSEG ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function box():SqliteColumnConstraint{
        $this->columnDef .= 'BOX ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function path():SqliteColumnConstraint{
        $this->columnDef .= 'PATH ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function polygon():SqliteColumnConstraint{
        $this->columnDef .= 'POLYGON ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function circle():SqliteColumnConstraint{
        $this->columnDef .= 'CIRCLE ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Network Addr
    public function cidr():SqliteColumnConstraint{
        $this->columnDef .= 'CIDR ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function inet():SqliteColumnConstraint{
        $this->columnDef .= 'INET ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr():SqliteColumnConstraint{
        $this->columnDef .= 'MACADDR ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr8():SqliteColumnConstraint{
        $this->columnDef .= 'MACADDR8 ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Bit String
    public function bit(int $length,bool $varying=false):SqliteColumnConstraint{
        if($length < 0){
            throw new \InvalidArgumentException('Length cannot be a negative number.');
        }
        $this->columnDef .= 'BIT';
        $this->columnDef .= $varying ? ' VARYING':'';
        $this->columnDef .= '('.$length.') ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    // Json
    public function json():SqliteColumnConstraint{
        $this->columnDef .= 'JSON ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
    public function jsonb():SqliteColumnConstraint{
        $this->columnDef .= 'JSONB ';
        return new SqliteColumnConstraint($this->schema,$this->columnDef);
    }
}