<?php

namespace Database\Factories;

use App\Models\Academic\Book;
use App\Models\Academic\Grade;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Section;
use App\Models\Teacher;
use App\Models\Academic\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        $fileName = Str::slug($title) . '_' . time() . '.pdf';

        Storage::disk('local')->put('library/' . $fileName, 'Dummy PDF content for: ' . $title);

        $gradeId = Grade::inRandomOrder()->first()->id ?? 1;
        $classroomId = $this->faker->randomElement([null, ClassRoom::where('grade_id', $gradeId)->inRandomOrder()->first()->id ?? null]);
        $sectionId = $classroomId ? $this->faker->randomElement([null, Section::where('classroom_id', $classroomId)->inRandomOrder()->first()->id ?? null]) : null;

        return [
            'title' => $title,
            'description' => $this->faker->paragraph(2),
            'file_name' => $fileName,
            'grade_id' => $gradeId,
            'classroom_id' => $classroomId,
            'section_id' => $sectionId,
            'teacher_id' => Teacher::inRandomOrder()->first()->id ?? 1,
            'subject_id' => Subject::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
