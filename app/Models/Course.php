<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{

    use HasFactory;

    protected $casts = [
        'tags' => 'array',
        'outcomes' => 'array',
        'includes' => 'array',
    ];

    /**
     * Get the user that owns the blog.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the blog.
     */
    public function ccategory(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }
}
