<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User/Donatur';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', 'ID');
        $grid->column('name', 'Nama');
        $grid->column('email', 'Email');
        $grid->column('phone', 'No. Telepon');
        $grid->column('Provider')->display(function () {
            return OAuthProvider::where('user_id', $this->id)->pluck('provider');
        });
        $grid->column('avatar', 'Avatar')->image('', 72, 72);
        $grid->column('is_block', 'Blok User')->switch();
        $grid->column('created_at', 'Waktu')->date('d-m-Y');

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', 'Nama');
        $show->field('email', 'Email');
        $show->field('email_verified_at', 'Waktu Verifikasi Email');
        $show->field('avatar', 'Avatar')->image();
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
        $form = new Form(new User());

        $form->text('name', 'Nama');
        $form->email('email', 'Email');
        $form->datetime('email_verified_at', 'Verifikasi Email')->default(date('Y-m-d H:i:s'));
        $form->image('avatar', 'Avatar');
        $form->switch('is_block', 'Nonaktifkan User');

        return $form;
    }
}
