<?php namespace Raymondoor\Migrr\Schema;

class SqliteSchema extends Schema{
    public function __construct(){
        parent::__construct();
        $this->driver = 'sqlite';
    }
    
    public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""){
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
    public function alter_table(string $table){
        if(empty($this->query)){
            $this->query.=$table;
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.' midway, should be ran first.');
        }
        return $this;
    }
    public function raw(string $sql){
        $this->query .= $sql.' ';
    }
    public function end(){
        $this->query = trim($this->query);
        $this->query.=';';
    }
}