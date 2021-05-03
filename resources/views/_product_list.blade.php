            @if(count($products)>0)
            @foreach($products as $row)
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img width="200px" height="180px" src="{{url('public/product_images/'.$row->image)}}" alt="">
                    <div class="caption">
                        <h4>{{$row->name}}</h4>
                        <p>{{$row->description}}</p>
                        <p><strong>Price: </strong>{{$row->price}} </p>
                        <p class="btn-holder"><a href="javascript:void(0)" onclick="addToCart('{{$row->id}}')" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                    </div>
                </div>
            </div>
           @endforeach
           @endif
            {{$products->links()}}

            <script>
                $('.pagination li a').on('click',function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var pageLink = $this.attr('href');
                    getProductList(pageLink);
                })
            </script>