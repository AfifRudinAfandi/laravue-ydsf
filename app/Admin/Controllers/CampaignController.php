<?php

namespace App\Admin\Controllers;

use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\Donation;
use App\Models\Regional;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class CampaignController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kampanye Donasi';

    protected $categoryOptions;
    protected $regional;

    public function __construct(CampaignCategory $category, Regional $regional)
    {
        $this->categoryOptions = $category->pluck('category', 'id');
        $this->regional = $regional->pluck('name', 'id');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Campaign());

        $grid->filter(function ($filter) {
            $filter->equal('campaign_category_id', 'Kategori')->select($this->categoryOptions);
            $filter->equal('regional_id', 'Regional')->select($this->regional);
        });

        $grid->quickSearch('title');

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', 'Judul')->sortable();
        $grid->column('regional.name', 'Regional');
        $grid->column('category.category', 'Kategori');
        $grid->column('progress')->display(function () {
            if ($this->max_nominal == 0) {
                return 100;
            }

            $nominal = Donation::where([
                ['campaign_id', $this->id],
                ['is_verified', 1],
            ])->sum('nominal');
            return ceil($nominal / $this->max_nominal * 100);
        })->progress();
        $grid->column('is_complete', 'Set Complete')->switch();
        $grid->column('is_published', 'Dipublish')->switch();
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
        $show = new Show(Campaign::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('Admin')->as(function () {
            return $this->admin->name ?: '-';
        });
        $show->field('Regional')->as(function () {
            return $this->regional->name ?: '-';
        });
        $show->field('Kategori')->as(function () {
            return $this->category->category ?: '';
        });
        $show->field('title', 'Judul');
        $show->field('location', 'Lokasi');
        $show->field('max_nominal', 'Nominal Maksimal');
        $show->field('max_time', 'Waktu Maksimal');
        $show->field('cover_image_url', 'Gambar')->image();
        $show->field('video_url', 'Video URL');
        $show->field('tags', 'Tags');
        $show->field('slug', 'Slug');
        $show->field('is_featured', 'Featured')->using([
            1 => 'Ya',
            0 => 'Tidak'
        ]);
        $show->field('is_published', 'Ditampilkan')->using([
            1 => 'Ya',
            0 => 'Tidak'
        ]);
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
        $form = new Form(new Campaign());

        $form->text('title', 'Judul*');
        $form->select('regional_id', 'Regional*')->options($this->regional);
        $form->select('campaign_category_id', 'Kategori*')->options($this->categoryOptions);
        $form->divider();
        $form->editor('content', 'Konten*');
        $form->image('cover_image_url', 'Gambar')->help('Upload Image Dengan Rasio (3:2) atau (640x420)');
        $form->tags('tags', 'Tag*');
        $form->divider();
        $form->text('location', 'Lokasi*');
        $form->currency('max_nominal', 'Nominal')->default(null)->help('Kosongkan jika ingin menjadikan donasi sedekah.');
        $form->datetime('max_time', 'Waktu')->help('Kosongkan jika ingin menjadikan donasi sedekah.');
        $form->switch('is_published', 'Tampilkan');

        $form->hidden('slug', 'Slug');
        $form->hidden('admin_id', 'Admin');

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
