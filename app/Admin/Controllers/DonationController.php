<?php

namespace App\Admin\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DonationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Daftar Donasi';

    protected $campaigns;

    public function __construct(Campaign $campaigns)
    {
        $this->campaigns = $campaigns->pluck('title', 'id');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Donation());

        $grid->filter(function ($filter) {
            $filter->equal('campaign_id', 'Kampanye')->select($this->campaigns);
        });

        $grid->quickSearch('campaign.title');

        $grid->column('id', 'ID')->sortable();
        $grid->column('campaign.title', 'Kampanye')->sortable();
        $grid->column('nominal', 'Nominal')->display(function ($nominal) {
            return "Rp. " . number_format((int)$nominal, 2, ',', '.');
        });
        $grid->column('alias', 'Nama Alias');
        $grid->column('admin.name', 'Pengguna')->display(function ($name) {
            if ($name !== null) {
                return $name;
            } else {
                return $this->user->name;
            }
        });
        $grid->column('va', 'Nomor VA');
        $grid->column('is_verified', 'Verifikasi')->switch();
        $grid->column('created_at', 'Waktu')->date('d-m-Y')->sortable();

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
        $show = new Show(Donation::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('nominal', 'Nominal');
        $show->field('message', 'Pesan');
        $show->field('transaction_uuid', 'Kode Transaksi');
        $show->field('is_verified', 'Verifikasi');
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
        $form = new Form(new Donation());

        $form->hidden('user_id');
        $form->hidden('admin_id');
        $form->select('campaign_id', 'Kampanye')->options($this->campaigns);
        $form->currency('nominal', 'Nominal Donasi');
        $form->text('message', 'Pesan');
        $form->switch('is_verified', 'Verifikasi');

        $form->saving(function (Form $form) {
            if ($form->admin_id === null && $form->user_id === null) {
                $form->admin_id = Admin::user()->id;
            }
        });

        return $form;
    }
}
