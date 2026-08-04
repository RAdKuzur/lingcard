<?php

namespace Tests\Unit;

use App\Dictionaries\RoleDictionary;
use App\Dictionaries\StatusPostDictionary;
use App\Dictionaries\StatusReactionDictionary;
use App\Models\Language;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\ReactionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReactionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_increment_post_view_count(): void
    {
        $language = Language::create([
            'name' => 'Русский',
            'code' => 'ru',
            'is_active' => true
        ]);
        $user = User::create([
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'LingCard',
            'base_language_id' => $language->id,
            'target_language_id' => $language->id,
            'role' => RoleDictionary::ADMIN,
            'is_banned' => false
        ]);
        $post = Post::create([
            'content' => 'Всем привет! Рады сообщить, что LingCard открыт для всех желающих изучать языки разных стран. Если интересующего вас языка нет, сообщите нам или проголосуйте за его добавление.',
            'date' => now(),
            'title' => 'Стартуем!',
            'language_id' => $language->id,
            'user_id' => $user->id,
            'address' => 'Россия',
            'status' => StatusPostDictionary::APPROVED,
            'views_count' => 0,
            'likes_count' => 0,
            'dislikes_count' => 0
        ]);
        (new PostRepository())->incrementViewsCount($post->id);
        $updatedPost = Post::find($post->id);
        $this->assertEquals(1, $updatedPost->views_count);
    }
    public function test_like_count_view(): void
    {
        $language = Language::create([
            'name' => 'Русский',
            'code' => 'ru',
            'is_active' => true
        ]);
        $user = User::create([
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'LingCard',
            'base_language_id' => $language->id,
            'target_language_id' => $language->id,
            'role' => RoleDictionary::ADMIN,
            'is_banned' => false
        ]);
        $post = Post::create([
            'content' => 'Всем привет! Рады сообщить, что LingCard открыт для всех желающих изучать языки разных стран. Если интересующего вас языка нет, сообщите нам или проголосуйте за его добавление.',
            'date' => now(),
            'title' => 'Стартуем!',
            'language_id' => $language->id,
            'user_id' => $user->id,
            'address' => 'Россия',
            'status' => StatusPostDictionary::APPROVED,
            'views_count' => 0,
            'likes_count' => 0,
            'dislikes_count' => 0
        ]);
        (new ReactionRepository())->insert([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'status' => StatusReactionDictionary::LIKE
        ]);
        $count = (new ReactionRepository())->countLikes($post->id);
        $this->assertEquals(1, $count);
    }
    public function test_dislike_count(): void
    {
        $language = Language::create([
            'name' => 'Русский',
            'code' => 'ru',
            'is_active' => true
        ]);
        $user = User::create([
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'LingCard',
            'base_language_id' => $language->id,
            'target_language_id' => $language->id,
            'role' => RoleDictionary::ADMIN,
            'is_banned' => false
        ]);
        $post = Post::create([
            'content' => 'Всем привет! Рады сообщить, что LingCard открыт для всех желающих изучать языки разных стран. Если интересующего вас языка нет, сообщите нам или проголосуйте за его добавление.',
            'date' => now(),
            'title' => 'Стартуем!',
            'language_id' => $language->id,
            'user_id' => $user->id,
            'address' => 'Россия',
            'status' => StatusPostDictionary::APPROVED,
            'views_count' => 0,
            'likes_count' => 0,
            'dislikes_count' => 0
        ]);
        (new ReactionRepository())->insert([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'status' => StatusReactionDictionary::DISLIKE
        ]);
        $count = (new ReactionRepository())->countDislikes($post->id);
        $this->assertEquals(1, $count);
    }
}
