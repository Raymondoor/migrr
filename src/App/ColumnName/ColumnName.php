<?php namespace Raymondoor\Migrr\App\ColumnName;
use Raymondoor\Migrr\App\Schema\Schema;
use Raymondoor\Migrr\App\DataType\DataType;
use Raymondoor\Migrr\App\ColumnConstraint\ColumnConstraint;
abstract class ColumnName{
    /**
     * @var array<string> $unavailables List of unavailable column names. This is used to prevent using reserved keywords as column names.
     */
    public array $unavailables = [];
    public Schema $schema;
    public string $columnDef = '';
    abstract public function __construct(Schema $schema);
    abstract public function name(string $columnName):DataType;
    abstract public function id_template():ColumnConstraint;
    abstract public function created_at_template(bool $tz = false,int $precision = 6):ColumnConstraint;
}