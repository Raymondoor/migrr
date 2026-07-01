<?php namespace Raymondoor\Migrr\App\DataType;
use Raymondoor\Migrr\App\ColumnConstraint\MySqlColumnConstraint;
use Raymondoor\Migrr\App\Schema\Schema;
class MySqlDataType extends DataType{
    public function __construct(public Schema $schema, public string $columnDef){}
    public function custom(string $rawtype):MySqlColumnConstraint{
        $this->columnDef .=$rawtype.' ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    // Numeric
    public function int():MySqlColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function int32():MySqlColumnConstraint{
        $this->columnDef .='INTEGER ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallint():MySqlColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function int16():MySqlColumnConstraint{
        $this->columnDef .='SMALLINT ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigint():MySqlColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function int64():MySqlColumnConstraint{
        $this->columnDef .='BIGINT ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function decimal(int $precision = 10, int $scale = 2):MySqlColumnConstraint{
        $this->columnDef .='DECIMAL('.$precision.','.$scale.') ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function numeric(int $precision = 10, int $scale = 2):MySqlColumnConstraint{
        $this->columnDef .='NUMERIC('.$precision.','.$scale.') ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function real(int $precision = 10, int $scale = 2):MySqlColumnConstraint{
        $this->columnDef .='REAL('.$precision.','.$scale.') ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function double_precision():MySqlColumnConstraint{
        $this->columnDef .='DOUBLE PRECISION ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallserial():MySqlColumnConstraint{
        $this->columnDef .='SMALLSERIAL ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function serial():MySqlColumnConstraint{
        $this->columnDef .='SERIAL ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigserial():MySqlColumnConstraint{
        $this->columnDef .='BIGSERIAL ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    // Character
    public function varchar(int $limit):MySqlColumnConstraint{
        $this->columnDef .='VARCHAR('.$limit.') ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function char(int $length):MySqlColumnConstraint{
        $this->columnDef .='CHAR('.$length.') ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function text():MySqlColumnConstraint{
        $this->columnDef .='TEXT ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    // Date/Time
    public function timestamp(bool $tz = false, int $precision = 6):MySqlColumnConstraint{
        $this->columnDef .='TIMESTAMP ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function date():MySqlColumnConstraint{
        $this->columnDef .= 'DATE ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    public function time(bool $tz = false, int $precision = 6):MySqlColumnConstraint{
        $this->columnDef .='TIME ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    // Boolean
    public function bool():MySqlColumnConstraint{
        $this->columnDef .= 'BOOLEAN ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
    // Json
    public function json():MySqlColumnConstraint{
        $this->columnDef .= 'JSON ';
        return new MySqlColumnConstraint($this->schema,$this->columnDef);
    }
}
