<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetai;
use App\Models\Product;
use App\Models\ReplyReview;
use App\Models\Review;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function homePage()
    {
        $productSelling = Product::limit(3)->get();
        $categories = Category::orderByRaw("name = 'Khác' ASC")->orderBy('name', 'DESC')->limit(8)->get();
        return view('customer.home', compact('productSelling', 'categories'));
    }
    function contactPage()
    {
        return view('customer.contact');
    }
    function productPage()
    {
        $products = Product::all();
        $brands = Brand::orderByRaw("name = 'Khác' ASC")->orderBy('name', 'ASC')->get();
        $categories = Category::orderByRaw("name = 'Khác' ASC")->orderBy('name', 'ASC')->get();
        return view('customer.product', compact('products', 'brands', 'categories'));
    }
    function productDetail($slug)
    {

        $product = Product::where('slug', $slug)->first();
        if ($product) {
            $orderProductBuy = OrderDetai::where('product_id', $product->id)->count();
            $reviewcount = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->count();
            $review = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->get();
            $listReplyComment = array();
            foreach ($review as $reviews) {
                $replyComments = ReplyReview::where('review_id', '=', $reviews->id)->get();
                $listReplyComment[$reviews->id] = $replyComments;
            }
            return view('customer.productDetail', compact('product', 'review', 'reviewcount', 'listReplyComment', 'orderProductBuy'));
        } else {
            return redirect()->back();
        }
        // return view('customer.productDetail', compact('product'));
    }
    function cart()
    {
        return view('customer.cart.view');
    }
    function profile()
    {
        return view('customer.profile');
    }
    function checkout()
    {
        return view('customer.checkout');
    }
    function viewOrder()
    {
        $orders = Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->get();
        $ordersSuccess =  Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->where('status_message', 0)->get();
        $ordersWait = Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->where('status_message', 1)->get();
        $ordersTranpost = Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->where('status_message', 2)->get();
        $ordersSuccessfully  = Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->where('status_message', 3)->get();
        $ordersCancel = Order::where('customer_id', Auth::guard('cus')->user()->id)->orderBy('created_at', 'DESC')->where('status_message', 4)->get();
        return view('customer.order.view-order', compact('orders', 'ordersSuccess', 'ordersWait', 'ordersTranpost', 'ordersSuccessfully', 'ordersCancel'));
    }
    function ViewOrderDetail($id)
    {
        $order = Order::findOrFail($id);
        return view('customer.order.view-order-detail', compact('order'));
    }
    function post_review0(Request $request)
    {
        $formData = $request->input('product_reviews');
        foreach ($formData as $OrderItemId => $reviewData) {
            $data = [
                'customer_id' => Auth::guard('cus')->user()->id,
                'order_item_id' => $OrderItemId,
                'rating' => $reviewData['rating'],
                'collection' => isset($reviewData['name_collection']) ? $reviewData['name_collection'] : 'None',
                'outstanding_feature' => isset($reviewData['outstanding_feature']) ? $reviewData['outstanding_feature'] : 'None',
                'comment' => isset($reviewData['comment']) ? $reviewData['comment'] : 'Không có bình luận',
            ];

            Review::create($data);
            $orderItem = OrderDetai::where('id', $OrderItemId)->first();
            $orderItem->update(['rstatus' => true]);
            $product = Product::where('id', $orderItem->product->id)->first();
            $reviewCount = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->count();
            $reviews = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->get();
            $rating = 0;
            foreach ($reviews as $item) {
                $rating += $item->rating;
            }
            $rating = $rating / $reviewCount;
            $product->update(['rating' => $rating]);
        }

        return redirect()->back()->with('mesage','Đánh Giá Sản Phẩm Thành Công');
    }
    function post_review(Request $request, $oderItemId)
    {

        // $validated = $request->validate([
        //     'rating' => 'required|numeric|min:1|max:5',
        //     'comment' => 'nullable|string',
        //     'outstanding_feature' => 'nullable|string',
        //     'collection' => 'nullable|string',
        // ]);
        $review = [
            'customer_id' => Auth::guard('cus')->user()->id,
            'order_item_id' => $oderItemId,
            'rating' => $request->rating,
            'outstanding_feature' => $request->outstanding_feature,
            'collection' => $request->collection,
            'comment' => $request->comment,

        ];
        Review::create($review);
        $orderItem = OrderDetai::where('id', $oderItemId)->first();
        $orderItem->update(['rstatus' => true]);
        $product = Product::where('id', $orderItem->product->id)->first();
        $reviewCount = Review::whereHas('orderItem', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->count();
        $reviews = Review::whereHas('orderItem', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->get();
        $rating = 0;
        foreach ($reviews as $item) {
            $rating += $item->rating;
        }
        $rating = $rating / $reviewCount;
        $product->update(['rating' => $rating]);
        return response()->json(['success' => $reviews]);
    }
    function searchByImage()
    {
        return view('customer.search-image');
    }
    function post_searchByImage(Request $request)
    {
        $image = $request->file('image');
        $client = new Client();
        $apiKey = '3b9089486d8a022939d0d82996d8fdf57e2b4054582c83ed18d94c96b0552cf0';

        $query = [
            'engine' => 'google',
            'q' => 'Coffee',
        ];

        $response = $client->get("https://serpapi.com/3b9089486d8a022939d0d82996d8fdf57e2b4054582c83ed18d94c96b0552cf0/search.json?engine=google_lens&url=http://127.0.0.1:8000/storage/product/64e8d412d629f.png");

        $data = json_decode($response->getBody());
        dd($data);
        $organicResults = $data->organic_results;
        return response()->json($organicResults);
        // return view('search', ['results' => $organicResults]);
        // // return response()->json($image);
        // // Gửi hình ảnh lên Google Cloud Vision API
        // $client = new Client();
        // $response = $client->request('POST', 'https://vision.googleapis.com/v1/images:annotate', [
        //     'query' => [
        //         'key' => 'AIzaSyA_08qR7VohXsO9UNfwSTny_3eaYvAcRIQ', // Thay YOUR_API_KEY bằng API key của bạn
        //     ],
        //     'json' => [
        //         'requests' => [
        //             [
        //                 'image' => [
        //                     'content' => base64_encode(file_get_contents($image->path())),
        //                 ],
        //                 'features' => [
        //                     [
        //                         'type' => 'LABEL_DETECTION',
        //                         'maxResults' => 5, // Số kết quả bạn muốn trả về
        //                     ],
        //                 ],
        //             ],
        //         ],
        //     ],
        // ]);

        // // Xử lý và trả về kết quả
        // $result = json_decode($response->getBody(), true);
        // return response()->json($result);
    }
}
