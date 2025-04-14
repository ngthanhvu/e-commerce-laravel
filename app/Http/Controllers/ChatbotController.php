<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatbotController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $response = $this->generateResponse($userMessage);

        return response()->json([
            'status' => 'success',
            'message' => $response,
        ]);
    }

    protected function generateResponse($userMessage)
    {
        // Lấy dữ liệu sản phẩm và danh mục
        $products = Product::with(['category', 'mainImage', 'variants'])->take(50)->get();
        $categories = Category::all();

        // Chuẩn bị ngữ cảnh sản phẩm
        $productContext = "Danh sách sản phẩm có sẵn:\n";
        foreach ($products as $product) {
            $categoryName = $product->category ? $product->category->name : 'Không có danh mục';
            $imageUrl = $product->mainImage ? Storage::url($product->mainImage->sub_image) : 'Không có hình ảnh';
            $variants = $product->variants->isNotEmpty() ? implode(', ', $product->variants->pluck('varriant_name')->toArray()) : 'Không có biến thể';
            $productContext .= "- {$product->name} (Danh mục: {$categoryName}, Giá: {$product->price} VND, Giá gốc: {$product->original_price} VND, Giá khuyến mãi: " . ($product->discount_price ?? 'Không có') . " VND, Tồn kho: {$product->quantity}, Mô tả: {$product->description}, Biến thể: {$variants}, Hình ảnh: {$imageUrl}, Liên kết: " . route('products.show', $product->slug) . ")\n";
        }

        // Chuẩn bị ngữ cảnh danh mục
        $categoryContext = "Danh sách danh mục có sẵn:\n";
        foreach ($categories as $category) {
            $categoryContext .= "- {$category->name} (Mô tả: {$category->description})\n";
        }

        // Giả định chính sách cửa hàng
        $storePolicy = <<<EOD
Chính sách cửa hàng:
- Vận chuyển: Miễn phí vận chuyển cho đơn hàng từ 1.000.000 VND, thời gian giao hàng 2-5 ngày.
- Bảo hành: Bảo hành 12 tháng cho điện tử, 6 tháng cho phụ kiện.
- Đổi trả: Hỗ trợ đổi trả trong 7 ngày nếu sản phẩm lỗi do nhà sản xuất.
EOD;

        // Tạo lời nhắc
        $prompt = <<<EOD
Bạn là trợ lý AI thông minh cho một trang web thương mại điện tử. Nhiệm vụ của bạn là tư vấn và gợi ý sản phẩm dựa trên yêu cầu của người dùng, trả lời tự nhiên và chuyên nghiệp bằng tiếng Việt. Sử dụng thông tin sau để trả lời:

{$productContext}
{$categoryContext}
{$storePolicy}

Tin nhắn người dùng: "{$userMessage}"

Hướng dẫn:
- Nếu người dùng yêu cầu gợi ý sản phẩm (ví dụ: "Tôi muốn điện thoại dưới 10 triệu" hoặc "gợi ý laptop"), đề xuất tối đa 3 sản phẩm phù hợp dựa trên danh mục, giá, mô tả, biến thể hoặc từ khóa trong tin nhắn.
- Với mỗi sản phẩm gợi ý, bao gồm:
  - Tên sản phẩm (liên kết markdown: [Tên sản phẩm](Liên kết)).
  - Giá hiện tại và giá khuyến mãi (nếu có).
  - Mô tả ngắn gọn.
  - Biến thể (nếu có).
  - Hình ảnh (dùng markdown: ![Tên sản phẩm](URL hình ảnh)).
- Nếu người dùng hỏi về danh mục, liệt kê danh mục phù hợp kèm mô tả.
- Nếu người dùng hỏi về chính sách cửa hàng (vận chuyển, bảo hành, đổi trả), trả lời dựa trên chính sách cửa hàng.
- Hỗ trợ tư vấn nâng cao:
  - So sánh sản phẩm nếu người dùng yêu cầu (ví dụ: "So sánh điện thoại Samsung và Xiaomi").
  - Gợi ý sản phẩm theo ngân sách, sở thích hoặc tính năng cụ thể (ví dụ: "Điện thoại pin tốt").
  - Đưa ra lời khuyên nếu người dùng không chắc chắn (ví dụ: "Bạn thích thương hiệu nào?").
- Nếu tin nhắn không rõ, hỏi lại để làm rõ yêu cầu.
- Giữ câu trả lời ngắn gọn, thân thiện, chuyên nghiệp, và đúng ngữ pháp tiếng Việt.
- Không tự tạo sản phẩm, liên kết hoặc hình ảnh không có trong danh sách.
EOD;

        return $this->geminiService->generateResponse($prompt);
    }
}
