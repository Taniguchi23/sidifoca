<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseExport implements FromView
{
    protected $courses;
    protected $users;

    public function __construct(array $courses, array $users)
    {
        $this->courses = $courses;
        $this->users = $users;
    }

    public function view(): View
    {
        header('Set-Cookie: fileDownload=true; path=/');
        return view('course.exportar', [
            'courses' => $this->courses,
            'users' => $this->users,
        ]);
    }
}
