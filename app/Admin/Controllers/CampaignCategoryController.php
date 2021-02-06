<?php

namespace App\Admin\Controllers;

use App\Models\CampaignCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CampaignCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kategori Program';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CampaignCategory());
    
        $grid->column('id', 'ID');
        $grid->column('icon', 'Ikon')->image('', 72, 72);
        $grid->column('category', 'Kategori');
        $grid->column('created_at', 'Dibuat')->date('d-m-Y');
        $grid->column('updated_at', 'Diubah')->date('d-m-Y');

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
        $show = new Show(CampaignCategory::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('icon', 'Ikon')->image();
        $show->field('category', 'Kategori');
        $show->field('created_at', 'Dibuat');
        $show->field('updated_at', 'Diubah');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CampaignCategory());

        $form->text('category', 'Kategpri');
        $form->image('icon', 'Ikon');

        return $form;
    }
}
