<?php

namespace App\Repositories\AulaVirtual\Contracts;

interface CourseRepositoryInterface
{
    public function listByYearAndCategory(): array;
    public function listByCourse(?int $idCurso): array;
    function listByCourseServer(int $idCurso, int $limit = 20, int $offset = 0, ?string $search = '', ?string $tipo = '', ?string $fecha = ''): array;
}
