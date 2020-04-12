<?php

namespace App\Admin\Controllers;

use App\Models\Invite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Arr;

class UserController extends Controller
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
            ->header('用戶列表')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('ID')->sortable();
        $grid->phone('手机号');

        $grid->created_at('注册日期');

        $grid->level_relation('上级用户id')->sortable();
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->balance('用户余额')->display(function ($amount) {
            return round($amount / 100, 2).'元';
        })->sortable();

        $grid->column('invites', '邀请奖励')->display(function ($invites) {
            $sum = Arr::pluck($invites, 'benefit');
            return round(array_sum($sum) / 100, 2).'元';
        });

        $grid->disableActions();

        $grid->tools(function ($tools) {
            // 禁用批量刪除按鈕
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('id', '用户id');
            $filter->equal('level_relation', '上级id');

        });

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

        $show->id('Id');
        $show->name('Name');
        $show->email('Email');
        $show->email_verified_at('Email verified at');
        $show->password('Password');
        $show->remember_token('Remember token');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
}
