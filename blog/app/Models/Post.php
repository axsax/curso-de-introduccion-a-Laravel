<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
class Post extends Model
{
    use Sluggable;
    use HasFactory;
    protected $fillable =[
        'title',
        'body',
        'iframe',
        'image',
        'user_id',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' =>true //cuando exista un salvado se convierte en un slug
            ]
        ];
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getGetExcerptAttribute(){
        return substr($this->body,1,140);
    }
    public function getGetImageAttribute(){
        if($this->image){
            return url("storage/$this->image"); //este lo busca en public no en storage, por lo que que hay que crear un enlaze simbolico (acceso directo) para que storage este en public, lo hacemos con el comando php artisan storage:link
        }
    }
}
