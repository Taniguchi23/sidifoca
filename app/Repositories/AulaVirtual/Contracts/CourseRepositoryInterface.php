<?php

namespace App\Repositories\AulaVirtual\Contracts;

interface CourseRepositoryInterface
{
    public function listByYearAndCategory(): array;
    public function listByCourse(?int $idCurso): array;
}
