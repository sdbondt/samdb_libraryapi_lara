<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => env('ADMIN_USERNAME'),
            'password' => env('ADMIN_PASSWORD')
        ]);

        User::create([
            'username' => env('USER_USERNAME'),
            'password' => env('USER_PASSWORD')
        ]);

        $scifi = Category::create(['name' => 'science fiction', 'slug' => Str::slug('science fiction')]);
        $fantasy = Category::create(['name' => 'fantasy', 'slug' => Str::slug('fantasy')]);
        $thriller = Category::create(['name' => 'thriller', 'slug' => Str::slug('thriller')]);
        $horror = Category::create(['name' => 'horror', 'slug' => Str::slug('horror')]);
        $history= Category::create(['name' => 'history', 'slug' => Str::slug('history')]);
        $novel = Category::create(['name' => 'novel', 'slug' => Str::slug('novel')]);
        $nonFiction = Category::create(['name' => 'non fiction', 'slug' => Str::slug('non fiction')]);

        $jkR = Author::create([
            'first_name' => 'J.K.',
            'last_name' => 'Rowling'
        ]);

        $book1 = Book::create([
            'author_id' => $jkR->id,
            'title' => 'Harry Potter and the halfblood prince',
            'description' => fake()->paragraph()
        ]);
        $book1->categories()->saveMany([$scifi, $fantasy]);

        $book2 = Book::create([
            'author_id' => $jkR->id,
            'title' => 'Harry Potter and the prisoner of Azkaban',
            'description' => fake()->paragraph()
        ]);
        $book2->categories()->saveMany([$scifi, $fantasy]);

        $fsF = Author::create([
            'first_name' => 'Francis',
            'middle_name' => 'Scott',
            'last_name' => 'Fitzgerald'
        ]);

        $book3 = Book::create([
            'author_id' => $fsF->id,
            'title' => 'The great Gatsby',
            'description' => fake()->paragraph()
        ]);
        $book3->categories()->saveMany([$novel, $history]);

        $book4 = Book::create([
            'author_id' => $fsF->id,
            'title' => 'The curious case of Benjamin Button',
            'description' => fake()->paragraph()
        ]);
        $book4->categories()->saveMany([$novel, $fantasy]);

        $sK = Author::create([
            'first_name' => 'Stephen',
            'last_name' => 'King'
        ]);

        $book5 = Book::create([
            'author_id' => $sK->id,
            'title' => 'The shawshank redemption',
            'description' => fake()->paragraph()
        ]);
        $book5->categories()->saveMany([$thriller, $horror]);

        $book6 = Book::create([
            'author_id' => $sK->id,
            'title' => 'The green mile',
            'description' => fake()->paragraph()
        ]);
        $book6->categories()->saveMany([$thriller, $horror]);

        $dB = Author::create([
            'first_name' => 'Dan',
            'last_name' => 'Brown'
        ]);

        $book7 = Book::create([
            'author_id' => $dB->id,
            'title' => 'The Da Vinci code',
            'description' => fake()->paragraph()
        ]);
        $book7->categories()->saveMany([$thriller, $novel]);

        $book8 = Book::create([
            'author_id' => $dB->id,
            'title' => 'Bernini mysterie',
            'description' => fake()->paragraph()
        ]);
        $book8->categories()->saveMany([$thriller, $novel]);

        $aC = Author::create([
            'first_name' => 'Agatha',
            'last_name' => 'Christie'
        ]);

        $book9 = Book::create([
            'author_id' => $aC->id,
            'title' => 'Murder on the Orient Express',
            'description' => fake()->paragraph()
        ]);
        $book9->categories()->saveMany([$thriller, $history, $novel]);

        $book10 = Book::create([
            'author_id' => $aC->id,
            'title' => 'Death on the Nile',
            'description' => fake()->paragraph()
        ]);
        $book10->categories()->saveMany([$thriller, $novel]);

        Client::factory(10)->create();
    }
}
