<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id', 'content', 'published_at', 'status', 'event_paths','event_type'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function photos()
    {
        return $this->hasMany(EventPhoto::class);
    }

    // public function getEventPathsAttribute()
    // {
    //     // Eğer event_paths bir dizi ise direkt döndür, değilse JSON çözümlüyoruz
    //     if (is_array($this->attributes['event_paths'])) {
    //         return $this->attributes['event_paths'];
    //     }

    //     // JSON verisini çözümlüyor, eğer null ise boş dizi döndürüyor
    //     return json_decode($this->attributes['event_paths'], true) ?? [];
    // }

    public function setEventPathsAttribute($value)
    {
        // Eğer bir dizi ise JSON formatına çeviriyoruz
        $this->attributes['event_paths'] = is_array($value) ? json_encode($value) : $value;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }



}
