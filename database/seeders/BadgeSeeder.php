<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'key' => 'first_mark',
                'name_tr' => 'İlk İşaret',
                'name_en' => 'First mark',
                'description_tr' => '1 onaylanmış sahne gönderisi',
                'description_en' => '1 approved submission',
                'icon' => 'flag',
            ],
            [
                'key' => 'timekeeper',
                'name_tr' => 'Zaman Bekçisi',
                'name_en' => 'Timekeeper',
                'description_tr' => '50 onaylanmış sahne işareti',
                'description_en' => '50 marks approved',
                'icon' => 'clock',
            ],
            [
                'key' => 'clean_sweep',
                'name_tr' => 'Temiz Süpürme',
                'name_en' => 'Clean sweep',
                'description_tr' => '25 doğrulanmış temiz film bildirimi',
                'description_en' => '25 verified clean claims',
                'icon' => 'check-circle',
            ],
            [
                'key' => 'second_pair_of_eyes',
                'name_tr' => 'İkinci Göz',
                'name_en' => 'Second pair of eyes',
                'description_tr' => '100 topluluk doğrulaması / oyu',
                'description_en' => '100 confirmations',
                'icon' => 'eye',
            ],
            [
                'key' => 'archivist',
                'name_tr' => 'Arşivci',
                'name_en' => 'Archivist',
                'description_tr' => '1980 öncesi bir filmde sahne işaretlendi',
                'description_en' => 'Marked a pre-1980 film',
                'icon' => 'archive',
            ],
            [
                'key' => 'steady_hand',
                'name_tr' => 'Sağlam El',
                'name_en' => 'Steady hand',
                'description_tr' => 'Yüksek doğruluk oranı ve sıfır ret',
                'description_en' => 'High accuracy with zero rejections',
                'icon' => 'award',
            ],
        ];

        foreach ($badges as $b) {
            Badge::updateOrCreate(['key' => $b['key']], $b);
        }
    }
}
