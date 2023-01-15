<script>
    var selectedCategories = [];
    var attributesValues = [];
    $(function() {
        // category filter
        $(document).on('click', '.category-item', function(e){
            e.stopPropagation();
            var $this = $(this).children('label').children('input');
            var childrens = $(this).find('input');
            if($($this).prop("checked")){
                childrens.each(function(){
                    selectedCategories = selectedCategories.filter((item)=>{
                        return item != $(this).val();
                    })
                    if($($this).attr('id') != $(this).attr('id'))
                        $(this).prop('checked', false)
                });
            }else{
                childrens.each(function(){
                    selectedCategories.push( ($(this).val()) );
                    if($($this).attr('id') != $(this).attr('id'))
                        $(this).prop('checked', true)
                });
            }
            filterProduct();
        })
        // when we click the checkbox, click event happens 2 times. to prevent it 
        $(document).on('click', '.custom-checkbox-container input', function(e){
            e.stopPropagation();
        })

        // active or inactive
        $(document).on('click', '.attribute-item', function(e){
            $(this).toggleClass('active');
            if( $(this).hasClass('active') ){
                attributesValues.push($(this).data('id'));
            }else{
                attributesValues = attributesValues.filter((item)=>{
                    return item != $(this).data('id');
                })                
            }
            filterProduct();
        })
        const filterProduct = ()=>{
            $.ajax({
                url: "{{ url('/filter-product') }}",
                data: {
                    categories: selectedCategories.sort(),
                    attrs: attributesValues.sort()
                },
                success: function(data) {
                    $('div.product-container').html(data);
                }
            })
        }
    })
</script>