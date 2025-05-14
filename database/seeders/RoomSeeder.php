<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            'Standard' => [
                'price_range' => [100, 150],
                'capacity' => 2,
                'amenities' => ['TV', 'Air Conditioning', 'Wi-Fi', 'Mini Fridge', 'Coffee Maker']
            ],
            'Deluxe' => [
                'price_range' => [180, 250],
                'capacity' => 2,
                'amenities' => ['TV', 'Air Conditioning', 'Wi-Fi', 'Mini Fridge', 'Coffee Maker', 'Desk', 'Safe', 'Bathtub']
            ],
            'Suite' => [
                'price_range' => [300, 450],
                'capacity' => 3,
                'amenities' => ['TV', 'Air Conditioning', 'Wi-Fi', 'Mini Fridge', 'Coffee Maker', 'Desk', 'Safe', 'Bathtub', 'Living Area', 'Mini Bar']
            ],
            'Executive Suite' => [
                'price_range' => [500, 750],
                'capacity' => 4,
                'amenities' => ['Smart TV', 'Climate Control', 'High-Speed Wi-Fi', 'Full-Size Refrigerator', 'Coffee Machine', 'Work Station', 'Safe', 'Jacuzzi', 'Living Room', 'Mini Bar', 'Dining Area']
            ],
            'Presidential Suite' => [
                'price_range' => [1000, 1500],
                'capacity' => 6,
                'amenities' => ['Smart TV', 'Climate Control', 'High-Speed Wi-Fi', 'Full-Size Refrigerator', 'Coffee Machine', 'Work Station', 'Safe', 'Jacuzzi', 'Living Room', 'Full Bar', 'Dining Room', 'Kitchen', 'Private Balcony']
            ]
        ];

        $rooms = [
            // Floor 1 - Standard Rooms
            ['101', 'Standard', 1, false, false],
            ['102', 'Standard', 1, false, false],
            ['103', 'Standard', 1, true, false],
            ['104', 'Standard', 1, true, false],
            
            // Floor 2 - Deluxe Rooms
            ['201', 'Deluxe', 2, true, false],
            ['202', 'Deluxe', 2, true, false],
            ['203', 'Deluxe', 2, true, true],
            ['204', 'Deluxe', 2, true, true],
            
            // Floor 3 - Suites
            ['301', 'Suite', 3, true, false],
            ['302', 'Suite', 3, true, false],
            ['303', 'Suite', 3, true, false],
            ['304', 'Suite', 3, true, true],
            
            // Floor 4 - Executive Suites
            ['401', 'Executive Suite', 4, true, false],
            ['402', 'Executive Suite', 4, true, false],
            ['403', 'Executive Suite', 4, true, false],
            ['404', 'Executive Suite', 4, true, false],
            
            // Floor 5 - Mix of Executive and Presidential
            ['501', 'Executive Suite', 5, true, false],
            ['502', 'Executive Suite', 5, true, false],
            ['503', 'Presidential Suite', 5, true, false],
            ['504', 'Presidential Suite', 5, true, false],
        ];

        foreach ($rooms as [$room_number, $type, $floor, $has_view, $is_smoking]) {
            $typeDetails = $roomTypes[$type];
            
            // Generate a random image ID for each room (1-1000)
            $imageId = rand(1, 1000);
            
            /* Future image handling:
             * 1. For multiple images, you could:
             *    - Generate different image IDs for each type of image
             *    - Use specific Lorem Picsum categories for different room aspects
             *    - Create a separate image seeder for the room_images table
             * 
             * Example:
             * $mainImageId = rand(1, 1000);
             * $bathroomImageId = rand(1, 1000);
             * $viewImageId = rand(1, 1000);
             * 
             * Or with a separate RoomImage model:
             * RoomImage::create([
             *     'room_id' => $room->id,
             *     'image_url' => "https://picsum.photos/id/{$imageId}/800/600",
             *     'image_type' => 'main',
             *     'sort_order' => 1,
             *     'is_featured' => true
             * ]);
             */
            
            Room::create([
                'room_number' => $room_number,
                'type' => $type,
                'floor' => $floor,
                'price_per_night' => rand($typeDetails['price_range'][0], $typeDetails['price_range'][1]),
                'capacity' => $typeDetails['capacity'],
                'description' => $this->getDescription($type),
                'amenities' => $typeDetails['amenities'],
                'status' => 'Available',
                'has_view' => $has_view,
                'is_smoking' => $is_smoking,
                'image_url' => "https://source.unsplash.com/800x600/?" . urlencode("hotel room $type")
            ]);
        }
    }

    private function getDescription($type): string
    {
        return match ($type) {
            'Standard' => 'Comfortable and cozy room perfect for solo travelers or couples. Features modern amenities and elegant decor.',
            'Deluxe' => 'Spacious room with premium furnishings and enhanced amenities. Perfect for guests seeking extra comfort.',
            'Suite' => 'Luxurious suite with separate living area, offering expanded space and superior amenities for a truly comfortable stay.',
            'Executive Suite' => 'Premium suite featuring upscale amenities, separate living and working areas, and spectacular city views.',
            'Presidential Suite' => 'Our most luxurious accommodation, offering unparalleled luxury with multiple rooms, premium amenities, and personalized service.',
            default => 'Comfortable hotel room with modern amenities.'
        };
    }
}
