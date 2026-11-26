<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\ChapterPage;
use App\Models\Favorite;
use App\Models\Genre;
use App\Models\Library;
use App\Models\Manga;
use App\Models\ReadingProgress;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationsTest extends TestCase
{
    use RefreshDatabase;

    private function createManga(): Manga
    {
        return Manga::create([
            'title' => 'Test Manga',
            'slug' => 'test-manga',
            'description' => 'Test description',
            'type' => 'manga',
            'status' => 'ongoing',
        ]);
    }

    public function test_user_belongs_to_role(): void
    {
        $user = User::factory()->create();

        $user->refresh();

        $this->assertNotNull($user->role_id);

        $this->assertNotNull($user->role);

        $this->assertSame('reader', $user->role->slug);

        $this->assertTrue(
            $user->role->users->contains($user)
        );
    }

    public function test_manga_has_genres(): void
    {
        $manga = $this->createManga();

        $genre = Genre::create([
            'name' => 'Action',
            'slug' => 'action',
        ]);

        $manga->genres()->attach($genre->id);

        $this->assertTrue(
            $manga->genres->contains($genre)
        );

        $this->assertTrue(
            $genre->manga->contains($manga)
        );
    }

    public function test_manga_has_chapters_and_pages(): void
    {
        $manga = $this->createManga();

        $chapter = Chapter::create([
            'manga_id' => $manga->id,
            'number' => 1,
            'title' => 'Chapter 1',
        ]);

        $page = ChapterPage::create([
            'chapter_id' => $chapter->id,
            'page_number' => 1,
            'image_path' => 'test/page-1.svg',
        ]);

        $this->assertTrue(
            $manga->chapters->contains($chapter)
        );

        $this->assertTrue(
            $chapter->pages->contains($page)
        );

        $this->assertTrue(
            $page->chapter->is($chapter)
        );

        $this->assertTrue(
            $chapter->manga->is($manga)
        );
    }

    public function test_user_can_have_library_entries(): void
    {
        $user = User::factory()->create();

        $manga = $this->createManga();

        $library = Library::create([
            'user_id' => $user->id,
            'manga_id' => $manga->id,
            'status' => 'reading',
        ]);

        $this->assertTrue(
            $user->libraries->contains($library)
        );

        $this->assertTrue(
            $manga->libraries->contains($library)
        );

        $this->assertSame('reading', $library->status);
    }

    public function test_user_can_have_favorites(): void
    {
        $user = User::factory()->create();

        $manga = $this->createManga();

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'manga_id' => $manga->id,
        ]);

        $this->assertTrue(
            $user->favorites->contains($favorite)
        );

        $this->assertTrue(
            $manga->favorites->contains($favorite)
        );
    }

    public function test_reading_progress_has_correct_relations(): void
    {
        $user = User::factory()->create();

        $manga = $this->createManga();

        $chapter = Chapter::create([
            'manga_id' => $manga->id,
            'number' => 1,
        ]);

        $page = ChapterPage::create([
            'chapter_id' => $chapter->id,
            'page_number' => 1,
            'image_path' => 'test/page-1.svg',
        ]);

        $progress = ReadingProgress::create([
            'user_id' => $user->id,
            'manga_id' => $manga->id,
            'chapter_page_id' => $page->id,
        ]);

        $this->assertTrue(
            $progress->user->is($user)
        );

        $this->assertTrue(
            $progress->manga->is($manga)
        );

        $this->assertTrue(
            $progress->chapterPage->is($page)
        );
    }

    public function test_manga_average_rating_is_calculated(): void
    {
        $manga = $this->createManga();

        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        Review::create([
            'user_id' => $firstUser->id,
            'manga_id' => $manga->id,
            'rating' => 5,
            'comment' => 'Excellent',
        ]);

        Review::create([
            'user_id' => $secondUser->id,
            'manga_id' => $manga->id,
            'rating' => 4,
            'comment' => 'Good',
        ]);

        $this->assertCount(2, $manga->reviews);

        $this->assertEquals(
            4.5,
            $manga->averageRating()
        );
    }

    public function test_deleting_manga_removes_related_chapters(): void
    {
        $manga = $this->createManga();

        $chapter = Chapter::create([
            'manga_id' => $manga->id,
            'number' => 1,
        ]);

        $page = ChapterPage::create([
            'chapter_id' => $chapter->id,
            'page_number' => 1,
            'image_path' => 'test/page-1.svg',
        ]);

        $manga->delete();

        $this->assertDatabaseMissing('chapters', [
            'id' => $chapter->id,
        ]);

        $this->assertDatabaseMissing('chapter_pages', [
            'id' => $page->id,
        ]);
    }
}
