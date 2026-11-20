
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image');
            $table->string('name');
            $table->text('description');
            $table->bigInteger('price');
            $table->integer('stock')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'name',
                'description',
                'price',
                'stock'
            ]);
        });
    }
};
