<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Spa & Wellness
            [
                'name' => 'Swedish Massage',
                'description' => '60-minute relaxing full body massage using long, flowing strokes to promote relaxation and well-being.',
                'price' => 120.00,
                'category' => 'spa',
                'duration' => '60 minutes',
                'is_available' => true,
                'image_url' => 'services/spa-massage.jpg'
            ],
            [
                'name' => 'Deep Tissue Massage',
                'description' => '90-minute therapeutic massage targeting deep muscle tension and chronic pain areas.',
                'price' => 150.00,
                'category' => 'spa',
                'duration' => '90 minutes',
                'is_available' => true,
                'image_url' => 'services/deep-tissue.jpg'
            ],
            
            // Dining & Restaurant
            [
                'name' => 'Private Dining Experience',
                'description' => 'Exclusive 5-course dinner prepared by our executive chef in a private setting.',
                'price' => 200.00,
                'category' => 'dining',
                'duration' => '2-3 hours',
                'is_available' => true,
                'image_url' => 'services/private-dining.jpg'
            ],
            [
                'name' => 'In-Room Breakfast',
                'description' => 'Gourmet breakfast served in the comfort of your room.',
                'price' => 45.00,
                'category' => 'dining',
                'duration' => '45 minutes',
                'is_available' => true,
                'image_url' => 'services/room-breakfast.jpg'
            ],

            // Transportation
            [
                'name' => 'Airport Transfer',
                'description' => 'Luxury vehicle transfer between hotel and airport.',
                'price' => 80.00,
                'category' => 'transport',
                'duration' => 'Varies',
                'is_available' => true,
                'image_url' => 'services/airport-transfer.jpg'
            ],
            [
                'name' => 'City Tour Service',
                'description' => 'Private guided tour of city highlights in a luxury vehicle.',
                'price' => 150.00,
                'category' => 'transport',
                'duration' => '4 hours',
                'is_available' => true,
                'image_url' => 'services/city-tour.jpg'
            ],

            // Laundry
            [
                'name' => 'Express Laundry',
                'description' => 'Same-day laundry and pressing service.',
                'price' => 50.00,
                'category' => 'laundry',
                'duration' => '6 hours',
                'is_available' => true,
                'image_url' => 'services/express-laundry.jpg'
            ],
            [
                'name' => 'Dry Cleaning',
                'description' => 'Professional dry cleaning service with 24-hour turnaround.',
                'price' => 35.00,
                'category' => 'laundry',
                'duration' => '24 hours',
                'is_available' => true,
                'image_url' => 'services/dry-cleaning.jpg'
            ],

            // Activities & Recreation
            [
                'name' => 'Personal Training Session',
                'description' => 'One-on-one fitness session with certified trainer.',
                'price' => 90.00,
                'category' => 'activities',
                'duration' => '60 minutes',
                'is_available' => true,
                'image_url' => 'services/personal-training.jpg'
            ],
            [
                'name' => 'Yoga Class',
                'description' => 'Private or group yoga session with experienced instructor.',
                'price' => 40.00,
                'category' => 'activities',
                'duration' => '60 minutes',
                'is_available' => true,
                'image_url' => 'services/yoga.jpg'
            ],

            // Business Services
            [
                'name' => 'Meeting Room Rental',
                'description' => 'Fully equipped meeting room with AV equipment and refreshments.',
                'price' => 200.00,
                'category' => 'business',
                'duration' => 'Per day',
                'is_available' => true,
                'image_url' => 'services/meeting-room.jpg'
            ],
            [
                'name' => 'Business Center Services',
                'description' => 'Printing, scanning, and administrative support services.',
                'price' => 25.00,
                'category' => 'business',
                'duration' => 'Per hour',
                'is_available' => true,
                'image_url' => 'services/business-center.jpg'
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 