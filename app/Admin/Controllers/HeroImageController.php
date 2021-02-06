<?php

namespace App\Admin\Controllers;

use App\Models\HeroImage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HeroImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gambar Hero';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HeroImage());

        $grid->column('id', __('Id'));
        $grid->column('image', __('Image'))->image('', 200);
        $grid->column('title', __('Title'));
        $grid->column('subtitle', __('Subtitle'));
        $grid->column('created_at', __('Created at'))->date('h:i:s d-m-Y');
        $grid->column('updated_at', __('Updated at'))->date('h:i:s d-m-Y');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(HeroImage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('image', __('Image'));
        $show->field('title', __('Title'));
        $show->field('subtitle', __('Subtitle'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HeroImage());

        $form->image('image', __('Image'))->help('Upload Image Dengan Rasio (2:1) atau (1000x500)');
        $form->text('title', __('Title'));
        $form->text('subtitle', __('Subtitle'));

        return $form;
    }
}
