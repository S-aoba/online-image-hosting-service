<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddTitleColumnToImageTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE images ADD title VARCHAR(255) NOT NULL DEFAULT ''"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE images DROP title"
        ];
    }
}
