<?php
namespace App\Concerns;

trait Visible
{
    public function isArchived()
    {
        return $this->status == 'archived';
    }

    public static function publicCount()
    {
        return self::where('status', 'public')->count();
    }
}
