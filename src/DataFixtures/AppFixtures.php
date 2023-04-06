<?php

namespace App\DataFixtures;

use App\Entity\Manager;
use App\Entity\Product;
use App\Entity\ProductStore;
use App\Entity\Store;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $gerant = new Manager('John', 'DOE');

        // create 10 stores
        $stores = [];
        for ($i = 0; $i < 10; $i++) {
            $store = new Store(
                $faker->company, 
                $faker->latitude, 
                $faker->longitude, 
                $faker->streetAddress, 
                $faker->postCode, 
                $faker->city, 
                $gerant
            );

            $manager->persist($store);
            $stores[] = $store;
        }

        // create 20 products
        $products = [];
        for ($i = 0; $i < 20; $i++) {
            $product = new Product($faker->sentence(2));

            $manager->persist($product);
            $products[] = $product;
        }

        // assign random quantities of products to each store
        foreach ($stores as $store) {
            foreach ($products as $product) {
                $productStore = new ProductStore($product, $store, $faker->numberBetween(0, 100));

                $manager->persist($productStore);
            }
        }

        $manager->flush();
    }
}
