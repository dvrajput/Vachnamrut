<?php

namespace App\Observers;

use App\Models\SubCategory;
use App\Models\SubCategoryLog;
use Illuminate\Support\Facades\Auth;

class SubCategoryObserver
{
    /**
     * Handle the SubCategory "created" event.
     */
    public function created(SubCategory $subCategory): void
    {
        SubCategoryLog::create([
            'sub_category_code' => $subCategory->sub_category_code,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'changes'    => json_encode($subCategory->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the SubCategory "updated" event.
     */
    public function updated(SubCategory $subCategory): void
    {
        $changes = $subCategory->getChanges();
        SubCategoryLog::create([
            'sub_category_code' => $subCategory->sub_category_code,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'changes'    => json_encode($changes),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the SubCategory "deleted" event.
     */
    public function deleted(SubCategory $subCategory): void
    {
        SubCategoryLog::create([
            'sub_category_code'  => $subCategory->sub_category_code,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'changes'    => json_encode($subCategory->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the SubCategory "restored" event.
     */
    public function restored(SubCategory $subCategory): void
    {
        SubCategoryLog::create([
            'sub_category_code'  => $subCategory->sub_category_code,
            'user_id'    => Auth::id(),
            'action'     => 'restored',
            'changes'    => json_encode($subCategory->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the SubCategory "force deleted" event.
     */
    public function forceDeleted(SubCategory $subCategory): void
    {
        SubCategoryLog::create([
            'sub_category_code'  => $subCategory->sub_category_code,
            'user_id'    => Auth::id(),
            'action'     => 'force_deleted',
            'changes'    => json_encode($subCategory->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }
}
