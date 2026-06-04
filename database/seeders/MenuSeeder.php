<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        Menu::truncate();

        // === MAKANAN ===
        $makanan = [
            [
                'name'        => 'Siobak Original',
                'price'       => 35000,
                'description' => 'Daging babi rebus khas Bangka dengan kuah kaldu spesial yang gurih dan lezat',
                'category'    => 'makanan',
                'stock'       => 50,
                'image'       => null,
            ],
            [
                'name'        => 'Casio (Char Siu)',
                'price'       => 40000,
                'description' => 'Daging babi panggang ala Hong Kong dengan saus barbeque merah yang manis dan harum',
                'category'    => 'makanan',
                'stock'       => 40,
                'image'       => null,
            ],
            [
                'name'        => 'Babi Panggang',
                'price'       => 45000,
                'description' => 'Babi panggang crispy dengan kulit renyah, disajikan dengan saus asam manis',
                'category'    => 'makanan',
                'stock'       => 30,
                'image'       => null,
            ],
            [
                'name'        => 'Nasi Putih',
                'price'       => 5000,
                'description' => 'Nasi putih pulen hangat',
                'category'    => 'makanan',
                'stock'       => 100,
                'image'       => null,
            ],
            [
                'name'        => 'Kuah Siobak',
                'price'       => 8000,
                'description' => 'Kuah kaldu babi yang gurih dan kaya rasa, cocok diminum hangat',
                'category'    => 'makanan',
                'stock'       => 80,
                'image'       => null,
            ],
            [
                'name'        => 'Sawi Rebus',
                'price'       => 12000,
                'description' => 'Sayur sawi hijau rebus segar dengan sedikit minyak bawang putih',
                'category'    => 'makanan',
                'stock'       => 60,
                'image'       => null,
            ],
            [
                'name'        => 'Siobak + Casio Mix',
                'price'       => 55000,
                'description' => 'Kombinasi Siobak Original dan Casio dalam satu porsi spesial',
                'category'    => 'makanan',
                'stock'       => 25,
                'image'       => null,
            ],
            [
                'name'        => 'Combo Lengkap',
                'price'       => 75000,
                'description' => 'Paket komplit: Siobak + Casio + Babi Panggang + Nasi + Kuah',
                'category'    => 'makanan',
                'stock'       => 20,
                'image'       => null,
            ],
        ];

        // === MINUMAN ===
        $minuman = [
            [
                'name'        => 'Es Teh Manis',
                'price'       => 8000,
                'description' => 'Teh manis segar dengan es batu, pas untuk menemani makan',
                'category'    => 'minuman',
                'stock'       => 100,
                'image'       => null,
            ],
            [
                'name'        => 'Es Jeruk',
                'price'       => 10000,
                'description' => 'Jus jeruk peras segar dengan es batu, menyegarkan',
                'category'    => 'minuman',
                'stock'       => 80,
                'image'       => null,
            ],
            [
                'name'        => 'Air Mineral',
                'price'       => 5000,
                'description' => 'Air mineral botol 600ml',
                'category'    => 'minuman',
                'stock'       => 200,
                'image'       => null,
            ],
            [
                'name'        => 'Jus Alpukat',
                'price'       => 18000,
                'description' => 'Jus alpukat creamy dengan susu kental manis, tebal dan lezat',
                'category'    => 'minuman',
                'stock'       => 50,
                'image'       => null,
            ],
            [
                'name'        => 'Kopi Susu Hangat',
                'price'       => 15000,
                'description' => 'Kopi susu hangat dengan cita rasa yang kuat dan harum',
                'category'    => 'minuman',
                'stock'       => 60,
                'image'       => null,
            ],
            [
                'name'        => 'Es Kopi Susu',
                'price'       => 18000,
                'description' => 'Kopi susu dingin dengan es batu yang menyegarkan',
                'category'    => 'minuman',
                'stock'       => 60,
                'image'       => null,
            ],
            [
                'name'        => 'Soda Gembira',
                'price'       => 15000,
                'description' => 'Minuman soda dengan sirup merah dan susu kental, warna-warni dan segar',
                'category'    => 'minuman',
                'stock'       => 50,
                'image'       => null,
            ],
            [
                'name'        => 'Es Cincau',
                'price'       => 12000,
                'description' => 'Cincau hitam dengan santan manis dan es batu, minuman tradisional yang menyegarkan',
                'category'    => 'minuman',
                'stock'       => 70,
                'image'       => null,
            ],
            [
                'name'        => 'Lemon Tea',
                'price'       => 12000,
                'description' => 'Teh dingin dengan perasan lemon segar dan madu',
                'category'    => 'minuman',
                'stock'       => 70,
                'image'       => null,
            ],
        ];

        foreach (array_merge($makanan, $minuman) as $item) {
            Menu::create($item);
        }
    }
}
