<?php namespace Raymondoor\Migrr\Schema;

class SchemaFactory{
    public static function create(string $driver):Schema{
        return match($driver){
            'pgsql' => new PostgresSchema(),
            'mysql' => new MySqlSchema(),
            'sqlite' => new SqliteSchema(),
            default => throw new \Exception("Unknown driver: $driver")
        };
    }
}
