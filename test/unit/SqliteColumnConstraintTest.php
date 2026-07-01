<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\ColumnConstraint\SqliteColumnConstraint;
use Raymondoor\Migrr\App\Schema\SqliteSchema;

class SqliteColumnConstraintTest extends TestCase
{
    private SqliteColumnConstraint $constraint;
    private SqliteSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new SqliteSchema();
        $this->constraint = new SqliteColumnConstraint($this->schema, 'id ');
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

    public function test_identity_appends_generated_always_as_identity(): void
    {
        $result = $this->constraint->identity();
        $this->assertSame($this->constraint, $result);
        $this->assertStringContainsString('GENERATED ALWAYS AS IDENTITY', $this->constraint->columnDef);
    }

    public function test_default_appends_default_value(): void
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
}
