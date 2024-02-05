<?php
namespace App\Concerns;

trait Visible
{
    public function isArchived()
    {
        return $this->status == 'archived';
    }
}
