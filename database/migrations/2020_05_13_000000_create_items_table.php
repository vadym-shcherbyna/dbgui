<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Str;

class CreateitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('description')->nullable();
        });

        // Populate
        $randomNumRows = random_int(800, 1200);
        for ($i=1;$i<$randomNumRows;$i++) {
            $name = $this->randomString([1, 2], [5, 12]);
            $code = Str::slug($name, '-');
            $description = $this->randomString([3, 6], [5, 12]);
            DB::table('items')->insert(['name' => $name, 'code' => $code, 'description' => $description]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }

    /**
     * Random string
     *
     * @param array $numWords
     * @param array $numSynbols
     * @param boolean $allUp
     * @return string
     */
    private function randomString ($numWords, $numSymbols, $allUp = false)
    {
        $charset = "aabcdeefghiijklmnoopqrstuuvwxyyz";
        $string = '';

        $randomNumWords = random_int ($numWords[0], $numWords[1]);
        $randomNumSymbols = random_int ($numSymbols[0], $numSymbols[1]);

        for ($i=0;$i<$randomNumWords;$i++) {

            $word = '';
            for ($i2=0;$i2<$randomNumSymbols;$i2++) {
                $word .= $charset [random_int(0, 31)];
            }

            if ($i == 0) {
                $word = ucfirst ($word);
                $string = $word;
            } else {
                if ($allUp) $word = ucfirst ($word);
                $string .= ' '.$word;
            }
        }

        return $string;
    }
}