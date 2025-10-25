<?php

namespace App\Repositories\AulaVirtual\Contracts;

interface CourseRepositoryInterface
{
    public function listByYearAndCategory(): array;
    public function listByCourse(?int $idCurso): array;
    function listByCourseServer(int $idCurso, int $limit = 20, int $offset = 0, ?string $search = '', ?array $tipos = [], ?string $fecha = '', ?array $estados = []): array;
    public function listByCourseAll(
        int $idCurso,
        ?string $search = '',
        ?array $tipos = null,
        ?string $fecha = null,
        ?array $estados = null
    ): array;
}
