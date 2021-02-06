<?php

namespace App\Admin\Controllers;

use App\Models\Reward;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RewardController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Majalah & Ebook';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reward());

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', 'Judul')->sortable();
        $grid->column('author.name', 'Author');
        $grid->column('is_published', 'Tampilkan?')->switch();
        $grid->column('created_at', 'Dibuat')->date('h:i:s d-m-Y')->sortable();
        $grid->column('updated_at', 'Diubah')->date('h:i:s d-m-Y');

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
        $show = new Show(Reward::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('title', 'Judul');
        $show->field('description', 'Deskripsi');
        $show->field('cover_image_url', 'Gambar Cover');
        $show->field('file_url', 'File Ebook');
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
        $form = new Form(new Reward());

        $form->hidden('admin_id', __('Admin id'));
        $form->text('title', 'Judul');
        $form->image('cover_image_url', 'Gambar Cover');
        $form->textarea('description', 'Deskripsi');
        $form->file('file_url', 'File Ebook');
        $form->switch('is_published', 'Tampilkan');

        $form->saving(function (Form $form) {
            if ($form->admin_id === null && $form->user_id === null) {
                $form->admin_id = Admin::user()->id;
            }
        });

        return $form;
    }
}
