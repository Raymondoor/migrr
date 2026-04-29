<?php namespace Raymondoor\Migrr\Schema;

class Schema{
    public string $query = "";
    public string $driver = "";
    public function __construct(){}
    public function create_table(string $name, bool $ifNotExist=false, bool $temp=false, string $optionsRaw = ""){
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
    public function alter_table(string $table){
        if(empty($this->query)){
            $this->query.=$table;
        }else{
            throw new \Exception('Cannot run '.__FUNCTION__.', should be ran first.');
        }
        return $this;
    }
    public function raw(string $sql){
        $this->query .= $sql.' ';
        return $this;
    }
    public function columns():ColumnName\ColumnName{
        $this->query .= '(';
        return new ColumnName\ColumnName($this);
    }
    public function end(){
        $this->query = trim($this->query);
        $this->query.=';';
    }
}