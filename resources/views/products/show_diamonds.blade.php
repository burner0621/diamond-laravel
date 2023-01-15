<div class="show-model-specs">
    <div class="show-specs-btn card rounded mb-3 text-uppercase fw-700 border p-3">
        Diamonds
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <table id="product_diamonds_list" class="table table-lg table-bordered table-nowrap table-align-middle card-table dataTable table-responsive no-footer">
                    <thead>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Amount</th>
                        <th>TCW</th>
                    </thead>
                    <tbody>
                        @foreach ($arrProductDiamonds as $diamond)
                            <tr data-product-attribute-value-id="{{ $diamond->product_attribute_value_id }}" class="diamond">
                                <td>{{ $diamond->typename }}</td>
                                <td>{{ $diamond->mm_size }} mm</td>
                                <td class="product_diamond_amount">{{ $diamond->diamond_amount }}</td>
                                <td class="product_diamond_tcw">{{ $diamond->tcw }}</td>
                            </tr>
                        @endforeach
                        @if(isset($arrProductDiamonds) && count($arrProductDiamonds) > 0)
                            <tr>
                                <td colspan="2"></td>
                                <td class="total_amount"></td>
                                <td class="total_tcw"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var total_amount = 0;
    var total_tcw = 0;
    $(".product_diamond_amount").map(function(idx, ele){
        total_amount += Number($(ele).html());
    })
    $(".total_amount").html(total_amount)
    $(".product_diamond_tcw").map(function(idx, ele){
        total_tcw += Number($(ele).html())
    })
    $(".total_tcw").html(total_tcw.toFixed(2))

</script>
