<?php

namespace App\Admin\Controllers;

use App\Models\Blog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class BlogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Blog Post';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Blog());

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', 'Judul')->sortable();
        $grid->column('author.name', 'Penulis');
        $grid->column('is_published', 'Ditampilkan')->switch();
        $grid->column('created_at', 'Dibuat')->date('d-m-Y')->sortable();

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
        $show = new Show(Blog::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('title', 'Judul');
        $show->field('author', 'Penulis')->as(function () {
            return $this->author->name ?: '-';
        });
        $show->field('cover_image_url', 'Gambar')->image();
        $show->field('tags', 'Tag');
        $show->field('slug', 'Slug');
        $show->field('is_featured', 'Featured')->using([1 => 'Ya', 0 => 'Tidak']);
        $show->field('is_published', 'Ditampilkan')->using([1 => 'Ya', 0 => 'Tidak']);
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
        $form = new Form(new Blog());

        $form->hidden('admin_id');
        $form->text('title', 'Judul');
        $form->editor('content', 'Konten');
        $form->image('cover_image_url', 'Gambar');
        $form->tags('tags', 'Tags');
        $form->hidden('slug');
        $form->switch('is_featured', 'Featured');
        $form->switch('is_published', 'Ditampilkan');

        $form->saving(function (Form $form) {
            if ($form->admin_id === null) {
                $form->admin_id = Admin::user()->id;
            }

            if ($form->title !== null) {
                $form->slug = Str::slug($form->title, '-') . '-' . uniqid();
            }
        });

        return $form;
    }
}
