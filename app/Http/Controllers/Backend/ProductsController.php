<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductMeasurement;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Models\ProductsCategorie;
use App\Models\ProductTag;
use App\Models\ProductsVariant;
use App\Models\SellerEditProducts;
use App\Models\SellerEditProductVariants;
use App\Models\Attribute;
use App\Models\Material;
use App\Models\ProductMaterial;
use App\Models\ProductsTaxOption;
use App\Models\Upload;
use App\Models\ProductTagsRelationship;
use App\Models\MaterialTypeDiamonds;
use App\Models\MaterialType;
use App\Models\MaterialTypeDiamondsColor;
use App\Models\MaterialTypeDiamondsClarity;
use App\Models\MaterialTypeDiamondsPrices;
use App\Models\Step;
use App\Models\StepGroup;
use App\Models\AttributeValue;
use App\Models\ProductMeasurementRelationship;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.products.list', [
            'products' => Product::where('status', '!=', 5)->with('product_category')->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     *
     * Display pending products that its status is 1
     */
    public function active()
    {
        return view('backend.products.active', [
            'products' => Product::where('status', 1)->with('product_category')->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     *
     * Display pending products that its status is 2
     */
    public function pending()
    {
        return view('backend.products.pending', [
            'products' => Product::where('status', 2)->with('product_category')->orderBy('id', 'DESC')->get()
        ]);
    }

    public function editPendingShow()
    {
        return view('backend.products.pending_show', [
            'products' => SellerEditProducts::where('is_approved', 0)->with('product_category')->orderBy('product_id', 'DESC')->get()
        ]);
    }

    public function archive()
    {
        return view('backend.products.archive', [
            'products' => Product::where('status', 5)->orderBy('id', 'DESC')->get()
        ]);
    }

    public function get()
    {
        return datatables()->of(Product::query())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<a href="' . route('products.show', $row->id) . '" target="_blank" class="edit btn btn-info btn-sm">View</a>';
                $btn = $btn . '<a href="' . route('backend.products.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn = $btn . '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrStepGroups = StepGroup::pluck('name', 'id')->toArray();
        $arrSteps = Step::pluck('name', 'id')->toArray();

        return view('backend.products.create', [
            'attributes' => Attribute::orderBy('id', 'DESC')->get(),
            'categories' => ProductsCategorie::all(),
            'tags' => ProductTag::all(),
            'taxes' => ProductsTaxOption::all(),
            'arrStepGroups' => $arrStepGroups,
            'arrSteps' => $arrSteps,
        ]);
    }

    private function generateSlug($string)
    {
        return str_replace(' ', '-', $string);
    }

    private function registerNewTag($tag)
    {
        $blogtag = ProductTag::create([
            'name' => $tag,
            'slug' => $this->generateSlug($tag),
        ]);
        return $blogtag->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $req)
    {
        $tags = (array)$req->input('tags');
        $variants = (array)$req->input('variant');
        $attributes = implode(",", (array)$req->input('attributes'));
        $values = implode(",", (array)$req->input('values'));
        $data = $req->all();
        $data['vendor'] = auth()->id();
        $data['price'] = Product::stringPriceToCents($req->price);
        $data['is_digital'] = $req->is_digital ? 1 : 0;
        $data['is_virtual'] = $req->is_virtual ? 1 : 0;
        $data['is_backorder'] = $req->is_backorder ? 1 : 0;
        $data['is_madetoorder'] = $req->is_madetoorder ? 1 : 0;
        $data['is_trackingquantity'] = $req->is_trackingquantity ? 1 : 0;
        $data['product_attributes'] = $attributes;
        $data['product_attribute_values'] = $values;
        $data['slug'] = str_replace(" ", "-", strtolower($req->name));
        $slug_count = Product::where('slug', $data['slug'])->count();
        if ($slug_count) {
            $data['slug'] = $data['slug'] . '-' . ($slug_count + 1);
        }
        $product = Product::create($data);
        $id_product = $product->id;

        foreach ($variants as $variant) {
            $variant_data = $variant;
            $variant_data['product_id'] = $id_product;
            $variant_data['variant_price'] = Product::stringPriceToCents($variant_data['variant_price']);

            ProductsVariant::create($variant_data);
        }

        foreach ($tags as $tag) {
            $id_tag = (!is_numeric($tag)) ? $this->registerNewTag($tag) : $tag;
            ProductTagsRelationship::create([
                'id_tag' => $id_tag,
                'id_product' => $id_product,
            ]);
        }

        return redirect()->route('backend.products.edit', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function pendingEdit($id)
    {
        $product = SellerEditProducts::whereId($id)->with(['tags', 'variants', 'variants.uploads'])->firstOrFail();
        $product->setPriceToFloat();
        $product_measurements = ProductMeasurement::all();

        $variants = SellerEditProductVariants::where('product_id', $product->product_id)->get();

        $variants->each(function ($product) {
            $product->setPriceToFloat();
        });

        $selected_attributes = explode(',', $product->product_attributes);
        $prepare_values = Attribute::whereIn('id', $selected_attributes)->with(['values'])->get();
        $seller = User::query()->find($product->vendor);

        $arrMaterials = Material::with('types')->get();
        $arrProductMaterials = ProductMaterial::getMaterialsByProduct($product->product_id);
        $arrDiamondTypes = MaterialTypeDiamonds::where('material_id', '=', '1')->get();
        $arrDiamondTypeColors = MaterialTypeDiamondsColor::all();
        $arrDiamondTypeClarity = MaterialTypeDiamondsClarity::all();
        $user_id = Auth::id();
        $arrDiamondTypePrices = MaterialTypeDiamondsPrices::where('user_id', $user_id)->get()->toArray();
        $diamondPrices = [];
        foreach ($arrDiamondTypePrices as $key => $value) {
            $diamondPrices[$value['diamond_id']] = $value;
        }

        $arrStepGroups = StepGroup::pluck('name', 'id')->toArray();
        $arrSteps = Step::pluck('name', 'id')->toArray();

        return view('backend.products.pending_edit', [
            'product' => $product,
            'product_measurements' => $product_measurements,
            'variants' => $variants,
            'categories' => ProductsCategorie::all(),
            'attributes' => Attribute::orderBy('id', 'DESC')->get(),
            'tags' => ProductTag::all(),
            'uploads' => Upload::whereIn('id', explode(',', $product->product_images))->get(),
            'selected_values' => $prepare_values,
            'seller' => $seller,
            'taxes' => ProductsTaxOption::all(),
            'arrProductMaterials' => $arrProductMaterials,
            'arrDiamondTypes' => $arrDiamondTypes,
            'arrMaterials' => $arrMaterials,
            'arrSteps' => $arrSteps,
            'arrStepGroups' => $arrStepGroups,
            'arrDiamondTypeColors' => $arrDiamondTypeColors,
            'arrDiamondTypeClarity' => $arrDiamondTypeClarity,
            'diamondPrices' => $diamondPrices,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::whereId($id)->with(['tags', 'variants', 'variants.uploads'])->firstOrFail();
        $product->setPriceToFloat();
        $product_measurements = ProductMeasurement::all();

        $variants = ProductsVariant::where('product_id', $id)->get();

        $variants->each(function ($product) {
            $product->setPriceToFloat();
        });

        $selected_attributes = explode(',', $product->product_attributes);
        $prepare_values = Attribute::whereIn('id', $selected_attributes)->with(['values'])->get();
        $seller = User::query()->find($product->vendor);

        $arrMaterials = Material::with('types')->get();
        $arrProductMaterials = ProductMaterial::getMaterialsByProduct($product->id);
        $arrDiamondTypes = MaterialTypeDiamonds::where('material_id', '=', '1')->get();
        $arrDiamondTypeColors = MaterialTypeDiamondsColor::all();
        $arrDiamondTypeClarity = MaterialTypeDiamondsClarity::all();
        $user_id = Auth::id();
        $arrDiamondTypePrices = MaterialTypeDiamondsPrices::where('user_id', $user_id)->get()->toArray();
        $diamondPrices = [];
        foreach ($arrDiamondTypePrices as $key => $value) {
            $diamondPrices[$value['diamond_id']] = $value;
        }

        $arrStepGroups = StepGroup::pluck('name', 'id')->toArray();
        $arrSteps = Step::pluck('name', 'id')->toArray();

        return view('backend.products.edit', [
            'product' => $product,
            'product_measurements' => $product_measurements,
            'variants' => $variants,
            'categories' => ProductsCategorie::all(),
            'attributes' => Attribute::orderBy('id', 'DESC')->get(),
            'tags' => ProductTag::all(),
            'uploads' => Upload::whereIn('id', explode(',', $product->product_images))->get(),
            'selected_values' => $prepare_values,
            'seller' => $seller,
            'taxes' => ProductsTaxOption::all(),
            'arrProductMaterials' => $arrProductMaterials,
            'arrDiamondTypes' => $arrDiamondTypes,
            'arrMaterials' => $arrMaterials,
            'arrSteps' => $arrSteps,
            'arrStepGroups' => $arrStepGroups,
            'arrDiamondTypeColors' => $arrDiamondTypeColors,
            'arrDiamondTypeClarity' => $arrDiamondTypeClarity,
            'diamondPrices' => $diamondPrices,
        ]);
    }


    public function pendingUpdate(ProductStoreRequest $req, $product)
    {
        if ($req->status !== "2") {
            $counter = Product::where('slug', $req->slug)->count();
            $sep = ($counter == 0) ? '' : '-' . $counter + 1;
            $tags = (array)$req->input('tags');
            $variants = (array)$req->input('variant');
            $attributes = implode(",", (array)$req->input('attributes'));
            $values = implode(",", (array)$req->input('values'));
            $data = $req->all();
            $data['price'] = Product::stringPriceToCents($req->price);
            $data['is_digital'] = ($req->is_digital) ? 1 : 0;
            $data['is_virtual'] = ($req->is_virtual) ? 1 : 0;
            $data['is_backorder'] = ($req->is_backorder & $req->is_backorder == 1) ? 1 : 0;
            $data['is_madetoorder'] = ($req->is_madetoorder & $req->is_madetoorder == 1) ? 1 : 0;
            $data['is_trackingquantity'] = $req->is_trackingquantity ? 1 : 0;
            $data['product_attributes'] = $attributes;
            $data['product_attribute_values'] = $values;
            $data['category'] = $req->get('category');

            if ($req->slug == "") {
                $data['slug'] = str_replace(" ", "-", strtolower($req->name)) . $sep;
            }
            $user_id = Auth::id();
            $edit_product = SellerEditProducts::find($product);
            $edit_product->is_approved = 1;
            $edit_product->update();
            $product = Product::findOrFail($edit_product->product_id);
            $product->update($data);
            ProductTagsRelationship::where('id_product', $product->id)->delete();

            $variantIds = [];
            foreach ($variants as $variant) {
                $variantIds[] = $variant['id'];
            }
            ProductsVariant::where('product_id', $product->id)->whereNotIn('id', $variantIds)->delete();

            foreach ($variants as $variant) {
                $variant_data = $variant;
                $variant_data['product_id'] = $product->id;
                $variant_data['variant_price'] = Product::stringPriceToCents($variant_data['variant_price']);

                ProductsVariant::updateOrCreate(['product_id' => $product->id, 'variant_attribute_value' => $variant['variant_attribute_value']], $variant_data);
            }

            foreach ($tags as $tag) {
                $id_tag = (!is_numeric($tag)) ? $this->registerNewTag($tag) : $tag;
                ProductTagsRelationship::create([
                    'id_tag' => $id_tag,
                    'id_product' => $product->id
                ]);

            }

            $product_measurement_values = $req->product_measurement_values ? $req->product_measurement_values : [];
            $product_measurement_ids = $req->product_measurement_ids ? $req->product_measurement_ids: [];

            ProductMeasurementRelationship::where('product_id', $product->id)
                ->whereNotIn('measurement_id', $product_measurement_ids)
                ->delete();

            $product_measurement_relationships = array();
            foreach($product_measurement_values as $k => $product_measurement_value){
                ProductMeasurementRelationship::updateOrCreate(
                    ['product_id' => $product->id, 'measurement_id' => $product_measurement_ids[$k]],
                    ['value' => $product_measurement_value]
                );
            }

            cache()->forget('todays-deals');
        } else {
            $tags = (array) $req->input('tags');
            $variants = (array) $req->input('variant');
            $attributes = implode(",", (array) $req->input('attributes'));
            $values = implode(",", (array) $req->input('values'));
            $data = $req->all();
            $data['vendor'] = auth()->id();
            $data['price'] = Product::stringPriceToCents($req->price);
            $data['is_digital'] = 1;
            $data['status'] = 2;
            $data['is_virtual'] = 0;
            $data['is_backorder'] = 0;
            $data['is_madetoorder'] = 0;
            $data['is_trackingquantity'] = 0;
            $data['product_attributes'] = $attributes;
            $data['product_attribute_values'] = $values;
            $data['slug'] = str_replace(" ", "-", strtolower($req->name));
            $slug_count = Product::where('slug', $data['slug'])->count();
            if ($slug_count) {
                $data['slug'] = $data['slug'] . '-' . ($slug_count + 1);
            }
            $edit_product = SellerEditProducts::where('id', $product)->first();
            if (!$edit_product) {
                $edit_product = SellerEditProducts::create($data);
            } else {
                $edit_product->update($data);
            }
            $id_product = $edit_product->product_id;

            $variantIds = [];
            foreach ($variants as $variant) {
                $variantIds[] = $variant['id'];
            }
            SellerEditProductVariants::where('product_id', $id_product)->whereNotIn('id', $variantIds)->delete();

            foreach ($variants as $variant) {
                $variant_data = $variant;
                $variant_data['variant_id'] = (int)$variant['id'];
                $variant_data['product_id'] = $id_product;
                $variant_data['variant_price'] = SellerEditProductVariants::stringPriceToCents($variant_data['variant_price']);
                SellerEditProductVariants::updateOrCreate(['product_id' => $id_product, 'variant_attribute_value' => $variant['variant_attribute_value']], $variant_data);
            }
        }
        return redirect()->route('backend.products.edit_pending.list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStoreRequest $req, $product)
    {

        $counter = Product::where('slug', $req->slug)->count();
        $sep = ($counter == 0) ? '' : '-' . $counter + 1;
        $tags = (array)$req->input('tags');
        $variants = (array)$req->input('variant');
        $attributes = implode(",", (array)$req->input('attributes'));
        $values = implode(",", (array)$req->input('values'));
        $data = $req->all();
        $data['price'] = Product::stringPriceToCents($req->price);
        $data['is_digital'] = ($req->is_digital) ? 1 : 0;
        $data['is_virtual'] = ($req->is_virtual) ? 1 : 0;
        $data['is_backorder'] = ($req->is_backorder & $req->is_backorder == 1) ? 1 : 0;
        $data['is_madetoorder'] = ($req->is_madetoorder & $req->is_madetoorder == 1) ? 1 : 0;
        $data['is_trackingquantity'] = $req->is_trackingquantity ? 1 : 0;
        $data['product_attributes'] = $attributes;
        $data['product_attribute_values'] = $values;
        $data['category'] = $req->get('category');

        if ($req->slug == "") {
            $data['slug'] = str_replace(" ", "-", strtolower($req->name)) . $sep;
        }
        $user_id = Auth::id();
        $product = Product::findOrFail($product);
        $product->update($data);
        ProductTagsRelationship::where('id_product', $product->id)->delete();

        // product material
        /*if (isset($data['product_material_id'])) {
            $product_material_id = $data['product_material_id'];
        }
        if (isset($data['deleted_material_ids'])) {
            foreach ($data['deleted_material_ids'] as $deleted_item) {
                $material = ProductMaterial::findOrFail($deleted_item);
                $material->delete();
            }
        }*/
        /*if (isset($data['diamond_id'])) {
            $i = 0;
            $material_order = -1;
            foreach ($data['product_material_id'] as $item) {
                if ($data['material_id'][$i] == 1) {
                    if (!$product_material_id[$i]) {
                        $temp['product_id'] = $product->id;
                        $temp['material_id'] = $data['material_id'][$i];
                        $temp['material_type_id'] = $data['material_type_id'][$i];
                        $temp['diamond_id'] = $data['diamond_id'][$i];
                        $temp['is_diamond'] = 1;
                        $temp['diamond_amount'] = $data['diamond_amount'][$i];
                        $temp['material_weight'] = '';
                        ProductMaterial::create($temp);
                    } else {
                        $product_material = ProductMaterial::find($product_material_id[$i]);
                        $temp['product_id'] = $product->id;
                        $temp['material_id'] = $data['material_id'][$i];
                        $temp['material_type_id'] = $data['material_type_id'][$i];
                        $temp['diamond_id'] = $data['diamond_id'][$i];
                        $temp['is_diamond'] = 1;
                        $temp['diamond_amount'] = $data['diamond_amount'][$i];
                        $temp['material_weight'] = '';
                        $product_material->update($temp);
                    }
                    $diamond_prices = MaterialTypeDiamondsPrices::where('user_id', $user_id)->where('diamond_id', $data['diamond_id'][$i])->first();
                    if (isset($diamond_prices)) {
                        $price['diamond_id'] = $data['diamond_id'][$i];
                        $price['color'] = $data['diamond_color'][$i];
                        $price['clarity'] = $data['diamond_clarity'][$i];
                        $price['lab_price'] = $data['lab_price'][$i];
                        $price['natural_price'] = $data['natural_price'][$i];
                        $diamond_prices->update($price);
                    } else {
                        $price['user_id'] = $user_id;
                        $price['diamond_id'] = $data['diamond_id'][$i];
                        $price['color'] = $data['diamond_color'][$i];
                        $price['clarity'] = $data['diamond_clarity'][$i];
                        $price['lab_price'] = $data['lab_price'][$i];
                        $price['natural_price'] = $data['natural_price'][$i];
                        MaterialTypeDiamondsPrices::create($price);
                    }
                } else {
                    if ($material_order == -1) {
                        $material_order = $i;
                    }
                    if (!$product_material_id[$i]) {
                        $temp['product_id'] = $product->id;
                        $temp['product_attribute_value_id'] = $data['product_attribute_value_id'][$i - $material_order];
                        $temp['material_id'] = $data['material_id'][$i];
                        $temp['material_type_id'] = $data['material_type_id'][$i];
                        $temp['diamond_id'] = 0;
                        $temp['is_diamond'] = 0;
                        $temp['material_weight'] = $data['material_weight'][$i];
                        $temp['diamond_amount'] = '';
                        ProductMaterial::create($temp);
                    } else {
                        $product_material = ProductMaterial::find($product_material_id[$i]);
                        $temp['product_id'] = $product->id;
                        $temp['product_attribute_value_id'] = $data['product_attribute_value_id'][$i - $material_order];
                        $temp['material_id'] = $data['material_id'][$i];
                        $temp['material_type_id'] = $data['material_type_id'][$i];
                        $temp['diamond_id'] = 0;
                        $temp['is_diamond'] = 0;
                        $temp['material_weight'] = $data['material_weight'][$i];
                        $temp['diamond_amount'] = '';
                        $product_material->update($temp);
                    }
                }
                $i++;
            }
        }*/


        // product variant

        $variantIds = [];
        foreach ($variants as $variant) {
            $variantIds[] = $variant['id'];
        }
        ProductsVariant::where('product_id', $product->id)->whereNotIn('id', $variantIds)->delete();

        foreach ($variants as $variant) {
            $variant_data = $variant;
            $variant_data['product_id'] = $product->id;
            $variant_data['variant_price'] = Product::stringPriceToCents($variant_data['variant_price']);

            ProductsVariant::updateOrCreate(['product_id' => $product->id, 'variant_attribute_value' => $variant['variant_attribute_value']], $variant_data);
        }

        foreach ($tags as $tag) {
            $id_tag = (!is_numeric($tag)) ? $this->registerNewTag($tag) : $tag;
            ProductTagsRelationship::create([
                'id_tag' => $id_tag,
                'id_product' => $product->id
            ]);

        }

        $product_measurement_values = $req->product_measurement_values ? $req->product_measurement_values : [];
        $product_measurement_ids = $req->product_measurement_ids ? $req->product_measurement_ids: [];

        ProductMeasurementRelationship::where('product_id', $product->id)
            ->whereNotIn('measurement_id', $product_measurement_ids)
            ->delete();

        $product_measurement_relationships = array();
        foreach($product_measurement_values as $k => $product_measurement_value){
            ProductMeasurementRelationship::updateOrCreate(
                ['product_id' => $product->id, 'measurement_id' => $product_measurement_ids[$k]],
                ['value' => $product_measurement_value]
            );
        }

        cache()->forget('todays-deals');

        return redirect()->route('backend.products.edit', $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 5;
        $product->save();
        return redirect()->route('backend.products.list');
    }

    public function recover($id)
    {
        $product = Product::where('status', 5)->find($id);
        if ($product) {
            $product->status = 2;
            $product->save();
        }
        return redirect()->route('backend.products.archive');
    }

    public function update_digital_assets(Request $request, $id)
    {
        $ret = !!OrderItem::where("id", $request->orderId)->update(["product_digital_download_assets" => $request->value]);
        return Product::where('id', $id)->update(['digital_download_assets' => $request->value]) && $ret;
    }

    public function update_variant_assets(Request $request, $id)
    {
        return ProductsVariant::where('id', $id)->update(['digital_download_assets' => $request->value]);
    }

    public function product_materials(Request $request, $id)
    {
        $product = Product::find($id);
        $materials = Material::all();
        $material_types = MaterialType::all();
        $material_type_diamonds = MaterialTypeDiamonds::all();
        $material_type_diamonds_clarities = MaterialTypeDiamondsClarity::all();
        $material_type_diamonds_colors = MaterialTypeDiamondsColor::all();
        $material_type_diamonds_prices = MaterialTypeDiamondsPrices::all();
        $attribute_values = AttributeValue::all();

        $selected_attributes = explode(',', $product->product_attributes);
        $product_attributes = Attribute::whereIn('id', $selected_attributes)->with(['values'])->get();

        return view('backend.products.product_materials.edit', compact('product', 'materials', 'material_types', 'material_type_diamonds',
            'material_type_diamonds_clarities', 'material_type_diamonds_colors', 'material_type_diamonds_prices', 'attribute_values', 'product_attributes'));
    }

    public function update_product_materials(Request $request)
    {
        $product_id = $request->product_id;
        $product_material_ids = $request->product_material_id ? $request->product_material_id : [];
        $product_attribute_value_ids = $request->product_attribute_value_id ? $request->product_attribute_value_id : [];
        $material_type_ids = $request->material_type_id ? $request->material_type_id : [];
        $diamond_amounts = $request->diamond_amount ? $request->diamond_amount : [];
        $material_type_diamonds_ids = $request->material_type_diamonds_id ? $request->material_type_diamonds_id : [];
        $material_type_diamonds_clarity_ids = $request->material_type_diamonds_clarity_id ? $request->material_type_diamonds_clarity_id : [];
        $material_type_diamonds_color_ids = $request->material_type_diamonds_color_id ? $request->material_type_diamonds_color_id : [];
        $material_type_diamonds_natural_prices = $request->material_type_diamonds_natural_price ? $request->material_type_diamonds_natural_price : [];
        $material_type_diamonds_lab_prices = $request->material_type_diamonds_lab_price ? $request->material_type_diamonds_lab_price : [];

        $metal_product_material_ids = $request->metal_product_material_id ? $request->metal_product_material_id : [];
        $metal_material_type_ids = $request->metal_material_type_id ? $request->metal_material_type_id : [];
        $metal_product_attribute_value_ids = $request->metal_product_attribute_value_id ? $request->metal_product_attribute_value_id : [];
        $material_weights = $request->material_weight ? $request->material_weight : [];

        ProductMaterial::whereNotIn('id', $product_material_ids)
            ->where('product_id', $product_id)
            ->where('is_diamond', 1)
            ->delete();

        foreach ($product_material_ids as $k => $product_material_id) {
            /* Update */
            if ($product_material_id) {
                $product_material = ProductMaterial::find($product_material_id);
            } else {
                $product_material = new ProductMaterial;
                $product_material->product_id = $product_id;
                $product_material->material_id = 1;
                $product_material->is_diamond = 1;
            }

            $product_material->product_attribute_value_id = $product_attribute_value_ids[$k];
            $product_material->diamond_amount = $diamond_amounts[$k];
            $product_material->diamond_id = $material_type_diamonds_ids[$k];
            $product_material->material_type_id = $material_type_ids[$k];

            $product_material->save();

            $material_type_diamonds_price = MaterialTypeDiamondsPrices::where('diamond_id', $material_type_diamonds_ids[$k])
                ->first();

            if (!$material_type_diamonds_price) {
                $material_type_diamonds_price = new MaterialTypeDiamondsPrices;
                $material_type_diamonds_price->user_id = Auth::id();
                $material_type_diamonds_price->diamond_id = $material_type_diamonds_ids[$k];
            }

            $material_type_diamonds_price->color = $material_type_diamonds_color_ids[$k];
            $material_type_diamonds_price->clarity = $material_type_diamonds_clarity_ids[$k];
            $material_type_diamonds_price->natural_price = $material_type_diamonds_natural_prices[$k];
            $material_type_diamonds_price->lab_price = $material_type_diamonds_lab_prices[$k];

            $material_type_diamonds_price->save();
        }

        ProductMaterial::whereNotIn('id', $metal_product_material_ids)
            ->where('product_id', $product_id)
            ->where('is_diamond', '<>', 1)
            ->delete();

        foreach ($metal_product_material_ids as $k => $metal_product_material_id) {
            /* Update */
            if ($metal_product_material_id) {
                $product_material = ProductMaterial::find($metal_product_material_id);
            } else {
                $product_material = new ProductMaterial;
                $product_material->product_id = $product_id;
                $product_material->material_id = 2;
                $product_material->is_diamond = 0;
            }

            $product_material->product_attribute_value_id = $metal_product_attribute_value_ids[$k];
            $product_material->material_type_id = $metal_material_type_ids[$k];
            $product_material->material_weight = $material_weights[$k];

            $product_material->save();
        }

        return redirect()->back();
    }
}
