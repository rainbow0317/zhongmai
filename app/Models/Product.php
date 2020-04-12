<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use SmartJson\Pdd\Api\Request\PddDdkGoodsSearchRequest;
use SmartJson\Pdd\PopHttpClient;

class Product extends Model
{
    protected $request;
    protected $client;
    public function  __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->client = new PopHttpClient();
        $this->request = new PddDdkGoodsSearchRequest();
    }

    public function paginate()
    {
        $total = 1000000;//商品总数(分页用,不知道三方有多少商品,所以不显示最后几页,所以总数写的大一些)
        $perPage = Request::get('per_page', 30);

        $page = Request::get('page', 1);
        $filter = request()->get('search', '');
        $sortType = request()->get('orderby', '0');

        $this->request->setKeyword($filter);
        $this->request->setSortType($sortType);

        $this->request->setPage($page);
        $this->request->setPageSize($perPage);
        $this->request->setWithCoupon(false);

        $contents = Arr::get($this->client->getRes($this->request), 'goods_search_response', []);
        $data = Arr::get($contents, 'goods_list', []);


        $res = static::hydrate($data);

        $paginator = new LengthAwarePaginator($res, $total, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

}
