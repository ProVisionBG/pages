<?php

/*
 * ProVision Administration, http://ProVision.bg
 * Author: Venelin Iliev, http://veneliniliev.com
 */

namespace ProVision\Pages\Models;

use Kalnoy\Nestedset\NodeTrait;
use Dimsav\Translatable\Translatable;
use ProVision\Administration\AdminModel;
use ProVision\Administration\Traits\MediaTrait;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;

class Pages extends AdminModel
{
    use NodeTrait, MediaManagerTrait, ValidationTrait, Translatable, RevisionableTrait;

    /**
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    /**
     * @var string
     */
    public $module = 'pages';

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'visible',
        'position',
        'show_media',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'position' => 'array',
        'visible' => 'boolean',
        'show_media' => 'boolean',
    ];

    public function __construct()
    {
        parent::__construct();

        foreach (Administration::getLanguages() as $key => $lang) {
            $this->setValidationRules([
                $key.'.title' => 'required',
                $key.'.description' => 'required',
            ]);
        }
    }

    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('pages.visible', 1);
    }
}
