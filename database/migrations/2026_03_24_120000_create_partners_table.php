<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo');
            $table->string('website_url')->nullable();
            $table->string('category')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('partners')->insert([
            [
                'name' => 'Butende',
                'slug' => 'butende',
                'logo' => 'images/partners/butende.png',
                'category' => 'Community Partner',
                'short_description' => 'Supporting practical training and community-rooted digital skills development.',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MRU',
                'slug' => 'mru',
                'logo' => 'images/partners/mru.png',
                'category' => 'Institutional Partner',
                'short_description' => 'Collaborating on education pathways and industry-aligned learning opportunities.',
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mahipso',
                'slug' => 'mahipso',
                'logo' => 'images/partners/mahipso.png',
                'category' => 'Industry Partner',
                'short_description' => 'Helping connect students to relevant technical networks and opportunities.',
                'sort_order' => 3,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ADIC',
                'slug' => 'adic',
                'logo' => 'images/partners/adic.png',
                'category' => 'Development Partner',
                'short_description' => 'Contributing to innovation, entrepreneurship, and workforce readiness initiatives.',
                'sort_order' => 4,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Masaka City',
                'slug' => 'masaka-city',
                'logo' => 'images/partners/masakacity.png',
                'category' => 'Government Partner',
                'short_description' => 'Supporting regional skills development and access to technology education.',
                'sort_order' => 5,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NITA',
                'slug' => 'nita',
                'logo' => 'images/partners/nita.svg',
                'category' => 'National Partner',
                'short_description' => 'Strengthening recognition, standards, and pathways for digital training outcomes.',
                'sort_order' => 6,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
