<?php namespace Raymondoor\Migrr;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\Schema\MySqlSchema;
use Raymondoor\Migrr\App\Schema\SqliteSchema;

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
