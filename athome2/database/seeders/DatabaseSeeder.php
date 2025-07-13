<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\House;
use App\Models\Media;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Get both users
        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        // House types array (reuse for both users)
        $houseTypes = [
            [
                'houseName' => 'Modern Apartment',
                'housetype' => 'Studio Type',
                'images' => ['studio_1.jpg', 'studio_2.jpg', 'studio_3.jpg','studio_4.jpg', 'studio_5.jpg', 'studio_6.jpg'],
            ],
            [
                'houseName' => 'Cozy One Bedroom Apartment',
                'housetype' => 'One Bedroom',
                'images' => ['onebedroom_1.jpg', 'onebedroom_2.jpg', 'onebedroom_3.jpg', 'onebedroom_4.jpg', 'onebedroom_5.jpg', 'onebedroom_6.jpg', 'onebedroom_7.jpg'],
            ],
            [
                'houseName' => 'Classic Two Bedroom House',
                'housetype' => 'Two Bedroom',
                'images' => ['twobedroom_1.jpg', 'twobedroom_2.jpg', 'twobedroom_3.jpg', 'twobedroom_4.jpg', 'twobedroom_5.jpg', 'twobedroom_6.jpg'],
            ],
            [
                'houseName' => 'Luxury Condo',
                'housetype' => 'Condo',
                'images' => ['condo_1.jpg', 'condo_2.jpg', 'condo_3.jpg', 'condo_4.jpg', 'condo_5.jpg', 'condo_6.jpg'],
            ],
            [
                'houseName' => 'Homey Townhouse',
                'housetype' => 'Townhouse',
                'images' => ['townhouse_1.jpg', 'townhouse_2.jpg', 'townhouse_3.jpg', 'townhouse_4.jpg', 'townhouse_5.jpg', 'townhouse_6.jpg'],
            ],
            [
                'houseName' => 'Prestigious Villa Penthouse',
                'housetype' => 'Penthouse',
                'images' => ['penthouse_1.jpg', 'penthouse_2.jpg', 'penthouse_3.jpg', 'penthouse_4.jpg', 'penthouse_5.jpg', 'penthouse_6.jpg'],
            ],
            [
                'houseName' => 'Spacious Entire Private House',
                'housetype' => 'Entire House',
                'images' => ['entirehouse_1.jpg', 'entirehouse_2.jpg', 'entirehouse_3.jpg', 'entirehouse_4.jpg', 'entirehouse_5.jpg', 'entirehouse_6.jpg'],
            ],
        ];

        // Seed for Regular User
        foreach ($houseTypes as $type) {
            $house = House::create([
                'houseName' => $type['houseName'],
                'housetype' => $type['housetype'],
                'street' => '123 Example St',
                'region' => 'NCR',
                'province' => 'Metro Manila',
                'city' => 'Quezon City',
                'barangay' => 'Bagumbayan',
                'total_occupants' => 4,
                'total_rooms' => 2,
                'total_bathrooms' => 1,
                'description' => 'A beautiful ' . strtolower($type['housetype']) . ' perfect for your stay.',
                'rules' => "No smoking\nNo Visitor after 10pm\nNo parties",
                'has_aircon' => true,
                'has_kitchen' => true,
                'has_wifi' => true,
                'has_parking' => true,
                'has_gym' => false,
                'has_patio' => false,
                'has_pool' => false,
                'is_petfriendly' => false,
                'electric_meter' => true,
                'water_meter' => true,
                'price' => rand(1000, 5000),
                'user_id' => $user->id,
                'status' => true,
                'latitude' => 14.5813,
                'longitude' => 120.9762,
            ]);

            foreach ($type['images'] as $img) {
                Media::create([
                    'house_id' => $house->id,
                    'image_path' => 'seeders/images/' . $img,
                ]);
            }
        }

        // Seed for Admin User
        foreach ($houseTypes as $type) {
            $house = House::create([
                'houseName' => $type['houseName'],
                'housetype' => $type['housetype'],
                'street' => '456 Admin Ave',
                'region' => 'NCR',
                'province' => 'Metro Manila',
                'city' => 'Makati City',
                'barangay' => 'San Lorenzo',
                'total_occupants' => 6,
                'total_rooms' => 3,
                'total_bathrooms' => 2,
                'description' => 'A beautiful ' . strtolower($type['housetype']) . ' with premium features.',
                'rules' => "No smoking\nNo pets\nNo loud music after 9pm",
                'has_aircon' => true,
                'has_kitchen' => true,
                'has_wifi' => true,
                'has_parking' => true,
                'has_gym' => true,
                'has_patio' => true,
                'has_pool' => true,
                'is_petfriendly' => true,
                'electric_meter' => true,
                'water_meter' => true,
                'price' => rand(2000, 7000),
                'user_id' => $admin->id,
                'status' => true,
                'latitude' => 14.5813,
                'longitude' => 120.9762,
            ]);

            foreach ($type['images'] as $img) {
                Media::create([
                    'house_id' => $house->id,
                    'image_path' => 'seeders/images/' . $img,
                ]);
            }
        }
    }
}