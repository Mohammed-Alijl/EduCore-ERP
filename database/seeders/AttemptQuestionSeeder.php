<?php

namespace Database\Seeders;

use App\Models\Assessments\AttemptQuestion;
use App\Models\Assessments\ExamAttempt;
use App\Models\Assessments\Question;
use Illuminate\Database\Seeder;

class AttemptQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attempts = ExamAttempt::all();
        $questions = Question::all();

        if ($attempts->isEmpty() || $questions->isEmpty()) {
            $this->command->info('Please seed ExamAttempts and Questions first.');

            return;
        }

        foreach ($attempts as $attempt) {
            $numberOfQuestions = rand(5, min(10, $questions->count()));
            $randomQuestions = $questions->random($numberOfQuestions);

            foreach ($randomQuestions as $index => $question) {
                AttemptQuestion::factory()->create([
                    'exam_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'question_order' => $index + 1,
                ]);
            }
        }
    }
}
