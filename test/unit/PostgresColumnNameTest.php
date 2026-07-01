<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\ColumnName\PostgresColumnName;
use Raymondoor\Migrr\App\Schema\PostgresSchema;
use Raymondoor\Migrr\App\DataType\PostgresDataType;
use Raymondoor\Migrr\App\ColumnConstraint\PostgresColumnConstraint;

class PostgresColumnNameTest extends TestCase
{
    private PostgresColumnName $columnName;
    private PostgresSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new PostgresSchema();
        $this->columnName = new PostgresColumnName($this->schema);
    }

    public function test_constructor_sets_schema(): void
    {
        $this->assertSame($this->schema, $this->columnName->schema);
    }

    public function test_has_unavailables_array(): void
    {
        $this->assertIsArray($this->columnName->unavailables);
        $this->assertContains('order', $this->columnName->unavailables);
    }

    public function test_name_returns_data_type(): void
    {
        $result = $this->columnName->name('email');
        $this->assertInstanceOf(PostgresDataType::class, $result);
    }

    public function test_name_appends_column_name_to_def(): void
    {
        $this->columnName->name('email');
        $this->assertStringContainsString('email', $this->columnName->columnDef);
    }

    public function test_id_template_returns_constraint(): void
    {
        $result = $this->columnName->id_template();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
    }

    public function test_id_template_creates_bigserial_pk(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->id_template()
            ->endColumns()
            ->end();
        $this->assertStringContainsString('id', $this->schema->query);
        $this->assertStringContainsString('BIGSERIAL', $this->schema->query);
        $this->assertStringContainsString('PRIMARY KEY', $this->schema->query);
        $this->assertStringContainsString('IDENTITY', $this->schema->query);
    }

    public function test_created_at_template_returns_constraint(): void
    {
        $result = $this->columnName->created_at_template();
        $this->assertInstanceOf(PostgresColumnConstraint::class, $result);
    }

    public function test_created_at_template_creates_timestamp_with_tz(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->created_at_template(true)
            ->endColumns()
            ->end();
        $this->assertStringContainsString('created_at', $this->schema->query);
        $this->assertStringContainsString('TIMESTAMP', $this->schema->query);
        $this->assertStringContainsString('WITH TIME ZONE', $this->schema->query);
    }

    public function test_created_at_template_creates_timestamp_without_tz(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->created_at_template(false)
            ->endColumns()
            ->end();
        $this->assertStringContainsString('created_at', $this->schema->query);
        $this->assertStringContainsString('TIMESTAMP', $this->schema->query);
    }

    public function test_created_at_template_has_default_current_timestamp(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->created_at_template()
            ->endColumns()
            ->end();
        $this->assertStringContainsString('DEFAULT', $this->schema->query);
        $this->assertStringContainsString('CURRENT_TIMESTAMP', $this->schema->query);
    }

    public function test_created_at_template_with_custom_precision(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->created_at_template(true, 3)
            ->endColumns()
            ->end();
        $this->assertStringContainsString('(3)', $this->schema->query);
    }
}
