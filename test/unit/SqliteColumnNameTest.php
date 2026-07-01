<?php namespace Raymondoor\Migrr\Test\Unit;

use PHPUnit\Framework\TestCase;
use Raymondoor\Migrr\App\ColumnName\SqliteColumnName;
use Raymondoor\Migrr\App\Schema\SqliteSchema;
use Raymondoor\Migrr\App\DataType\SqliteDataType;
use Raymondoor\Migrr\App\ColumnConstraint\SqliteColumnConstraint;

class SqliteColumnNameTest extends TestCase
{
    private SqliteColumnName $columnName;
    private SqliteSchema $schema;

    protected function setUp(): void
    {
        $this->schema = new SqliteSchema();
        $this->columnName = new SqliteColumnName($this->schema);
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
        $this->assertInstanceOf(SqliteDataType::class, $result);
    }

    public function test_id_template_returns_constraint(): void
    {
        $result = $this->columnName->id_template();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
    }

    public function test_id_template_creates_integer_pk(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->id_template()
            ->endColumns()
            ->end();
        $this->assertStringContainsString('id', $this->schema->query);
        $this->assertStringContainsString('INTEGER', $this->schema->query);
        $this->assertStringContainsString('PRIMARY KEY', $this->schema->query);
    }

    public function test_created_at_template_returns_constraint(): void
    {
        $result = $this->columnName->created_at_template();
        $this->assertInstanceOf(SqliteColumnConstraint::class, $result);
    }

    public function test_created_at_template_creates_date(): void
    {
        $this->schema->create_table('users', true)
            ->columns()
                ->created_at_template()
            ->endColumns()
            ->end();
        $this->assertStringContainsString('created_at', $this->schema->query);
        $this->assertStringContainsString('DATE', $this->schema->query);
    }
}
