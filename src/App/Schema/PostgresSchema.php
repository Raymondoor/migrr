<?php namespace Raymondoor\Migrr\App\Schema;
use Raymondoor\Migrr\App\ColumnName\PostgresColumnName;
class PostgresSchema extends Schema{
    public function __construct(
        public string $driver = 'pgsql',
        public string $query = ''
    ){}
    public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""):PostgresSchema{
        if(empty($this->query)){
            $this->query.='CREATE ';
            if($temp){
                $this->query.='TEMPORARY ';
            }
            if(!empty($optionsRaw)){
                $this->query.= $optionsRaw.' ';
            }
            $this->query.= 'TABLE ';
            if($ifNotExist){
                $this->query.= 'IF NOT EXISTS ';
            }
            $this->query.= $name.' ';
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.', should be ran first.');
        }
        return $this;
    }
    public function alter_table(string $table):PostgresSchema{
        if(empty($this->query)){
            $this->query.=$table;
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.', should be ran first.');
        }
        return $this;
    }
    public function raw(string $sql):PostgresSchema{
        $this->query .= $sql;
        return $this;
    }
    public function columns():PostgresColumnName{
        $this->query .= '(';
        return new PostgresColumnName($this);
    }
    public function end():PostgresSchema{
        $this->query = trim($this->query);
        $this->query.=';';
        return $this;
    }
}