<?php

namespace App\Admin\Controllers;

use App\Models\PaymentLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaymentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Histori Pembayaran';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PaymentLog());

        $grid->column('id', 'ID')->sortable();
        $grid->column('user.name', 'Pengguna')->sortable();
        $grid->column('campaign.title', 'Progran Donasi');
        $grid->column('trx_amount', 'Nominal')->display(function ($amount) {
            return "Rp. " . number_format((int)$amount, 2, ',', '.');
        });
        $grid->column('trx_id', 'Transfer ID');
        $grid->column('virtual_account', 'No. VA');
        $grid->column('payment_at', 'Waktu Pembayaran')->display(function ($payment) {
            if ($payment == '') {
                return 'Belum Bayar';
            }
            return $payment;
        });
        $grid->column('created_at', 'Dibuat')->date('h:i:s d-m-Y')->sortable();

        $grid->disableActions();
        $grid->disableCreateButton();

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
        $show = new Show(PaymentLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('campaign_id', __('Campaign id'));
        $show->field('c_name', __('C name'));
        $show->field('trx_amount', __('Trx amount'));
        $show->field('trx_id', __('Trx id'));
        $show->field('virtual_account', __('Virtual account'));
        $show->field('payment_amount', __('Payment amount'));
        $show->field('billing_type', __('Billing type'));
        $show->field('payment_at', __('Payment at'));
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
        $form = new Form(new PaymentLog());

        $form->number('user_id', __('User id'));
        $form->number('campaign_id', __('Campaign id'));
        $form->text('c_name', __('C name'));
        $form->text('trx_amount', __('Trx amount'));
        $form->text('trx_id', __('Trx id'));
        $form->text('virtual_account', __('Virtual account'));
        $form->text('payment_amount', __('Payment amount'));
        $form->text('billing_type', __('Billing type'));
        $form->text('payment_at', __('Payment at'));

        return $form;
    }
}
