<?php

use App\Models\LinkRoot;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $root = new LinkRoot();
        $root->name = 'Anime';
        $root->path = 'Anime';
        $root->save();

        $root = new LinkRoot();
        $root->name = 'TV';
        $root->path = 'OtherTV';
        $root->save();

        $root = new LinkRoot();
        $root->name = 'Movies';
        $root->path = 'OtherMovies';
        $root->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        LinkRoot::truncate();
    }
};
