<?php

namespace Database\Seeders;

use App\Dictionaries\StatusPostDictionary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->where(['name' => 'LingCard'])->first()->id;
        $ruLangId = DB::table('languages')->where(['code' => 'ru'])->first()->id;
        $enLangId = DB::table('languages')->where(['code' => 'en'])->first()->id;
        $kzLangId = DB::table('languages')->where(['code' => 'kz'])->first()->id;
        $esLangId = DB::table('languages')->where(['code' => 'es'])->first()->id;
        $frLangId = DB::table('languages')->where(['code' => 'fr'])->first()->id;
        $deLangId = DB::table('languages')->where(['code' => 'de'])->first()->id;
        $ptLangId = DB::table('languages')->where(['code' => 'pt'])->first()->id;
        $zhLangId = DB::table('languages')->where(['code' => 'cn'])->first()->id;
        $jaLangId = DB::table('languages')->where(['code' => 'jp'])->first()->id;
        $koLangId = DB::table('languages')->where(['code' => 'kr'])->first()->id;
        $arLangId = DB::table('languages')->where(['code' => 'sa'])->first()->id;

        $posts = [
            [
                'content' => 'Всем привет! Рады сообщить, что LingCard открыт для всех желающих изучать языки разных стран. Если интересующего вас языка нет, сообщите нам или проголосуйте за его добавление.',
                'date' => now(),
                'title' => 'Стартуем!',
                'language_id' => $ruLangId,
                'user_id' => $userId,
                'address' => 'Россия',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Барлығына сәлем! LingCard түрлі елдердің тілдерін үйренгісі келетіндердің бәріне ашық екенін хабарлауға қуаныштымыз. Егер сізді қызықтыратын тіл жоқ болса, бізге хабарлаңыз немесе оны қосуды дауыстап қолдаңыз.',
                'date' => now(),
                'title' => 'Бастаймыз!',
                'language_id' => $kzLangId,
                'user_id' => $userId,
                'address' => 'Қазақстан',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Hello everyone! We are happy to announce that LingCard is now open to everyone who wants to learn languages from different countries. If your language of interest is not available, let us know or vote for its addition.',
                'date' => now(),
                'title' => 'We\'re starting!',
                'language_id' => $enLangId,
                'user_id' => $userId,
                'address' => 'United Kingdom',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => '¡Hola a todos! Nos complace anunciar que LingCard está abierto para todos aquellos que quieran aprender idiomas de diferentes países. Si tu idioma de interés no está disponible, infórmanos o vota por su inclusión.',
                'date' => now(),
                'title' => '¡Empezamos!',
                'language_id' => $esLangId,
                'user_id' => $userId,
                'address' => 'España',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Bonjour à tous! Nous sommes ravis d\'annoncer que LingCard est ouvert à tous ceux qui souhaitent apprendre des langues de différents pays. Si votre langue d\'intérêt n\'est pas disponible, faites-le nous savoir ou votez pour son ajout.',
                'date' => now(),
                'title' => 'Nous commençons!',
                'language_id' => $frLangId,
                'user_id' => $userId,
                'address' => 'France',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Hallo zusammen! Wir freuen uns, bekannt zu geben, dass LingCard für alle geöffnet ist, die Sprachen aus verschiedenen Ländern lernen möchten. Wenn Ihre gewünschte Sprache nicht verfügbar ist, teilen Sie uns dies mit oder stimmen Sie für deren Hinzufügung ab.',
                'date' => now(),
                'title' => 'Wir starten!',
                'language_id' => $deLangId,
                'user_id' => $userId,
                'address' => 'Deutschland',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Olá a todos! Temos o prazer de anunciar que o LingCard está aberto para todos aqueles que desejam aprender idiomas de diferentes países. Se o seu idioma de interesse não estiver disponível, informe-nos ou vote para adicioná-lo.',
                'date' => now(),
                'title' => 'Estamos começando!',
                'language_id' => $ptLangId,
                'user_id' => $userId,
                'address' => 'Portugal',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => '大家好！我们很高兴地宣布，LingCard向所有想学习不同国家语言的人开放。如果您感兴趣的语言尚未提供，请告诉我们或投票支持添加。',
                'date' => now(),
                'title' => '我们开始了！',
                'language_id' => $zhLangId,
                'user_id' => $userId,
                'address' => '中国',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => '皆さん、こんにちは！LingCardが様々な国の言語を学びたいすべての方に開放されたことをお知らせできることを嬉しく思います。ご興味のある言語が利用できない場合は、お知らせいただくか、追加に投票してください。',
                'date' => now(),
                'title' => 'スタートします！',
                'language_id' => $jaLangId,
                'user_id' => $userId,
                'address' => '日本',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => '여러분 안녕하세요! LingCard가 다양한 국가의 언어를 배우고자 하는 모든 분들에게 개방되었음을 알리게 되어 기쁩니다. 관심 있는 언어가 제공되지 않는 경우 저희에게 알려주시거나 추가에 투표해 주세요.',
                'date' => now(),
                'title' => '시작합니다!',
                'language_id' => $koLangId,
                'user_id' => $userId,
                'address' => '한국',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'مرحباً بالجميع! يسعدنا أن نعلن أن LingCard مفتوح للجميع الراغبين في تعلم لغات من مختلف البلدان. إذا كانت لغتك المفضلة غير متوفرة، أخبرنا بذلك أو صوت لإضافتها.',
                'date' => now(),
                'title' => 'نحن نبدأ!',
                'language_id' => $arLangId,
                'user_id' => $userId,
                'address' => 'السعودية',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ]
        ];

        DB::table('posts')->truncate();
        foreach ($posts as $post) {
            DB::table('posts')->insert($post);
        }
    }
}
