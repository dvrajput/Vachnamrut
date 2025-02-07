<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\CategoryLog;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        CategoryLog::create([
            'category_code' => $category->category_code,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'changes'    => json_encode($category->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $changes = $category->getChanges();
        CategoryLog::create([
            'category_code' => $category->category_code,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'changes'    => json_encode($changes),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        CategoryLog::create([
            'category_code'  => $category->category_code,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'changes'    => json_encode($category->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        CategoryLog::create([
            'category_code'  => $category->category_code,
            'user_id'    => Auth::id(),
            'action'     => 'restored',
            'changes'    => json_encode($category->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        CategoryLog::create([
            'category_code'  => $category->category_code,
            'user_id'    => Auth::id(),
            'action'     => 'force_deleted',
            'changes'    => json_encode($category->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }
}
