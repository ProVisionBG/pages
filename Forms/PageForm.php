<?php

/*
 * ProVision Administration, http://ProVision.bg
 * Author: Venelin Iliev, http://veneliniliev.com
 */

namespace ProVision\Pages\Forms;

use ProVision\Pages\Models\Pages;
use ProVision\Administration\Forms\AdminForm;

class PageForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label' => trans('pages::admin.title'),
            'validation_rules' => [
                'required' => true,
                'minlength' => 2,
            ],
            'translate' => true,

        ]);

        $this->add('description', 'editor', [
            'label' => trans('pages::admin.description'),
            'validation_rules' => [
                'required' => true,
            ],
            'translate' => true,
        ]);

        $this->addSeoFields();

        $this->add('visible', 'checkbox', [
            'label' => trans('pages::admin.active'),
            'value' => 1,
            'checked' => @$this->model->visible,
        ]);

        $this->add('show_media', 'checkbox', [
            'label' => trans('pages::admin.media'),
            'value' => 1,
            'checked' => @$this->model->show_media,
        ]);

        $this->add('position', 'choice', [
            'label' => trans('pages::admin.position'),
            'choices' => [
                'header' => trans('pages::admin.header-top'),
                'footer' => trans('pages::admin.footer-bottom'),
                'other' => trans('pages::admin.other'),
            ],
            'selected' => @$this->model->position,
            'expanded' => true,
            'multiple' => true,
        ]);

        //Родител страници
        $nodes = Pages::withTranslation()->get()->toTree();
        $traverse = function ($cat, $prefix = '-', &$return = []) use (&$traverse) {
            foreach ($cat as $category) {
                if ($category->id != @$this->model->id) {
                    $return[$category->id] = $prefix.' '.$category->title;
                    $traverse($category->children, $prefix.'--', $return);
                }
            }

            return $return;
        };
        $pages = $traverse($nodes);
        $this->add('parent_id', 'select', [
            'label' => trans('pages::admin.parent'),
            'choices' => $pages,
            'selected' => @$this->model->parent_id,
            'empty_value' => trans('pages::admin.select'),
        ]);

        $this->add('footer', 'admin_footer');
        $this->add('send', 'submit', [
            'label' => trans('administration::index.save'),
            'attr' => [
                'name' => 'save',
            ],
        ]);
    }
}
