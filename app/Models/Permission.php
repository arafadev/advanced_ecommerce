<?php

namespace App\Models;
use Mindscms\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'parent');
    }

    public function children()  
    {
        return $this->hasMany(Permission::class, 'parent', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(Permission::class, 'parent', 'id')->where('appear', 1);
    }

    public static function tree($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereParent(0)
            ->whereAppear(1)
            ->whereSidebarLink(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }
    public static function assigned_children($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'assigned_children')))
            ->whereParentOriginal(0)
            ->whereAppear(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }
}