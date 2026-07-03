<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->renameColumn('category', 'category_id');
        });

        Schema::table('jurnals', function (Blueprint $table) {
            $table->renameColumn('category', 'category_id');
        });

        $this->migratePortfolioCategoryTitlesToIds();
        $this->migrateJurnalCategoryTitlesToIds();
    }

    public function down(): void
    {
        $this->migratePortfolioCategoryIdsToTitles();
        $this->migrateJurnalCategoryIdsToTitles();

        Schema::table('portfolios', function (Blueprint $table) {
            $table->renameColumn('category_id', 'category');
        });

        Schema::table('jurnals', function (Blueprint $table) {
            $table->renameColumn('category_id', 'category');
        });
    }

    private function migratePortfolioCategoryTitlesToIds(): void
    {
        $portfolios = DB::table('portfolios')
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->get(['id', 'user_id', 'category_id']);

        foreach ($portfolios as $portfolio) {
            $category = DB::table('portfolio_categories')
                ->where('user_id', $portfolio->user_id)
                ->where('title', $portfolio->category_id)
                ->first();

            if ($category !== null) {
                DB::table('portfolios')
                    ->where('id', $portfolio->id)
                    ->update(['category_id' => $category->category_id]);
            }
        }
    }

    private function migrateJurnalCategoryTitlesToIds(): void
    {
        $jurnals = DB::table('jurnals')
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->get(['id', 'user_id', 'category_id']);

        foreach ($jurnals as $jurnal) {
            $category = DB::table('jurnal_categories')
                ->where('user_id', $jurnal->user_id)
                ->where('title', $jurnal->category_id)
                ->first();

            if ($category !== null) {
                DB::table('jurnals')
                    ->where('id', $jurnal->id)
                    ->update(['category_id' => $category->category_id]);
            }
        }
    }

    private function migratePortfolioCategoryIdsToTitles(): void
    {
        $portfolios = DB::table('portfolios')
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->get(['id', 'user_id', 'category_id']);

        foreach ($portfolios as $portfolio) {
            $category = DB::table('portfolio_categories')
                ->where('user_id', $portfolio->user_id)
                ->where('category_id', $portfolio->category_id)
                ->first();

            if ($category !== null) {
                DB::table('portfolios')
                    ->where('id', $portfolio->id)
                    ->update(['category_id' => $category->title]);
            }
        }
    }

    private function migrateJurnalCategoryIdsToTitles(): void
    {
        $jurnals = DB::table('jurnals')
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->get(['id', 'user_id', 'category_id']);

        foreach ($jurnals as $jurnal) {
            $category = DB::table('jurnal_categories')
                ->where('user_id', $jurnal->user_id)
                ->where('category_id', $jurnal->category_id)
                ->first();

            if ($category !== null) {
                DB::table('jurnals')
                    ->where('id', $jurnal->id)
                    ->update(['category_id' => $category->title]);
            }
        }
    }
};
