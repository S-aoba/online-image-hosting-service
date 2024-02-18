<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class DeleteSharedPathUniqueKeyTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE images DROP CONSTRAINT shared_path"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE images ADD CONSTRAINT shared_path UNIQUE (shared_path)"
        ];
    }
}
