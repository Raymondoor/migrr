<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\DataType\MySqlDataType;
use Raymondoor\Migrr\App\Schema\MySqlSchema;
use Raymondoor\Migrr\App\ColumnConstraint\MySqlColumnConstraint;

class MySqlDataTypeTest extends TestCase
{
    private MySqlDataType $dataType;
    private MySqlSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new MySqlSchema();
        $this->dataType = new MySqlDataType($this->schema, 'id ');
    }

    public function test_constructor_sets_schema_and_column_def(): void
    {
        $this->assertSame($this->schema, $this->dataType->schema);
        $this->assertEquals('id ', $this->dataType->columnDef);
    }

    public function test_int_appends_integer(): void
    {
        $result = $this->dataType->int();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('INTEGER', $this->dataType->columnDef);
    }

    public function test_varchar_appends_varchar_with_limit(): void
    {
        $result = $this->dataType->varchar(255);
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('VARCHAR(255)', $this->dataType->columnDef);
    }

    public function test_text_appends_text(): void
    {
        $result = $this->dataType->text();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('TEXT', $this->dataType->columnDef);
    }

    public function test_timestamp_appends_timestamp(): void
    {
        $result = $this->dataType->timestamp();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('TIMESTAMP', $this->dataType->columnDef);
    }

    public function test_date_appends_date(): void
    {
        $result = $this->dataType->date();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('DATE', $this->dataType->columnDef);
    }

    public function test_bool_appends_boolean(): void
    {
        $result = $this->dataType->bool();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('BOOLEAN', $this->dataType->columnDef);
    }

    public function test_json_appends_json(): void
    {
        $result = $this->dataType->json();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('JSON', $this->dataType->columnDef);
    }

    public function test_decimal_appends_decimal_with_precision(): void
    {
        $result = $this->dataType->decimal(10, 2);
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('DECIMAL(10,2)', $this->dataType->columnDef);
    }

    public function test_bigserial_appends_bigserial(): void
    {
        $result = $this->dataType->bigserial();
        $this->assertInstanceOf(MySqlColumnConstraint::class, $result);
        $this->assertStringContainsString('BIGSERIAL', $this->dataType->columnDef);
    }
}
