<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Code;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Admin Het BUREAU',
            'email' => 'admin@hetbureau.nl',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'code_used' => false,
            'address' => 'Keizersgracht 200, 1016 AA Amsterdam',
            'phone' => '020-1234567',
        ]);

        $jan = User::create([
            'name' => 'Jan de Vries',
            'email' => 'jan@hetbureau.nl',
            'password' => Hash::make('welkom123'),
            'role' => 'employee',
            'code_used' => false,
            'address' => 'Kalverstraat 12, 1012 NX Amsterdam',
            'phone' => '06-12345678',
        ]);

        $lisa = User::create([
            'name' => 'Lisa Bakker',
            'email' => 'lisa@hetbureau.nl',
            'password' => Hash::make('welkom123'),
            'role' => 'employee',
            'code_used' => false,
            'address' => 'Prinsengracht 45, 1015 DK Amsterdam',
            'phone' => '06-87654321',
        ]);

        // 2. Products
        $products = [
            [
                'name' => 'Mok',
                'name_nl' => 'Mok',
                'category' => 'Keuken',
                'description' => 'Start elke ochtend goed met de HET BUREAU-mok. Keramisch, 350ml, vaatwasserbestendig.',
                'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart', 'Wit'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Bestseller',
            ],
            [
                'name' => 'T-shirt',
                'name_nl' => 'T-shirt',
                'category' => 'Kleding',
                'description' => '100% biologisch katoen. Relaxed fit, unisex. Ons logo voorop, klein en strak.',
                'image' => 'https://images.unsplash.com/photo-1759572095384-1a7e646d0d4f?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart', 'Wit', 'Geel'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Sweater',
                'name_nl' => 'Sweater',
                'category' => 'Kleding',
                'description' => 'Oversized fleece-lined sweater. Perfect voor het kantoor en daarna.',
                'image' => 'https://images.unsplash.com/photo-1576188973526-0e5d7047b0cf?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Grijs', 'Zwart', 'Crème'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'available' => true,
                'tag' => 'Nieuw',
            ],
            [
                'name' => 'Sokken',
                'name_nl' => 'Sokken',
                'category' => 'Accessoires',
                'description' => 'Comfortabele sokken met ingeweven HET BUREAU-patroon. 80% katoen.',
                'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart/Geel', 'Wit/Zwart'],
                'sizes' => ['36–40', '41–46'],
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Broodtrommel',
                'name_nl' => 'Broodtrommel',
                'category' => 'Keuken',
                'description' => 'Robuuste RVS broodtrommel. Lekdicht, BPA-vrij, geschikt voor de vaatwasser.',
                'image' => 'https://images.unsplash.com/photo-1515706886582-54c73c5eaf41?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Geel', 'Zwart'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Populair',
            ],
            [
                'name' => 'Plak-tattoos',
                'name_nl' => 'Plak-tattoos',
                'category' => 'Fun',
                'description' => 'Set van 6 plak-tattoos met HET BUREAU-graphics. Huidveilig en makkelijk te verwijderen.',
                'image' => 'https://images.unsplash.com/photo-1590330297626-d7aff25a0431?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart', 'Goud'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Fan favourite',
            ],
            [
                'name' => 'Dopper',
                'name_nl' => 'Dopper',
                'category' => 'Accessoires',
                'description' => 'De iconische Dopper met HET BUREAU-logo. 450ml, lekvrij, gemaakt van gerecycled plastic.',
                'image' => 'https://images.unsplash.com/photo-1575377427642-087cf684ad4f?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Geel', 'Zwart', 'Blauw'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Eco',
            ],
            [
                'name' => 'Stickers',
                'name_nl' => 'Stickers',
                'category' => 'Fun',
                'description' => 'Set van 10 vinyl stickers in verschillende HET BUREAU-designs. Waterproof en UV-bestendig.',
                'image' => 'https://images.unsplash.com/photo-1619559246827-ec36cb24e7d1?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Mix'],
                'sizes' => null,
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Beanie',
                'name_nl' => 'Beanie',
                'category' => 'Kleding',
                'description' => 'Gebreide beanie van merino wol. Ingeweven HET BUREAU-logo aan de zijkant.',
                'image' => 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart', 'Geel', 'Grijs'],
                'sizes' => null,
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Pet',
                'name_nl' => 'Pet',
                'category' => 'Kleding',
                'description' => 'Gestructureerde 6-panel cap met geborduurde HET BUREAU-letters. Verstelbare sluiting.',
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Zwart', 'Geel'],
                'sizes' => null,
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Bucket Hat',
                'name_nl' => 'Bucket Hat',
                'category' => 'Kleding',
                'description' => 'Reversible bucket hat. Eén kant geel, andere kant zwart. Beide met HET BUREAU-print.',
                'image' => 'https://images.unsplash.com/photo-1533462732-6d2791586e69?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Geel/Zwart'],
                'sizes' => ['S/M', 'L/XL'],
                'available' => false,
                'tag' => 'Uitverkocht',
            ],
            [
                'name' => 'Tote',
                'name_nl' => 'Tote Bag',
                'category' => 'Accessoires',
                'description' => 'Zware canvas tote bag met lange handvatten. Capaciteit 15L. HET BUREAU in bold print.',
                'image' => 'https://images.unsplash.com/photo-1568650108567-f040f546ce15?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Naturel', 'Zwart'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Bestseller',
            ],
            [
                'name' => 'Sleutelhanger',
                'name_nl' => 'Sleutelhanger',
                'category' => 'Accessoires',
                'description' => 'Gegraveerde metalen sleutelhanger. HET BUREAU-logo in reliëf, mat zwart afgewerkt.',
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Goud', 'Zilver', 'Zwart'],
                'sizes' => null,
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Pins',
                'name_nl' => 'Pins',
                'category' => 'Fun',
                'description' => 'Set van 3 harde emaille pins. Kleurrijke HET BUREAU-icons voor op je jas of tas.',
                'image' => 'https://images.unsplash.com/photo-1599598425947-5202edd56fde?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Geel/Zwart'],
                'sizes' => null,
                'available' => true,
                'tag' => null,
            ],
            [
                'name' => 'Kerstbal',
                'name_nl' => 'Kerstbal',
                'category' => 'Seizoen',
                'description' => 'Handbeschilderde kerstbal met HET BUREAU-logo. Diameter 8cm, inclusief lint.',
                'image' => 'https://images.unsplash.com/photo-1608736551786-b33bb3a4bf48?w=600&h=600&fit=crop&auto=format',
                'colors' => ['Goud', 'Zwart', 'Rood'],
                'sizes' => null,
                'available' => true,
                'tag' => 'Seizoen',
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        // 3. Codes
        Code::create([
            'code' => 'HB-1001',
            'assigned_to' => $jan->id,
            'used' => false,
        ]);

        Code::create([
            'code' => 'HB-1002',
            'assigned_to' => $lisa->id,
            'used' => false,
        ]);

        Code::create(['code' => 'HB-1234', 'used' => false]);
        Code::create(['code' => 'HB-2026', 'used' => false]);
        Code::create(['code' => 'HB-5555', 'used' => false]);
    }
}
