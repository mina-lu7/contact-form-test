<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');

        return [
            'categry_id' => $faker->numberBetween(1, 5),
            'first_name' => $faker->lastName,
            'last_name'  => $faker->firstName,
            'gender'     => $faker->numberBetween(1, 3),
            'email'      => $faker->unique()->safeEmail,
            'tel'        => $faker->numerify('###########'),
            'address'    => $faker->address,
            'building'   => $faker->optional()->secondaryAddress,
            'detail'     => $faker->randomElement([
                '商品について確認したいです。',
                '配送状況を教えてください。',
                '交換手続きについて知りたいです。',
                '不具合がありました。対応をお願いします。',
                'その他のお問い合わせです。',
            ]),
        ];
    }
}
