<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#2563eb');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Seed default categories
        $categories = [
            ['name' => 'Politik & Hukum', 'slug' => 'politik-hukum', 'color' => '#dc2626', 'order' => 1],
            ['name' => 'Ekonomi & Bisnis', 'slug' => 'ekonomi-bisnis', 'color' => '#2563eb', 'order' => 2],
            ['name' => 'Teknologi & Sains', 'slug' => 'teknologi-sains', 'color' => '#7c3aed', 'order' => 3],
            ['name' => 'Gaya Hidup', 'slug' => 'gaya-hidup', 'color' => '#16a34a', 'order' => 4],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'color' => '#f59e0b', 'order' => 5],
            ['name' => 'Internasional', 'slug' => 'internasional', 'color' => '#0891b2', 'order' => 6],
        ];

        $now = now();
        foreach ($categories as $cat) {
            DB::table('categories')->insert(array_merge($cat, ['created_at' => $now, 'updated_at' => $now]));
        }

        // Add category_id to articles
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('category');
        });

        // Migrate existing data: map old category values to new category_id
        $allCategories = DB::table('categories')->get();
        foreach ($allCategories as $cat) {
            // Match by slug or by name (case-insensitive partial match)
            DB::table('articles')
                ->where('category', $cat->slug)
                ->orWhere('category', 'like', explode(' ', $cat->name)[0] . '%')
                ->update(['category_id' => $cat->id]);
        }

        // Set any remaining null to first category
        $firstId = DB::table('categories')->first()?->id ?? 1;
        DB::table('articles')->whereNull('category_id')->update(['category_id' => $firstId]);
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
        Schema::dropIfExists('categories');
    }
};
