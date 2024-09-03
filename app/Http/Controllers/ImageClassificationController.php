<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Phpml\Classification\KNearestNeighbors;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;
use Phpml\Dataset\CsvDataset;

class ImageClassificationController extends Controller
{
    public function trainModel()
    {
        $products = Product::all();
        $data = [];
        $labels = [];
        foreach ($products as $product) {

            $imagePath = public_path($product->image);
            $imagePath = str_replace(['\\', '/'], '\\', $imagePath);
            $imageData = $this->normalizeImage($imagePath);

            // Thêm dữ liệu hình ảnh và nhãn vào mảng
            $data[] = $imageData;
            $labels[] = $product->category_id; // Sử dụng category_id làm nhãn ví dụ
        }
        $classifier = new KNearestNeighbors();

        $classifier->train($data, $labels);
        // // dd($classifier);
        // // $classifier->predict([]);

        dd($classifier);
        // $modelPath = storage_path('app\\trained_model.csv');

        // file_put_contents($modelPath, serialize($classifier));
    }
    public function classifyImage(Request $request)
    {
        // // Load the trained model
        // $modelPath = storage_path('app\\trained_model.csv');
        // $dataset = new CsvDataset($modelPath, 2, true);

        // $classifier = unserialize(file_get_contents($modelPath));

        // // Preprocess the uploaded image
        // $uploadedImage = $request->file('image');
        // return response()->json(['predicted_label' => $dataset]);
        // $normalizedImage = $this->normalizeImage($uploadedImage);

        // // Perform classification
        // $predictedLabel = $classifier->predict($normalizedImage);

        // // Perform classification
        // // $predictedLabel = $classifier->predict($image);

        // return response()->json(['predicted_label' => $predictedLabel]);

        // Lấy hình ảnh từ yêu cầu
        $image = $request->file('image');
        return response()->json($image);
        // Gửi hình ảnh lên Google Cloud Vision API
        $client = new Client();
        $response = $client->request('POST', 'https://vision.googleapis.com/v1/images:annotate', [
            'query' => [
                'key' => 'AIzaSyA_08qR7VohXsO9UNfwSTny_3eaYvAcRIQ', // Thay YOUR_API_KEY bằng API key của bạn
            ],
            'json' => [
                'requests' => [
                    [
                        'image' => [
                            'content' => base64_encode(file_get_contents($image->path())),
                        ],
                        'features' => [
                            [
                                'type' => 'LABEL_DETECTION',
                                'maxResults' => 5, // Số kết quả bạn muốn trả về
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        // Xử lý và trả về kết quả
        $result = json_decode($response->getBody(), true);
        return response()->json($result);
    }
    public function normalizeImages()
    {
        $products = Product::all();
        $normalizedData = [];

        foreach ($products as $product) {
            // Trích xuất hình ảnh từ sản phẩm và chuẩn hóa nó
            $imagePath = public_path($product->image);
            $imagePath = str_replace(['\\', '/'], '\\', $imagePath);
            $image = $this->normalizeImage($imagePath);

            // Thêm hình ảnh đã chuẩn hóa và nhãn vào mảng dữ liệu
            $normalizedData[] = [
                'data' => $image,
                'label' => $product->category,
            ];
        }

        // Trả về dữ liệu đã chuẩn hóa dưới dạng JSON
        return response()->json($normalizedData);
    }

    private function normalizeImage($imagePath)
    {

        $img = Image::make($imagePath);

        $img->resize(224, 224); // Thay đổi kích thước hình ảnh

        $normalizedData = $img->encode('data-url')->encoded;

        return $normalizedData;
    }
}
