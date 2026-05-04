<?php namespace Raymondoor\Migrr\Schema;

class MySqlSchema extends Schema{
    // Not implemented yet. do not use.
    public function __construct(){
        parent::__construct();
        $this->driver = 'postgres';
    }
    public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""):MySqlSchema{
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
    public function alter_table(string $table):MySqlSchema{
        if(empty($this->query)){
            $this->query.=$table;
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.', should be ran first.');
        }
        return $this;
    }
    public function raw(string $sql){
        $this->query .= $sql;
    }
    public function end(){
        $this->query = trim($this->query);
        $this->query.=';';
    }
}