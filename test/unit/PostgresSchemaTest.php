<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\ColumnName\PostgresColumnName;

class PostgresSchemaTest extends TestCase
{
    private PostgresSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new PostgresSchema();
    }

    public function test_constructor_sets_driver_and_query(): void
    {
        $this->assertEquals('pgsql', $this->schema->driver);
        $this->assertEquals('', $this->schema->query);
    }

    public function test_create_table_builds_basic_create_statement(): void
    {
        $result = $this->schema->create_table('users');
        $this->assertSame($this->schema, $result);
        $this->assertStringContainsString('CREATE TABLE users', $this->schema->query);
    }

    public function test_create_table_with_if_not_exists(): void
    {
        $this->schema->create_table('users', true);
        $this->assertStringContainsString('IF NOT EXISTS', $this->schema->query);
    }

    public function test_create_table_with_temp(): void
    {
        $this->schema->create_table('temp_users', false, true);
        $this->assertStringContainsString('TEMPORARY', $this->schema->query);
    }

    public function test_create_table_with_options(): void
    {
        $this->schema->create_table('users', false, false, 'PARTITION BY');
        $this->assertStringContainsString('PARTITION BY', $this->schema->query);
    }

    public function test_create_table_throws_if_called_twice(): void
    {
        $this->schema->create_table('users');
        $this->expectException(\Exception::class);
        $this->schema->create_table('posts');
    }

    public function test_alter_table_builds_alter_statement(): void
    {
        $result = $this->schema->alter_table('ALTER TABLE users');
        $this->assertSame($this->schema, $result);
        $this->assertStringContainsString('ALTER TABLE users', $this->schema->query);
    }

    public function test_raw_appends_sql(): void
    {
        $this->schema->create_table('users');
        $result = $this->schema->raw(' ADD COLUMN email VARCHAR(255)');
        $this->assertSame($this->schema, $result);
        $this->assertStringContainsString('ADD COLUMN email', $this->schema->query);
    }

    public function test_columns_returns_column_name_instance(): void
    {
        $this->schema->create_table('users');
        $columnName = $this->schema->columns();
        $this->assertInstanceOf(PostgresColumnName::class, $columnName);
        $this->assertStringContainsString('(', $this->schema->query);
    }

    public function test_end_trims_query_and_adds_semicolon(): void
    {
        $this->schema->create_table('users');
        $this->schema->raw('  ');
        $result = $this->schema->end();
        $this->assertSame($this->schema, $result);
        $this->assertStringEndsWith(';', $this->schema->query);
    }

    public function test_full_create_table_workflow(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->id_template()
                ->nextcolumnName('name')->text()->notnull()
            ->endcolumns()
            ->end();

        $this->assertStringContainsString('CREATE TABLE IF NOT EXISTS users', $this->schema->query);
        $this->assertStringContainsString('BIGSERIAL PRIMARY KEY', $this->schema->query);
        $this->assertStringContainsString('name TEXT NOT NULL', $this->schema->query);
        $this->assertStringEndsWith(';', $this->schema->query);
    }
}
