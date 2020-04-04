<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SmartJson\Pdd\Api\Request\PddDdkGoodsPromotionUrlGenerateRequest;
use SmartJson\Pdd\Api\Request\PddDdkGoodsSearchRequest;
use SmartJson\Pdd\PopHttpClient;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $perPage = 64;
            if ($request->has('page')) {
                $current_page = $request->input('page');
                $current_page = $current_page <= 0 ? 1 : $current_page;
            } else {
                $current_page = 1;
            }
            $total = 10000000;//商品总数(分页用,不知道三方有多少商品,所以不显示最后几页,所以总数写的大一些)

            //是否团长
            $leaderFlag = Auth::user()->level_relation == 0;
            //直接抽佣比例
            $rate = config('pdd.promotion_rate');
            //上级抽佣比例
            $leveRate = config('pdd.level_promotion_rate');


            $filter = $request->input('search', '');
            $sortType = $request->input('orderby', '0');

            //多多客获取爆款排行商品接口pdd.ddk.goods.search
            $client = new  PopHttpClient();
            $request = new PddDdkGoodsSearchRequest();

            $request->setPage($current_page);
            $request->setPageSize($perPage);
            $request->setKeyword($filter);
            $request->setSortType($sortType);
            $request->setWithCoupon(false);

            $contents = Arr::get($client->getRes($request), 'goods_search_response', []);
            $list = Arr::get($contents, 'goods_list', []);

            $res = [];
            foreach ($list as $key => $val) {
                $res[$key]['goods_id'] = $val['goods_id'];
                $res[$key]['has_coupon'] = $val['has_coupon'];
                $res[$key]['coupon_remain_quantity'] = $val['coupon_remain_quantity'];
                $res[$key]['goods_name'] = $val['goods_name'];
                $res[$key]['mall_name'] = mb_substr($val['mall_name'], 0, 7);
                $res[$key]['sales_tip'] = $val['sales_tip'];
                $res[$key]['search_id'] = $val['search_id'];
                $res[$key]['goods_image_url'] = $val['goods_image_url'];

                $minPrice = $val['min_group_price'] - $val['coupon_discount'];
                $pddPromotion = round($minPrice * $val['promotion_rate'] / 1000, 2);
                $immPro = $pddPromotion * $rate;
                $promotion = $leaderFlag ? $immPro : $immPro * (1 - $leveRate);
                $res[$key]['promotion'] = round($promotion / 100, 2);

                $res[$key]['min_group_price'] = round($val['min_group_price'] / 100, 2);
                $res[$key]['min_normal_price'] = round($val['min_normal_price'] / 100, 2);
                $res[$key]['coupon_discount'] = intval($val['coupon_discount'] / 100);
                $res[$key]['min_price'] = round($minPrice / 100, 2);
            }

            $res = new LengthAwarePaginator($res, $total, $perPage, $current_page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);

            return view('products.links', [
                'products' => $res,
                'lastItem' => $contents['list_id'],
                'pddLink' => env('PDD_GOODS_LINK'),
                'filters' => [
                    'search' => $filter,
                    'orderby' => $sortType,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::error(' exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
            return view('pages.error', ['msg' => $exception->getMessage()]);
        }

    }

    /**
     * Get user's favor PromotionUrl.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return array
     */

    public function share(Request $request)
    {
        try {
            $goodsId = $request->input('product');
            $searchId = $request->input('search_id');

            $user = Auth::user();
            $customParameters = $user->level_relation . '**' . $user->id;


            $request = new PddDdkGoodsPromotionUrlGenerateRequest();
            $request->setGenerateShortUrl(true);  //短链
            $request->setMultiGroup(false); //多人团
            $request->setPId(config('pdd.pdd_pid'));

            $request->setGoodsIdList([$goodsId]);
            $request->setGenerateWeApp(true); //小程序
            $request->setSearchId($searchId);
            $request->setCustomParameters($customParameters);

            $client = new PopHttpClient();

            $data = $client->getRes($request)['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];

            $order = [
                'link_url' => $data['url'],
                'user_id' => $user->id,
                'goods_id' => $goodsId,
            ];


            //添加至分享信息表
            Share::create($order);
            $order['short_url'] = $data['we_app_web_view_short_url'];

            return $order;
        } catch (\Exception $exception) {
            Log::error(' exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
            return ['msg' => $exception->getMessage()];

        }
    }

    public function callback(Request $request)
    {
        return json_encode([200, 'success']);
    }
}
