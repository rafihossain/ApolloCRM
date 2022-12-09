<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Models\Partner;
use App\Models\ProductType;
use App\Models\PartnerBranch;
use App\Models\ProductDocumentation;
use App\Models\ProductPrice;
use App\Models\ProductFeesItem;
use App\Models\Feetype;
use App\Models\Country;
use App\Models\Promotion;
use App\Models\WorkflowCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Image;


class ProductController extends Controller
{
    protected function saveProductInfoValidate($request)
    {
        $request->validate([
            'name' => 'required',
            'partner' => 'required',
            'branche' => 'required',
            'product_type' => 'required',
            'revenue_type' => 'required',
        ]);
    }
    public function manageProduct()
    {
        $products = Product::with('PartnerBranch', 'partner', 'productType')->get()->toArray();
        // dd($products);
        return view('backend.product.product-list', [
            'products' => $products,
        ]);
    }
    public function addProduct()
    {
        $patner = Partner::get();
        $product_type = ProductType::get();
        return view('backend.product.addproduct', [
            'patners' => $patner,
            'producttypes' => $product_type
        ]);
    }
    public function submitProduct(Request $request)
    {

        $this->saveProductInfoValidate($request);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->partner_id = $request->partner;
        $product->branch_id = $request->branche;
        $product->product_type = $request->product_type;
        $product->enrolled = $request->revenue_type;
        $product->duration = $request->duration;
        $product->intake_month = $request->intake_month;
        $product->note = $request->note;
        $product->save();
        return redirect('admin/product/list')->with('success', 'Product has been added successfully !!');
    }
    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        return redirect('admin/product/list')->with('danger', 'Product has been delete successfully !!');
    }
    public function editProduct($id)
    {
        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();
        $patner = Partner::get();
        $product_type = ProductType::get();
        return view('backend.product.editproduct', [
            'product' => $product,
            'patners' => $patner,
            'producttypes' => $product_type
        ]);
    }
    public function updateProduct($id, Request $request)
    {
        $product = Product::where('id', $id)->first();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->partner_id = $request->partner;
        $product->branch_id = $request->branche;
        $product->product_type = $request->product_type;
        $product->enrolled = $request->revenue_type;
        $product->duration = $request->duration;
        $product->intake_month = $request->intake_month;
        $product->note = $request->note;
        $product->save();
        return redirect('admin/editproduct/' . $id)->with('success', 'Product has been update successfully !!');
    }
    protected function productWorkflow($partner)
    {
        $workflowId = explode(',', $partner->workflow_id);
        $relatedWorkflow = [];
        if ($partner->workflow_id != '') {
            for ($i = 0; $i < count($workflowId); $i++) {
                $relatedWorkflow[] = WorkflowCategory::where('id', $workflowId[$i])->first();
            }
        }
        return $relatedWorkflow;
    }
    public function applicationsProduct($id)
    {

        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();
        // dd($product);

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();
        return view('backend.product.application', [
            'partner' => $partner,
            'product' => $product,
            'type' => 'Applications',
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    public function documentProduct($id)
    {
        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();
        $docs = ProductDocumentation::where('product_id', $id)->with('alluser')->get()->toArray();
        return view('backend.product.document', [
            'partner' => $partner,
            'product' => $product,
            'type' => 'Documents',
            'docs' => $docs,
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    public function feesProduct($id)
    {

        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();
        $feetypes = Feetype::get();
        $countrys  = Country::get();
        $allPrices = ProductPrice::where('product_id', $id)->get()->toArray();
        $newprices = [];
        if (count($allPrices) > 0) {

            foreach ($allPrices as $price) {
                $fees = json_decode($price['product_fee_items']);
                $price['nationality'] = json_decode($price['nationality']);
                $allFees = [];
                for ($n = 0; $n < count($fees); $n++) {
                    $allFees[] = ProductFeesItem::where('id', $fees[$n])->with('fleestype')->first();
                }
                $price['allFees'] = $allFees;
                $newprices[] = $price;
            }
        }

        return view('backend.product.fees', [
            'partner' => $partner,
            'product' => $product,
            'type' => 'Fees',
            'feetypes' => $feetypes,
            'countrys' => $countrys,
            'newprices' => $newprices,
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    public function productdocProduct($id, Request $request)
    {
        $prodDoc = new ProductDocumentation();
        if ($request->file('product_doc')) {
            $file = $request->file('product_doc');
            // echo "<pre>"; print_r($file); die();

            $filename = time() . "-" . $file->getClientOriginalName();
            $file->move('assets/upload/product_doc/', $filename);
            $prodDoc->product_id = $id;
            $prodDoc->file_name = $filename;
            $prodDoc->file_size = $file->getSize();
            $prodDoc->author = session()->get('user_id');
            $prodDoc->save();
            return redirect('admin/product/document/' . $id)->with('success', 'Doucmentation has been added successfully !!');
        } else {
            return redirect('admin/product/document/' . $id)->with('Danger', 'Error Something !!');
        }
    }
    public function productdocDeleteProduct($id)
    {

        $prod = ProductDocumentation::where('id', $id)->first();
        $myLink = base_path() . "/assets/upload/product_doc/" . $prod->file_name;
        if (file_exists($myLink)) {
            unlink($myLink);
        }
        ProductDocumentation::where('id', $id)->delete();
        return redirect('admin/product/document/' . $id)->with('success', 'Doucmentation has been delete successfully !!');
    }
    public function requirementProduct($id)
    {
        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();

        return view('backend.product.requirement', [
            'partner' => $partner,
            'product' => $product,
            'type' => 'Requirements',
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    public function otherinformationProduct($id)
    {
        $product = Product::where('id', $id)->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();
        return view('backend.product.otherinformation', [
            'partner' => $partner,
            'product' => $product,
            'type' => 'OtherInformation',
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    public function promotionProduct($id)
    {
        $product = Product::find($id)->toArray();

        $partner = Partner::find($product['partner_id']);
        $relatedWorkflow = $this->productWorkflow($partner);

        $branches = PartnerBranch::where('partner_id', $product['partner_id'])->get();
        $products = Product::where('partner_id', $product['partner_id'])->get();

        $promotions = Promotion::where('partner_id', $product['partner_id'])->get();

        foreach($promotions as $key => $promotion) {
            $productId = explode(',', $promotion['product_id']);
            
            $relatedProduct = [];
            for ($i = 0; $i < count($productId); $i++) {
                $relatedProduct[$i] = Product::find($productId[$i]);
            }

            $promotions[$key]['products'] = $relatedProduct;
        }
        // dd($promotions);
        $defualtPrice = ProductPrice::where('product_id', $product['id'])->first();

        return view('backend.product.promotion', [
            'product' => $product,
            'products' => $products,
            'partner' => $partner,
            'branches' => $branches,
            'promotions' => $promotions,
            'type' => 'Promotions',
            'defualtPrice' => $defualtPrice,
            'relatedWorkflow' => $relatedWorkflow
        ]);
    }
    protected function productPromotionImageUpload($request){
        // echo 11; die();
        $promotionImage = $request->file('attachment');
        $image = Image::make($promotionImage);
        $fileType = $promotionImage->getClientOriginalExtension();
        $imageName = 'promotion_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/promotions/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    public function productPromotionCreate(Request $request)
    {

        $request->validate([
          'title'    => 'required',
          'description'   => 'required',
          'date_start_end'   => 'required',
        ]);

        // dd($_POST);

        // echo "<pre>"; print_r($_POST); die();

        $promotion = new Promotion();
        $promotion->title = $request->title;
        $promotion->partner_id = $request->partner_id;
        $promotion->description = $request->description;
        $promotion->date_start_end = $request->date_start_end;
        $promotion->apply_status = $request->apply_status;

        if($request->file('attachment')){
            $imageUrl = $this->partnerPromotionImageUpload($request);
            $promotion->attachment = $imageUrl;
        }

        if($request->apply_status == 1){
            $products = Product::where('partner_id',$request->partner_id)->get();
            $productArray = [];
            foreach($products as $product){
                $productArray[] = $product->id;
            }
            $productValue = implode(',',$productArray);
            $promotion->product_id = $productValue;
        }else{
            $promotion->product_id = $request->product_id;
        }

        // echo "<pre>"; print_r($promotion); die();
        $promotion->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function productPromotionEdit(Request $request){
        $promotion = Promotion::where('partner_id', $request->partner_id)->find($request->promotion_id);
        $products = Product::where('partner_id',$request->partner_id)->get();

        $relatedProduct = [];
        $productId = explode(',', $promotion['product_id']);
        for ($i = 0; $i < count($productId); $i++) {
            $relatedProduct[] = Product::select('id')->find($productId[$i]);
        }
        // dd($relatedProduct);

        $result = [
            'promotion' => $promotion,
            'products' => $products,
            'relatedProduct' => $relatedProduct,
        ];

        echo json_encode($result);
    }
    public function productPromotionView(Request $request){
        // dd($_POST);

        $promotion = Promotion::where('partner_id', $request->partner_id)->find($request->promotion_id);
        $products = Product::where('partner_id',$request->partner_id)->get();
        $result = [
            'promotion' => $promotion,
            'products' => $products,
        ];

        echo json_encode($result);
    }
    protected function promotionBasicInfoUpdate($request, $promotion, $imageUrl = null){
        $promotion->partner_id = $request->partner_id;
        $promotion->title = $request->title;
        $promotion->description = $request->description;
        $promotion->date_start_end = $request->date_start_end;
        $promotion->apply_status = $request->apply_status;

        if($request->apply_status == 1){
            $products = Product::where('partner_id',$request->partner_id)->get();
            $productArray = [];
            foreach($products as $product){
                $productArray[] = $product->id;
            }
            $productValue = implode(',',$productArray);
            $promotion->product_id = $productValue;
        }else{
            $promotion->product_id = $request->product_id;
        }

        if($imageUrl){
            $promotion->attachment = $imageUrl;
        }
        // echo "<pre>"; print_r($promotion); die();
        $promotion->save();
    }
    public function productPromotionUpdate(Request $request)
    {
        // dd($_POST);

        $request->validate([
          'title'    => 'required',
          'description'   => 'required',
          'date_start_end'   => 'required',
        ]);

        $promotionImage = $request->file('attachment');
        $promotion = Promotion::find($request->promotion_id);

        if($promotionImage){
            if (File::exists($promotion->attachment)) {
                unlink($promotion->attachment);
            }
            $imageUrl = $this->productPromotionImageUpload($request);
            // echo "<pre>"; print_r($imageUrl); die();
            $this->promotionBasicInfoUpdate($request, $promotion, $imageUrl);
        }else{
            $this->promotionBasicInfoUpdate($request, $promotion);
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function productPromotionDelete($id, $partnerId)
    {
        Promotion::where('id', $id)->delete();
        return redirect('admin/partner/profile/promotion/'.$partnerId)->with('success', 'Promotion has been deleted successfully !!');
    }






    public function renderEdits($id)
    {

        $feetypes = Feetype::get();
        $countrys  = Country::get();
        $allPrices = ProductPrice::where('id', $id)->first()->toArray();
        $product = Product::where('id', $allPrices['product_id'])->with('PartnerBranch')->with('partner')->with('productType')->first()->toArray();
        $newprices = [];
        if (count($allPrices) > 0) {
            $fees = json_decode($allPrices['product_fee_items']);
            $allPrices['nationality'] = json_decode($allPrices['nationality']);
            $allFees = [];
            for ($n = 0; $n < count($fees); $n++) {
                $allFees[] = ProductFeesItem::where('id', $fees[$n])->with('fleestype')->first();
            }
            $allPrices['allFees'] = $allFees;
            $newprices = $allPrices;
        }


        $view = view('backend.product.edit_fees', ['feetypes' => $feetypes, 'countrys' => $countrys, 'newprices' => $newprices, 'product' => $product])->render();
        header("Content-type: text/html");
        header("Content-Disposition: attachment; filename=view.html");
        return $view;
    }
    public function productFeesUpdate($id, Request $request)
    {
        $infos = $request->all();
        $i = 0;
        $grand_total = 0;
        $ids = [];
        foreach ($infos['fee_type_id'] as $info) {

            if ($infos['id'][$i]) {
                $fees = ProductFeesItem::where('id', $infos['id'][$i])->first();
                $fees->fee_type_id = $infos['fee_type_id'][$i];
                $fees->product_id = $id;
                $fees->amount = $infos['amount'][$i];
                $fees->client_revenue_type = ($infos['client_revenue_type'][$i] ? $infos['client_revenue_type'][$i] : 1);
                $fees->commission_percentage = ($infos['commission_percentage'][$i] ? $infos['commission_percentage'][$i] : 0);
                $fees->installments = $infos['installments'][$i];
                $fees->amount_total = $infos['amount_total'][$i];
                $fees->show_in_quotation =  $infos['show_in_quotation'][$i];;
                $fees->save();
                $ids[] = $infos['id'][$i];
            } else {
                $fees = new ProductFeesItem();
                $fees->fee_type_id = $infos['fee_type_id'][$i];
                $fees->product_id = $id;
                $fees->amount = $infos['amount'][$i];
                $fees->client_revenue_type = ($infos['client_revenue_type'][$i] ? $infos['client_revenue_type'][$i] : 1);
                $fees->commission_percentage = ($infos['commission_percentage'][$i] ? $infos['commission_percentage'][$i] : 0);
                $fees->installments = $infos['installments'][$i];
                $fees->amount_total = $infos['amount_total'][$i];
                $fees->show_in_quotation =  $infos['show_in_quotation'][$i];;
                $fees->save();
                $ids[] = $fees->id;
            }
            $grand_total += $infos['amount_total'][$i];
            $i++;
        }

        $productfees = ProductPrice::where('id', $id)->first();
        $productfees->name = $infos['fees_name'];
        $productfees->fee_term_id = $infos['installment'];
        $productfees->nationality = json_encode($infos['country_name']);
        $productfees->product_fee_items = json_encode($ids);
        $productfees->totals = $grand_total;
        $productfees->id = $id;
        $productfees->save();
        return redirect('admin/product/fees/' . $productfees->product_id)->with('success', 'Fees has been Updated successfully !!');
    }
    public function productFees($id, Request $request)
    {

        $infos = $request->all();

        $i = 0;
        $grand_total = 0;
        $ids = [];
        foreach ($infos['fee_type_id'] as $info) {
            $fees = new ProductFeesItem();
            $fees->fee_type_id = $infos['fee_type_id'][$i];
            $fees->product_id = $id;
            $fees->amount = $infos['amount'][$i];
            $fees->client_revenue_type = $infos['client_revenue_type'][$i];
            $fees->commission_percentage = ($infos['commission_percentage'][$i] ? $infos['commission_percentage'][$i] : 0);
            $fees->installments = $infos['installments'][$i];
            $fees->amount_total = $infos['amount_total'][$i];
            $fees->show_in_quotation = $infos['show_in_quotation'][$i];
            $fees->save();
            $ids[] = $fees->id;
            $grand_total += $infos['amount_total'][$i];
            $i++;
        }

        $productfees = new ProductPrice();
        $productfees->product_id = $id;
        $productfees->name = $infos['fees_name'];
        $productfees->fee_term_id = $infos['installment'];
        $productfees->nationality = json_encode($infos['country_name']);
        $productfees->product_fee_items = json_encode($ids);
        $productfees->totals = $grand_total;
        $productfees->save();

        return redirect('admin/product/fees/' . $id)->with('success', 'Fees has been added successfully !!');
    }
    public function productFeesDelete($id)
    {
        $productfees = ProductPrice::where('id', $id)->first();
        $product_id = $productfees->product_id;
        $fees_ids = json_decode($productfees->product_fee_items);

        for ($i = 0; $i < count($fees_ids); $i++) {
            ProductFeesItem::where('id', $fees_ids[$i])->delete();
        }
        ProductPrice::where('id', $id)->delete();
        return redirect('admin/product/fees/' . $product_id)->with('success', 'Fees has been deleted successfully !!');
    }
    public function getBranch($id)
    {
        $branches = PartnerBranch::where('partner_id', $id)->get();
        $html = '';
        foreach ($branches as $branche) {
            $html .= '<option value="' . $branche["id"] . '">' . $branche["name"] . '</option>';
        }
        echo $html;
    }
    public function typesto()
    {
        $abc = '[{"id":1,"name":"Accommodation Fee"},{"id":2,"name":"Administration Fee"},{"id":3,"name":"Airline Ticket"},{"id":4,"name":"Airport Transfer Fee"},{"id":5,"name":"Application Fee"},{"id":6,"name":"Bond"},{"id":7,"name":"Exam Fee"},{"id":8,"name":"Date Change Fee"},{"id":9,"name":"Extension Fee"},{"id":10,"name":"Extra Fee"},{"id":11,"name":"FCE Exam Fee"},{"id":12,"name":"Health Cover"},{"id":13,"name":"i20 Fee"},{"id":14,"name":"Instalment Fee"},{"id":15,"name":"Key Deposit Fee"},{"id":16,"name":"Late Payment Fee"},{"id":17,"name":"Material Deposit"},{"id":18,"name":"Material Fee"},{"id":19,"name":"Medical Exam"},{"id":20,"name":"Placement Fee"},{"id":21,"name":"Security Deposit Fee"},{"id":22,"name":"Service Fee"},{"id":23,"name":"Swipe Card Fee"},{"id":24,"name":"Training Fee"},{"id":25,"name":"Transaction Fee"},{"id":26,"name":"Translation Fee"},{"id":27,"name":"Travel Insurance"},{"id":28,"name":"Tuition Fee"},{"id":29,"name":"Visa Counseling"},{"id":30,"name":"Visa Fee"},{"id":31,"name":"Visa Process"},{"id":32,"name":"RMA Fee"},{"id":33,"name":"Registered Migration Agent Fee"},{"id":34,"name":"Enrollment Fee"}]';
        $bbc = json_decode($abc);
        foreach ($bbc as $bb) {
            $news = new Feetype();
            $news->name = $bb->name;
            $news->save();
        }
    }
}
