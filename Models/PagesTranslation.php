<?php

namespace App\Modules\Pages\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use ProVision\Administration\AdminModelTranslations;

class PagesTranslation extends AdminModelTranslations {

    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug'
    ];


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
