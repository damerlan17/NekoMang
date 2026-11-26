<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')->insertOrIgnore([
            [
                'name' => 'Читатель',
                'slug' => 'reader',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Администратор',
                'slug' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $readerRoleId = DB::table('roles')
            ->where('slug', 'reader')
            ->value('id');

        Schema::table('users', function (Blueprint $table) use ($readerRoleId) {
            $table->foreignId('role_id')
                ->default($readerRoleId)
                ->after('id')
                ->constrained('roles')
                ->restrictOnDelete();

            $table->string('avatar')
                ->nullable()
                ->after('password');

            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropUnique(['name']);
            $table->dropColumn(['role_id', 'avatar']);
        });
    }
};
