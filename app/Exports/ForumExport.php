<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ForumExport implements FromView, WithTitle
{
    protected $forums;
    protected $users;

    public function __construct(array $forums, array $users)
    {
        $this->forums = $forums;
        $this->users = $users;
    }

    public function title() : string
    {
        return 'foros';
    }

    public function view(): View
    {
        header('Set-Cookie: fileDownload=true; path=/');
        return view('forum.exportar', [
            'forums' => $this->forums,
            'users' => $this->users,
        ]);
    }
}
