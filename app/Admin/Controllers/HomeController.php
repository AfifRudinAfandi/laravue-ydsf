<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\DashboardController;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{

    public function index(Content $content)
    {
        $content->title('Dashboard');

        $content
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(DashboardController::counter());
                });
            });

        return $content;
    }
}
