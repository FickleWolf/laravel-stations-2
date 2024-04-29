<?php

namespace Tests\Feature\LaravelStations\Station13;

use App\Models\Sheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group station13
 */
class SheetTest extends TestCase
{
    use RefreshDatabase;

    public function testSeedコマンドでマスターデータが作成されるか(): void
    {
        $this->seed();
        $sheets = Sheet::all();
        $this->assertEquals($sheets->count(), 15);
    }

    public function test座席一覧画面に全ての座席が表示されるか(): void
    {
        $this->seed();
        $response = $this->get('/sheets');
        $response->assertStatus(200);
        $sheets = Sheet::all();
        foreach ($sheets as $sheet) {
            $response->assertSeeText($sheet->row . '-' . $sheet->column);
        }
    }
}
