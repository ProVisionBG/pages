<?php

namespace App\Modules\Pages\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class PagesTranslation extends Model {

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug'
    ];

    public function customizeSlugEngine($engine) {
        $engine->addRule('ъ', 'a');
        $engine->addRule('щ', 'sht');
        $engine->addRule('ь', 'y');
        $engine->addRule('Ъ', 'A');
        $engine->addRule('Щ', 'SHT');
        return $engine;
    }

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
