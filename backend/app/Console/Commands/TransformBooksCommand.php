<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

#[Signature('app:transform-books-command')]
#[Description('Command description')]
class TransformBooksCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseFilePath = base_path('data/books');
        $books = array_diff(scandir($baseFilePath), ['.', '..']);
        foreach ($books as $book) {
            DB::beginTransaction();
            try {
                $json = json_decode(file_get_contents($baseFilePath . '/' . $book));

                $authorName = $json->author;
                $langCode = $json->language;
                $langID = DB::table('languages')->where(['code' => $langCode])->first()->id;
                $bookName = $json->title;
                $yearIssue = $json->year;
                $chapters = json_decode($json->chapters);
                if (!DB::table('authors')->where('name', $authorName)->exists()) {
                    $authorID = DB::table('authors')->insertGetId([
                        'name' => $authorName,
                    ]);
                }
                else {
                    $authorID = DB::table('authors')->where('name', $authorName)->first()->id;
                }
                $bookID = DB::table('books')->insertGetId([
                    'author_id' => $authorID,
                    'language_id' => $langID,
                    'title' => $bookName,
                    'year' => $yearIssue
                ]);
                foreach ($chapters as $chapter) {
                    DB::table('chapters')->insert([
                        'book_id' => $bookID,
                        'number' => $chapter->number,
                        'name' => $chapter->name,
                        'content' => $chapter->content,
                    ]);
                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollBack();
            }
        }
    }
}
