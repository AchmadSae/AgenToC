<?php

namespace App\Repositories;

interface KanbanInterface
{
    public function getKanban(String $idTask);
    public function kanbanByDeadline();
}
