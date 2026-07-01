<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\DataType\PostgresDataType;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\ColumnConstraint\PostgresColumnConstraint;

class PostgresDataTypeTest extends TestCase
{
    private PostgresDataType $dataType;
    private PostgresSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new PostgresSchema();
        $this->dataType = new PostgresDataType($this->schema, 'id ');
    }

    public function test_constructor_sets_schema_and_column_def(): void
    {
        $this->assertSame($this->schema, $this->dataType->schema);
        $this->assertEquals('id ', $this->dataType->columnDef);
    }

    public function test_custom_appends_raw_type(): void
    {
        $result = $this->dataType->custom('UUID');
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('UUID ', $this->dataType->columnDef);
    }

    public function test_int_appends_integer(): void
    {
        $result = $this->dataType->int();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('INTEGER', $this->dataType->columnDef);
    }

    public function test_bigint_appends_bigint(): void
    {
        $result = $this->dataType->bigint();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('BIGINT', $this->dataType->columnDef);
    }

    public function test_bigserial_appends_bigserial(): void
    {
        $result = $this->dataType->bigserial();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('BIGSERIAL', $this->dataType->columnDef);
    }

    public function test_varchar_appends_varchar_with_limit(): void
    {
        $result = $this->dataType->varchar(255);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('VARCHAR(255)', $this->dataType->columnDef);
    }

    public function test_char_appends_char_with_length(): void
    {
        $result = $this->dataType->char(10);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('CHAR(10)', $this->dataType->columnDef);
    }

    public function test_text_appends_text(): void
    {
        $result = $this->dataType->text();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('TEXT', $this->dataType->columnDef);
    }

    public function test_date_appends_date(): void
    {
        $result = $this->dataType->date();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('DATE', $this->dataType->columnDef);
    }

    public function test_timestamp_without_timezone(): void
    {
        $result = $this->dataType->timestamp(false);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('TIMESTAMP', $this->dataType->columnDef);
        $this->assertStringNotContainsString('TIME ZONE', $this->dataType->columnDef);
    }

    public function test_timestamp_with_timezone(): void
    {
        $result = $this->dataType->timestamp(true);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('TIMESTAMP', $this->dataType->columnDef);
        $this->assertStringContainsString('WITH TIME ZONE', $this->dataType->columnDef);
    }

    public function test_time_with_timezone(): void
    {
        $result = $this->dataType->time(true);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('TIME', $this->dataType->columnDef);
        $this->assertStringContainsString('WITH TIME ZONE', $this->dataType->columnDef);
    }

    public function test_decimal_appends_decimal_with_precision(): void
    {
        $result = $this->dataType->decimal(10, 2);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('DECIMAL(10,2)', $this->dataType->columnDef);
    }

    public function test_bool_appends_boolean(): void
    {
        $result = $this->dataType->bool();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('BOOLEAN', $this->dataType->columnDef);
    }

    public function test_json_appends_json(): void
    {
        $result = $this->dataType->json();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('JSON', $this->dataType->columnDef);
    }

    public function test_jsonb_appends_jsonb(): void
    {
        $result = $this->dataType->jsonb();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('JSONB', $this->dataType->columnDef);
    }

    public function test_bit_appends_bit_with_length(): void
    {
        $result = $this->dataType->bit(8);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('BIT(8)', $this->dataType->columnDef);
    }

    public function test_bit_with_varying(): void
    {
        $result = $this->dataType->bit(8, true);
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('BIT VARYING(8)', $this->dataType->columnDef);
    }

    public function test_enum_appends_enum_type(): void
    {
        $result = $this->dataType->enum('user_status');
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('user_status', $this->dataType->columnDef);
    }

    public function test_interval_appends_interval_field(): void
    {
        $result = $this->dataType->interval('YEAR');
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
        $this->assertStringContainsString('INTERVAL YEAR', $this->dataType->columnDef);
    }

    public function test_interval_throws_for_invalid_field(): void
    {
        $this->expectException(\Exception::class);
        $this->dataType->interval('INVALID');
    }

    public function test_interval_throws_for_negative_precision(): void
    {
        $this->expectException(\Exception::class);
        $this->dataType->interval('YEAR', -1);
    }

    public function test_interval_throws_for_precision_over_6(): void
    {
        $this->expectException(\Exception::class);
        $this->dataType->interval('YEAR', 7);
    }

    public function test_bit_throws_for_negative_length(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->dataType->bit(-1);
    }
}
