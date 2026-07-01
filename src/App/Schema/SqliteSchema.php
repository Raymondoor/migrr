<?php namespace Raymondoor\Migrr\App\Schema;
use Raymondoor\Migrr\App\ColumnName\SqliteColumnName;
class SqliteSchema extends Schema{
    public function __construct(
        public string $driver = 'sqlite',
        public string $query = ''
    ){}
    
    public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""):SqliteSchema{
        if(empty($this->query)){
            $this->query.='CREATE ';
            if($temp){
                $this->query.='TEMPORARY ';
            }
            $this->query.= 'TABLE ';
            if($ifNotExist){
                $this->query.= 'IF NOT EXISTS ';
            }
            $this->query.= $name.' ';
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.' midway, should be ran first.');
        }
        return $this;
    }
    public function alter_table(string $table):SqliteSchema{
        if(empty($this->query)){
            $this->query.=$table;
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.' midway, should be ran first.');
        }
        return $this;
    }
    public function raw(string $sql):SqliteSchema{
        $this->query .= $sql.' ';
        return $this;
    }
    public function columns():SqliteColumnName{
        $this->query .= '(';
        return new SqliteColumnName($this);
    }
    public function end():SqliteSchema{
        $this->query = trim($this->query);
        $this->query.=';';
        return $this;
    }
}