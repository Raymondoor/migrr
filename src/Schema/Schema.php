<?php namespace Raymondoor\Migrr\Schema;
use Raymondoor\Migrr\Schema\ColumnName\PostgresColumnName;

abstract class Schema{
    public string $query = "";
    public string $driver = "";
    public function __construct(){}
    abstract public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""):Schema;
    abstract public function alter_table(string $table):Schema;
    public function raw(string $sql){
        $this->query .= $sql.' ';
        return $this;
    }
    public function columns(){
        $this->query .= '(';
        return match($this->driver){
            'pgsql' => new PostgresColumnName($this),
            'mysql' => new MySqlColumnName($this),
            'sqlite' => new SqliteColumnName($this),
            default => throw new \Exception("Unknown driver: $this->driver")
        };
    }
    public function end(){
        $this->query = trim($this->query);
        $this->query.=';';
    }
}