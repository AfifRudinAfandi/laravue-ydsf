<?php

namespace App\Admin\Controllers;

use App\Models\Campaign;
use App\Models\CampaignProgress;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CampaignProgressController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Informasi Program';

    protected $campaignOptions;

    public function __construct(Campaign $campaign)
    {
        $this->campaignOptions = $campaign->pluck('title', 'id');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CampaignProgress());

        $grid->column('id', 'ID');
        $grid->column('title', 'Judul');
        $grid->column('campaign.title', 'Program');
        $grid->column('created_at', 'Dibuat')->date('h:i:s d-m-Y');

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
        $show = new Show(CampaignProgress::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('author', 'Penulis')->as(function () {
            return $this->author->name ?: '-';
        });
        $show->field('campaign', 'Program')->as(function () {
            return $this->campaign->title ?: '-';
        });
        $show->field('title', 'Judul');
        $show->field('video_url', 'Video url');
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
        $form = new Form(new CampaignProgress());

        $form->hidden('admin_id');
        $form->select('campaign_id', 'Program')->options($this->campaignOptions);
        $form->text('title', 'Judul');
        $form->editor('content', 'Konten');
        $form->url('video_url', 'Video url');

        $form->saving(function (Form $form) {
            if ($form->admin_id === null) {
                $form->admin_id = Admin::user()->id;
            }
        });

        return $form;
    }
}
