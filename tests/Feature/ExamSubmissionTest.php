<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestSection;
use App\Models\TestSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_submits_exam_calculates_band_and_updates_streak(): void
    {
        // 1. Arrange test fixtures
        $user = User::factory()->create([
            'streak_count' => 0,
            'last_study_date' => null,
            'xp_points' => 0,
        ]);

        $category = TestCategory::create([
            'name' => 'IELTS Academic',
            'slug' => 'ielts-academic',
        ]);

        $set = TestSet::create([
            'category_id' => $category->id,
            'title' => 'Cam 19',
            'slug' => 'cam-19',
        ]);

        $test = Test::create([
            'test_set_id' => $set->id,
            'title' => 'Reading Test 1',
            'slug' => 'reading-test-1',
            'type' => 'reading',
            'duration_minutes' => 60,
            'total_questions' => 2,
        ]);

        $section = TestSection::create([
            'test_id' => $test->id,
            'section_number' => 1,
            'title' => 'Passage 1',
        ]);

        $group = QuestionGroup::create([
            'section_id' => $section->id,
            'instruction' => 'Choose TRUE/FALSE',
            'question_type' => 'true_false_not_given',
        ]);

        $q1 = Question::create([
            'group_id' => $group->id,
            'question_number' => 1,
            'content' => 'Statement 1',
            'correct_answer' => 'TRUE',
        ]);

        $q2 = Question::create([
            'group_id' => $group->id,
            'question_number' => 2,
            'content' => 'Statement 2',
            'correct_answer' => 'FALSE',
        ]);

        // 2. Act: Submit test via CQRS API endpoint
        $response = $this->actingAs($user)->postJson(route('ielts.submit', ['id' => $test->id]), [
            'mode' => 'full_test',
            'time_spent_seconds' => 1800,
            'answers' => [
                $q1->id => 'TRUE',
                $q2->id => 'FALSE',
            ],
        ]);

        // 3. Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'result' => [
                'testId' => $test->id,
                'scoreRaw' => 2,
                'totalQuestions' => 2,
            ],
        ]);

        $this->assertDatabaseHas('test_submissions', [
            'user_id' => $user->id,
            'test_id' => $test->id,
            'score_raw' => 2,
        ]);

        $this->assertDatabaseHas('user_answers', [
            'question_id' => $q1->id,
            'is_correct' => true,
        ]);

        $this->assertDatabaseHas('user_answers', [
            'question_id' => $q2->id,
            'is_correct' => true,
        ]);

        // Verify Streak was recorded
        $user->refresh();
        $this->assertEquals(1, $user->streak_count);
        $this->assertGreaterThan(0, $user->xp_points);
    }
}
