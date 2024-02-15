<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSnippetsTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE IF NOT EXISTS snippets (
                id int primary key auto_increment,
                snippet text not null,
                language varchar(255) not null,
                expiration datetime not null,
                url varchar(255) not null,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "drop table if exists snippets"
        ];
    }
}
