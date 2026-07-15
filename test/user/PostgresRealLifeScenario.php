<?php declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';
use Raymondoor\Migrr\App\Schema\PostgresSchema;

$groupsSchema = new PostgresSchema();
$groupsSchema->create_table('groups',true)->
    columns()->
        id_template()->nextColumn()->
        name('name')->varchar(50)->notnull()->
        nextColumnName('email')->varchar(100)->unique()->notNull()->
        nextColumnName('groupid')->bigint()->references('groups','id')->onDeleteCascade()->
        nextColumn()->created_at_template(true)->nextColumn()->
        name('updated_at')->timestamp(true,6)->default('CURRENT_TIMESTAMP',true)->
    endColumns()->
end();
echo $groupsSchema->query."\n";

$usersSchema = new PostgresSchema();
$usersSchema->create_table('users',true)->
    columns()->
        id_template()->nextColumn()->
        name('username')->varchar(50)->
        nextColumnName('email')->varchar(100)->unique()->notNull()->
        nextColumnName('groupid')->bigint()->references('groups','id')->onDeleteCascade()->
        nextColumn()->created_at_template(true)->nextColumn()->
        name('updated_at')->timestamp(true,6)->default('CURRENT_TIMESTAMP',true)->
    endColumns()->
end();
echo $usersSchema->query."\n";


$userPasswordsSchema = new PostgresSchema();
$userPasswordsSchema->create_table('user_passwords',true)->
    columns()->
        id_template()->nextColumn()->
        name('users_id')->bigint()->references('users','id')->onDeleteCascade()->notNull()->
        nextColumnName('password_hash')->varchar(255)->notNull()->
        nextColumnName('created_at')->timestamp(true,6)->default('CURRENT_TIMESTAMP',true)->notNull()->
        nextColumnName('updated_at')->timestamp(true,6)->default('CURRENT_TIMESTAMP',true)->notNull()->
    endColumns()->
end();
echo $userPasswordsSchema->query."\n";

echo "\nPeak memory usage: " . (round(memory_get_peak_usage(true) / 1024 / 1024, 2)) . " megabytes\n";