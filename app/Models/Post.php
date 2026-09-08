<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Concerns\Auditable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    use Auditable;
     // protected $fillable = ['title', 'excerpt', 'body'];

     protected $guarded = ['id'];
     protected $with = ['author','category'];


     public function scopeFilter ($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('title','like','%' . $search . '%')
                         ->orWhere('body','like','%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
            return $query->Wherehas('category', function($query) use ($category){
                $query->where('slug', $category);
            });
        });

        $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->Wherehas('author', fn($query) =>
                $query->where('username', $author)
            )
        );


    }


     public function category()
     {
         return $this ->belongsTo(Category::class);
     }

     public function author()
     {
         return $this ->belongsTo(User::class, 'user_id');
     }

     public function comments()
     {
         return $this->hasMany(Comment::class);
     }

     public function approvedComments()
     {
         return $this->hasMany(Comment::class)->where('approved', true)->latest();
     }

     public function reactions()
     {
         return $this->hasMany(Reaction::class);
     }

     public function reactionCounts()
     {
         return $this->reactions()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');
     }

     public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
