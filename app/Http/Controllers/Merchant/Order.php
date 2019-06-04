<?php
namespace App\Http\Controllers\Merchant; use App\Http\Controllers\Shop\ApiPay; use App\Library\CurlRequest; use App\Library\FundHelper; use App\Library\Helper; use App\Library\Response; use App\Mail\OrderShipped; use App\System; use Carbon\Carbon; use Illuminate\Database\Eloquent\Relations\Relation; use Illuminate\Http\Request; use App\Http\Controllers\Controller; use Illuminate\Support\Facades\DB; use Illuminate\Support\Facades\Mail; class Order extends Controller { function get(Request $sp85ba11) { $spfed6d4 = $this->authQuery($sp85ba11, \App\Order::class); $sp7bb93d = (int) $sp85ba11->post('category_id'); $sp16cfd7 = (int) $sp85ba11->post('product_id'); $spb0a869 = (int) $sp85ba11->post('profit'); $sp593a42 = $sp7bb93d === \App\Product::ID_API || $sp16cfd7 === \App\Product::ID_API; $sp707db4 = $sp85ba11->post('search', false); $sp56c021 = $sp85ba11->post('val', false); if ($sp707db4 && $sp56c021) { if ($sp707db4 == 'id' || $sp707db4 == 'order_no' || $sp707db4 === 'pay_trade_no' || $sp707db4 === 'api_out_no') { $spfed6d4->where($sp707db4, $sp56c021); } else { $spfed6d4->where($sp707db4, 'like', '%' . $sp56c021 . '%'); } } if ($sp7bb93d > 0) { if ($sp16cfd7 > 0) { $spfed6d4->where('product_id', $sp16cfd7); } else { $spfed6d4->whereHas('product', function ($spfed6d4) use($sp7bb93d) { $spfed6d4->where('category_id', $sp7bb93d); }); } } $sp4e65aa = (int) $sp85ba11->post('recent', 0); if ($sp4e65aa) { $sp54e378 = (new Carbon())->addDay(-$sp4e65aa); $spfed6d4->where(function ($spfed6d4) use($sp54e378) { $spfed6d4->where('paid_at', '>=', $sp54e378)->orWhere(function ($spfed6d4) use($sp54e378) { $spfed6d4->whereNull('paid_at')->where('created_at', '>=', $sp54e378); }); }); } else { $sp54e378 = $sp85ba11->post('start_at', false); if (strlen($sp54e378)) { $spfed6d4->where(function ($spfed6d4) use($sp54e378) { $spfed6d4->where('paid_at', '>=', $sp54e378 . ' 00:00:00')->orWhere(function ($spfed6d4) use($sp54e378) { $spfed6d4->whereNull('paid_at')->where('created_at', '>=', $sp54e378 . ' 00:00:00'); }); }); } $sp9b1a30 = $sp85ba11->post('end_at', false); if (strlen($sp9b1a30)) { $spfed6d4->where(function ($spfed6d4) use($sp9b1a30) { $spfed6d4->where('paid_at', '<=', $sp9b1a30 . ' 23:59:59')->orWhere(function ($spfed6d4) use($sp9b1a30) { $spfed6d4->whereNull('paid_at')->where('created_at', '<=', $sp9b1a30 . ' 23:59:59'); }); }); } } if ($spb0a869) { $spfed6d4->where('status', \App\Order::STATUS_SUCCESS); $spbb9a66 = clone $spfed6d4; $sp5e7239 = $spbb9a66->selectRaw('SUM(`income`) as income, SUM(`paid`-`cost`-`fee`) as profit')->first(); } else { $sp7a1202 = $sp85ba11->post('status'); if (strlen($sp7a1202)) { $spfed6d4->whereIn('status', explode(',', $sp7a1202)); } else { $spfed6d4->where('status', '!=', \App\Order::STATUS_UNPAY); } } if ($sp593a42) { $spfed6d4->where('product_id', \App\Product::ID_API); } else { $spfed6d4->where('product_id', '>', 0); $spfed6d4->with(array('product' => function (Relation $spfed6d4) { $spfed6d4->select(array('id', 'name')); }, 'card_orders.card' => function (Relation $spfed6d4) { $spfed6d4->select(array('id', 'card')); })); } $spfed6d4->with(array('pay' => function (Relation $spfed6d4) { $spfed6d4->select(array('id', 'name')); })); $spefc91a = $sp85ba11->post('current_page', 1); $sp179110 = $sp85ba11->post('per_page', 20); $sp0ba550 = $spfed6d4->orderBy('id', 'DESC')->paginate($sp179110, array('*'), 'page', $spefc91a); if ($spb0a869) { $sp0ba550 = $sp0ba550->toArray(); $sp0ba550['profit_sum'] = $sp5e7239; } return Response::success($sp0ba550); } function stat(Request $sp85ba11) { $this->validate($sp85ba11, array('day' => 'required|integer|between:7,30')); $spea7665 = (int) $sp85ba11->input('day'); if ($spea7665 === 30) { $sp91d6ff = Carbon::now()->addMonths(-1); } else { $sp91d6ff = Carbon::now()->addDays(-$spea7665); } $sp0ba550 = $this->authQuery($sp85ba11, \App\Order::class)->where(function ($spfed6d4) { $spfed6d4->where('status', \App\Order::STATUS_PAID)->orWhere('status', \App\Order::STATUS_SUCCESS); })->where('paid_at', '>=', $sp91d6ff)->groupBy('date')->orderBy('date', 'DESC')->selectRaw('DATE(`paid_at`) as "date",COUNT(*) as "count",SUM(`paid`) as "paid",SUM(`paid`-`cost`-`fee`) as "profit"')->get()->toArray(); $sp5780b9 = array(); foreach ($sp0ba550 as $sp33ef93) { $sp5780b9[$sp33ef93['date']] = array((int) $sp33ef93['count'], (int) $sp33ef93['paid'], (int) $sp33ef93['profit']); } return Response::success($sp5780b9); } function info(Request $sp85ba11) { $this->validate($sp85ba11, array('id' => 'required|integer')); $spf46c5d = $sp85ba11->post('id'); $sp63564c = $this->authQuery($sp85ba11, \App\Order::class)->with(array('pay' => function (Relation $spfed6d4) { $spfed6d4->select(array('id', 'name')); }, 'card_orders.card' => function (Relation $spfed6d4) { $spfed6d4->select(array('id', 'card')); }))->findOrFail($spf46c5d); $sp63564c->addHidden(array('system_fee')); return Response::success($sp63564c); } function remark(Request $sp85ba11) { $this->validate($sp85ba11, array('id' => 'required|integer', 'remark' => 'required|string')); $spf46c5d = $sp85ba11->post('id'); $sp63564c = $this->authQuery($sp85ba11, \App\Order::class)->findOrFail($spf46c5d); $sp63564c->remark = $sp85ba11->post('remark'); $sp63564c->save(); return Response::success(); } function ship(Request $sp85ba11) { $this->validate($sp85ba11, array('id' => 'required|integer')); $sp63564c = $this->authQuery($sp85ba11, \App\Order::class)->findOrFail($sp85ba11->post('id')); if ($sp63564c->status !== \App\Order::STATUS_PAID) { return Response::fail('订单不是待发货状态, 无法发货'); } $sp36710a = null; $spddad3d = array(); if (FundHelper::orderSuccess($sp63564c->id, function () use(&$sp63564c, &$sp36710a, &$spddad3d) { $sp63564c = \App\Order::where('id', $sp63564c->id)->lockForUpdate()->firstOrFail(); if ($sp63564c->cards && count($sp63564c->cards)) { $sp36710a = '该订单已经发货，无需再次发货'; return false; } $spf85ebf = $sp63564c->product()->lockForUpdate()->firstOrFail(); $sp75215f = \App\Card::where('product_id', $spf85ebf->id)->whereRaw('`count_sold`<`count_all`')->take($sp63564c->count)->lockForUpdate()->get(); if (count($sp75215f) !== $sp63564c->count) { $sp36710a = '商品卡密不足, 请添加卡密后再发货'; return false; } else { $sp63564c->status = \App\Order::STATUS_SUCCESS; $sp63564c->saveOrFail(); $sp7e9dfe = array(); foreach ($sp75215f as $spb7019f) { $sp7e9dfe[] = $spb7019f->id; $spddad3d[] = $spb7019f->card; } $sp63564c->cards()->attach($sp7e9dfe); \App\Card::whereIn('id', $sp7e9dfe)->update(array('status' => \App\Card::STATUS_SOLD, 'count_sold' => DB::raw('`count_sold`+1'))); $spf85ebf->count_sold += $sp63564c->count; $spf85ebf->saveOrFail(); return FundHelper::ACTION_CONTINUE; } })) { if (filter_var($sp63564c->email, FILTER_VALIDATE_EMAIL)) { $sp9616d4 = join('<br>', $spddad3d); try { Mail::to($sp63564c->email)->Queue(new OrderShipped($sp63564c, '订单#' . $sp63564c->order_no . '&nbsp;已支付，卡号列表：', $sp9616d4)); $sp63564c->email_sent = true; $sp63564c->saveOrFail(); } catch (\Throwable $sp1b3a33) { \App\Library\LogHelper::setLogFile('mail'); \Log::error('Order.ship error, order_no:' . $sp63564c->order_no . ', email:' . $sp63564c->email . ', cards:' . $sp9616d4 . ', Exception:' . $sp1b3a33->getMessage()); \App\Library\LogHelper::setLogFile('card'); } } $sp63564c['card_orders'] = array_map(function ($sp33ef93) { return array('card' => array('card' => $sp33ef93)); }, $spddad3d); $sp63564c->addHidden(array('system_fee')); return Response::success($sp63564c); } else { return Response::fail($sp36710a ?? '数据库繁忙, 请联系客服'); } } }