<div>
    <h6 style="margin: 2px;">Tin tức</h6>
    <hr class="mb-3">
    @foreach ($posts as $post)
    
        <div class="post mb-3">
        <a href="{{ url('/post', $post->mabaiviet) }}">
            <div style="padding: 0px; margin: 0px;">
                <img src="{{ asset($post->hinhanhminhhoa) }}" alt="" style="width: 100%; height: 150px;">
            </div>
            <div style="padding: 0px; margin: 0px;">
                <h5 style="font-size: 13px; color:blue; margin:0px">{{ $post->tenbaiviet }}</h5>
        </a>
                <p style="font-size: 10px; margin: 0px">({{ \Carbon\Carbon::parse($post->ngaydangtai)->format('d/m/Y') }})</p>
                <p style="font-size: 12px;">{{ $post->motabaiviet }}</p>
            </div>
        </div>
    
    @endforeach
</div>