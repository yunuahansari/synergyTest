@extends('layout')
@section('title', 'Products')
@section('content')
    <div class="container products">
        <div class="row" id="product_list">
        </div>
    </div>

    <script>
    $(document).ready(function(){
        getProductList()
    });

    function getProductList(url) {
        var url = (url)?url:"{{ url('product_list') }}"
        $.ajax({
            url: url,
            type: 'get',
            datatype: 'html',
            success: function(data) {
                if(data.success == true) {
                $('#product_list').html(data.html);
                } else {
                    toastr.error(data.message);
                }
            },
            error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
}

function addToCart(productid){
    var url = "{{ url('add-to-cart') }}/"+productid;
        $.ajax({
            url: url,
            type: 'get',
            datatype: 'json',
            success: function(data) {
                if(data.success == true) {
                  toastr.success(data.message);
                 var previous = $('.badge-pill').text();
                 var current = parseInt(previous)+1;
                 $('.badge-pill').text(current);
                } else {
                    toastr.error(data.message);
                }
            },
            error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
}

</script>
@endsection
 