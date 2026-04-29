<?php namespace Raymondoor\Migrr;

class Migrr{
    private static $pdo;
    private static $schema;
    public function __construct(\PDO $pdo){
        self::$pdo = $pdo;
    }
    public function schema(string $schema){
        self::$schema = $schema;
        return $this;
    }
    public function migrate(){
        return self::$pdo->exec(self::$schema);
    }
}
(new Migrr(new \PDO('a')))->schema('a')->migrate();