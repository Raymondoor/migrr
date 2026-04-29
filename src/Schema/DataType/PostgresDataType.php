<?php namespace Raymondoor\Migrr\Schema\DataType;
use Raymondoor\Migrr\Schema\ColumnConstraint\ColumnConstraint;
use Raymondoor\Migrr\Schema\Schema;
class PostgresDataType{
    public Schema $schema;
    public string $columnDef;
    public function __construct(Schema $schema, string $columnDef){
        $this->columnDef = $columnDef;
        $this->schema = $schema;
    }
    // Numeric
    public function int(){  
        $this->columnDef .='INTEGER ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function int32(){  
        $this->columnDef .='INTEGER ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallint(){
        $this->columnDef .='SMALLINT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function int16(){
        $this->columnDef .='SMALLINT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigint(){
        $this->columnDef .='BIGINT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function int64(){
        $this->columnDef .='BIGINT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function decimal(int $precision = 10, int $scale = 2){
        $this->columnDef .='DECIMAL('.$precision.','.$scale.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function numeric(){
        $this->columnDef .='NUMERIC ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function real(int $precision = 10, int $scale = 2){
        $this->columnDef .='REAL('.$precision.','.$scale.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function double_precision(){
        $this->columnDef .='DOUBLE PRECISION ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function smallserial(){
        $this->columnDef .='SMALLSERIAL ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function serial(){
        $this->columnDef .='SERIAL ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function bigserial(){
        $this->columnDef .='BIGSERIAL ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Monetary
    public function money(){
        $this->columnDef .='MONEY ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Character
    public function varchar(int $limit){
        $this->columnDef .='VARCHAR('.$limit.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function char(int $length){
        $this->columnDef .='CHAR('.$length.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function bpchar(){
        $this->columnDef .='BPCHAR ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function text(){
        $this->columnDef .='TEXT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Binary
    public function bytea(){
        $this->columnDef .='BYTEA ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Rate/Time
    public function timestamp(bool $tz = false, int $precision = 6){
        if($precision > 6 || $precision < 0){
            throw new \Exception('Timestamp precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIMESTAMP'.$prq.$tzq;
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function date(){
        $this->columnDef .= 'DATE ';
    }
    public function time(bool $tz = false, int $precision = 6){
        if($precision > 6 || $precision < 0){
            throw new \Exception('Time precision should range from 0 to 6.');
        }
        $tzq = $tz ? 'WITH TIME ZONE ' : ' ';
        $prq = $precision===6 ? ' ' : '('.(string)$precision.') ';
        $this->columnDef .='TIME'.$prq.$tzq;
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function interval(string $field, int $precision = 6){
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
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Boolean
    public function bool(){
        $this->columnDef .= 'BOOLEAN ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Enumerated
    public function enum(string $datatype){
        $this->columnDef .= $datatype.' ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Geometric
    public function point(){
        $this->columnDef .= 'POINT ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function line(){
        $this->columnDef .= 'LINE ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function lseg(){
        $this->columnDef .= 'LSEG ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function box(){
        $this->columnDef .= 'BOX ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function path(){
        $this->columnDef .= 'PATH ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function polygon(){
        $this->columnDef .= 'POLYGON ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function circle(){
        $this->columnDef .= 'CIRCLE ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Network Addr
    public function cidr(){
        $this->columnDef .= 'CIDR ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function inet(){
        $this->columnDef .= 'INET ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr(){
        $this->columnDef .= 'MACADDR ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function macaddr8(){
        $this->columnDef .= 'MACADDR8 ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Bit String
    public function bit(int $length,bool $varying=false){
        if($length < 0){
            throw new \InvalidArgumentException('Length cannot be a negative number.');
        }
        $this->columnDef .= 'BIT';
        $this->columnDef .= $varying ? ' VARYING':'';
        $this->columnDef .= '('.$length.') ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    // Json
    public function json(){
        $this->columnDef .= 'JSON ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
    public function jsonb(){
        $this->columnDef .= 'JSONB ';
        return new ColumnConstraint($this->schema,$this->columnDef);
    }
}