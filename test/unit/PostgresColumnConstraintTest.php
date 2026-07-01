<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\ColumnConstraint\PostgresColumnConstraint;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\ColumnName\PostgresColumnName;
use Raymondoor\Migrr\App\DataType\PostgresDataType;

class PostgresColumnConstraintTest extends TestCase
{
    private PostgresColumnConstraint $constraint;
    private PostgresSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new PostgresSchema();
        $this->constraint = new PostgresColumnConstraint($this->schema, 'id ');
    }

    public function test_constructor_sets_schema_and_column_def(): void
    {
        $this->assertSame($this->schema, $this->constraint->schema);
        $this->assertEquals('id ', $this->constraint->columnDef);
    }

    public function test_unique_appends_unique(): void
    {
        $result = $this->constraint->unique();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('UNIQUE', $this->constraint->columnDef);
    }

    public function test_notnull_appends_not_null(): void
    {
        $result = $this->constraint->notnull();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('NOT NULL', $this->constraint->columnDef);
    }

    public function test_primary_key_appends_primary_key(): void
    {
        $result = $this->constraint->primaryKey();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('PRIMARY KEY', $this->constraint->columnDef);
    }

    public function test_foreign_key_appends_reference(): void
    {
        $result = $this->constraint->foreignKey('users', 'id');
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('REFERENCES users(id)', $this->constraint->columnDef);
    }

    public function test_identity_appends_generated_always_as_identity(): void
    {
        $result = $this->constraint->identity();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('GENERATED ALWAYS AS IDENTITY', $this->constraint->columnDef);
    }

    public function test_check_appends_check_constraint(): void
    {
        $result = $this->constraint->check('age > 18');
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('CHECK (age > 18)', $this->constraint->columnDef);
    }

    public function test_check_name_appends_named_check(): void
    {
        $result = $this->constraint->checkName('age_check', 'age > 18');
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('CONSTRAINT age_check CHECK', $this->constraint->columnDef);
    }

    public function test_default_appends_default_string_value(): void
    {
        $result = $this->constraint->default('active');
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString("DEFAULT 'active'", $this->constraint->columnDef);
    }

    public function test_default_with_raw_value(): void
    {
        $result = $this->constraint->default('CURRENT_TIMESTAMP', true);
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('DEFAULT CURRENT_TIMESTAMP', $this->constraint->columnDef);
    }

    public function test_autoincrement_appends_autoincrement(): void
    {
        $result = $this->constraint->autoincrement();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('AUTOINCREMENT', $this->constraint->columnDef);
    }

    public function test_next_column_name_returns_column_name(): void
    {
        $this->schema->create_table('users');
        $columnName = $this->constraint->nextColumnName('email');
        $this->assertInstanceOf(PostgresDataType::class, $columnName);
    }

    public function test_next_column_returns_column_name(): void
    {
        $this->schema->create_table('users');
        $columnName = $this->constraint->nextColumn();
        $this->assertInstanceOf(PostgresColumnName::class, $columnName);
    }

    public function test_end_columns_returns_schema(): void
    {
        $this->schema->create_table('users');
        $result = $this->constraint->endColumns();
        $this->assertInstanceOf(PostgresSchema::class, $result);
        $this->assertSame($this->schema, $result);
    }

    public function test_method_chaining_works(): void
    {
        $this->schema->create_table('users');
        $this->constraint->unique()
            ->notnull()
            ->primaryKey()
            ->default('test');

        $this->assertStringContainsString('UNIQUE', $this->constraint->columnDef);
        $this->assertStringContainsString('NOT NULL', $this->constraint->columnDef);
        $this->assertStringContainsString('PRIMARY KEY', $this->constraint->columnDef);
        $this->assertStringContainsString('DEFAULT', $this->constraint->columnDef);
    }
}
