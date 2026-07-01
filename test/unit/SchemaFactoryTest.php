<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\SchemaFactory;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\Schema\MySqlSchema;
use Raymondoor\Migrr\App\Schema\SqliteSchema;

class SchemaFactoryTest extends TestCase
{
    public function test_create_returns_postgres_schema_for_pgsql_driver(): void
    {
        $schema = SchemaFactory::create('pgsql');
        $this->assertInstanceOf(PostgresSchema::class, $schema);
        $this->assertEquals('pgsql', $schema->driver);
    }

    public function test_create_returns_mysql_schema_for_mysql_driver(): void
    {
        $schema = SchemaFactory::create('mysql');
        $this->assertInstanceOf(MySqlSchema::class, $schema);
        $this->assertEquals('mysql', $schema->driver);
    }

    public function test_create_returns_sqlite_schema_for_sqlite_driver(): void
    {
        $schema = SchemaFactory::create('sqlite');
        $this->assertInstanceOf(SqliteSchema::class, $schema);
        $this->assertEquals('sqlite', $schema->driver);
    }

    public function test_create_throws_exception_for_unknown_driver(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown driver: invalid');
        SchemaFactory::create('invalid');
    }
}
