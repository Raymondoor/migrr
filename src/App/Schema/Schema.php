<?php namespace Raymondoor\Migrr\App\Schema;
use Raymondoor\Migrr\App\ColumnName\ColumnName;
abstract class Schema{
    public string $query = '';
    public string $driver = '';
    abstract public function __construct();
    abstract public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""):Schema;
    abstract public function alter_table(string $table):Schema;
    abstract public function raw(string $sql):Schema;
    // public function raw(string $sql):Schema{
    //     $this->query .= $sql.' ';
    //     return $this;
    // }
    abstract public function columns():ColumnName;
    abstract public function end():Schema;
    // public function end():Schema{
    //     $this->query = trim($this->query);
    //     $this->query .=';';
    //     return $this;
    // }
}