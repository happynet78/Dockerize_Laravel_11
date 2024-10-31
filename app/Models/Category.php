<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['name', 'slug', 'parent', 'ordering'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent_category() {
        // return $this->hasone(ParentCategory::class, 'id', 'parent');
        return $this->belongsTo(ParentCategory::class, 'parent', 'id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'category', 'id');
    }
}
