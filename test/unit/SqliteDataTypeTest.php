<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\DataType\SqliteDataType;
use Raymondoor\Migrr\App\Schema\SqliteSchema;
use Raymondoor\Migrr\App\ColumnConstraint\SqliteColumnConstraint;

class SqliteDataTypeTest extends TestCase
{
    private SqliteDataType $dataType;
    private SqliteSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new SqliteSchema();
        $this->dataType = new SqliteDataType($this->schema, 'id ');
    }

    public function test_constructor_sets_schema_and_column_def(): void
    {
        $this->assertSame($this->schema, $this->dataType->schema);
        $this->assertEquals('id ', $this->dataType->columnDef);
    }

    public function test_int_appends_integer(): void
    {
        $result = $this->dataType->int();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('INTEGER', $this->dataType->columnDef);
    }

    public function test_varchar_appends_varchar_with_limit(): void
    {
        $result = $this->dataType->varchar(255);
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('VARCHAR(255)', $this->dataType->columnDef);
    }

    public function test_text_appends_text(): void
    {
        $result = $this->dataType->text();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('TEXT', $this->dataType->columnDef);
    }

    public function test_date_appends_date(): void
    {
        $result = $this->dataType->date();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('DATE', $this->dataType->columnDef);
    }

    public function test_bool_appends_boolean(): void
    {
        $result = $this->dataType->bool();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('BOOLEAN', $this->dataType->columnDef);
    }

    public function test_json_appends_json(): void
    {
        $result = $this->dataType->json();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
        $this->assertStringContainsString('JSON', $this->dataType->columnDef);
    }
}
