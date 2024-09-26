<?php

use App\Models\Tweet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Tweet::TABLE, function (Blueprint $table) {
            $table->uuid(Tweet::ID);
            $table->text(Tweet::CONTENT);
            $table->boolean(Tweet::IS_PUBLISHED)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Tweet::TABLE);
    }
};
