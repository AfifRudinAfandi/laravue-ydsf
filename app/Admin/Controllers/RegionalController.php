<?php

namespace App\Admin\Controllers;

use App\Models\Regional;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RegionalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Regional/Mitra';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Regional());

        $grid->column('id', 'ID');
        $grid->column('logo', 'Logo')->image('', '50', '50');
        $grid->column('name', 'Nama');
        $grid->column('address', 'Alamat');
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
        $show = new Show(Regional::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', 'Nama');
        $show->field('address', 'Alamat');
        $show->field('image', 'Gambar')->image();
        $show->field('logo', 'Logo')->image();
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
        $form = new Form(new Regional());

        $form->image('logo', 'Logo');
        $form->text('name', 'Regional');
        $form->text('address', 'Alamat');
        $form->image('image', 'Gambar');

        return $form;
    }
}
