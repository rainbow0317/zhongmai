<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Withdraw\Check;
use App\Models\Withdraw;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WithdrawController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('提现管理')
            ->description('提现管理')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Withdraw);

        $grid->id('Id')->sortable();
        $grid->created_at('时间');
        $grid->user_id('用户id')->sortable();
        $grid->column('user.phone', '手机号');
        $grid->amount('金额')->display(function ($amount) {
            return round($amount / 100, 2).'元';
        })->sortable();
        $grid->status('状态')->using([0 => '未处理', 1 => '已处理', 2 => '审核失败']);

        $grid->disableCreateButton();
        $grid->column('content');
//        $grid->disableActions();
        $grid->disableExport();
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('user_id', '用户id');

        });

        $grid->actions(function ($actions) {
            $actions->disableView();   // 不在每一行後面展示查看按鈕
            $actions->disableDelete(); // 不在每一行後面展示刪除按鈕
            $actions->disableEdit();   // 不在每一行後面展示編輯按鈕
            $actions->add(new Check());
        });

        return $grid;
    }
}
