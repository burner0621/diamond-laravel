<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Http\Requests\StoreAttributeRequest;
use App\Models\ProductsVariant;
use App\Models\Product;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.products.attributes.list',[
            'attributes' => Attribute::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function getvalues(Request $request)
    {
        $type = Attribute::find($request->id_attribute)->type;
        $values = AttributeValue::where('attribute_id', $request->id_attribute)->get();
        return view('backend.products.ajax.values', [
            'values' => $values,
            'type' => $type
        ]);
    }

    public function ajaxcall(Request $request)
    {
        
        $attributes = Attribute::whereIn('id', $request->input('attributes'))->with(['values'])->get();
        return view('backend.products.attributes.values.ajax', [
            'attributes' => $attributes
        ]);
    }

    private function make_combinations($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }
        
        // get combinations from subsequent arrays
        $tmp = self::make_combinations($arrays, $i + 1);
        
        $result = array();
    
        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                
                $result[] = is_array($t) ? 
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }
    
        return $result;
    }
    public function combinations(Request $request)
    {
        $values = AttributeValue::whereIn('id', $request->input('values'))->get();
        $groupped_values = $values->groupBy('attribute_id')->toArray();
        $table = [];
        $i = 0;
        foreach ($groupped_values as $value)
        {
            $table[$i] = [];
  
            foreach ($value as $data)
            {
                array_push($table[$i], $data['attribute_id']."-".$data['id']."-".$data['name']);
            }
            $i++;
        }

        $combined = $this->make_combinations($table);

        // $result = [];
        // if (isset($request->product_id)) {
        //     // remove the items on product variants
        //     $productVariants = ProductsVariant::where('product_id', $request->product_id)->get();

        //     $variantAttributeValues = [];

        //     foreach ($productVariants as $variant) {
        //         $variantAttributeValues[] = $variant->variant_attribute_value;
        //     }

        //     foreach ($combined as $value) {
        //         $combinedId = [];

        //         foreach ($value as $item) {
        //             $id = explode('-', $item);

        //             $combinedId[] = $id[1];
        //         }

        //         $combinedId = implode(',', $combinedId);

        //         if (!in_array($combinedId, $variantAttributeValues)) {
        //             $result[] = $value;
        //         }
        //     }
        // } else {
        //     $result = $combined;
        // }

        // $productVariant

        return view('backend.products.ajax.values', [
            'variants' => $combined,
            'product_id' => $request->product_id ? $request->product_id : 0,
            'isDigital' => $request->isDigital
        ]);
       
    }

    function getProductAttribute(Request $request) {
        return ProductsVariant::where('product_id', $request->product_id)->with('uploads', 'asset')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $request)
    {
        $data = $request->input();
        $data['slug'] = str_replace(" ","-", strtolower($request->name));
        Attribute::Create($data);
        return redirect()->route('backend.products.attributes.list');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.products.attributes.edit',[
            'attribute' => Attribute::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttributeRequest $request, $id)
    {
        $data = $request->input();
        $data['slug'] = str_replace(" ","-", strtolower($request->name));
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);
        return redirect()->route('backend.products.attributes.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if($attribute){
            $attribute->values()->delete();
            $attribute->delete();
        }
        Product::where('product_attributes', 'like', '%'.$id.',%')
                ->where('status', 1)
                ->orWhere('product_attributes', 'like', '%,'.$id.'%')
                ->orWhere('product_attributes', $id)
                ->update([
                    'status'=>2
                ]);
        return redirect()->route('backend.products.attributes.list');
    }
}
