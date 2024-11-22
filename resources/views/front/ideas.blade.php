@extends('front.layouts.app')

@section('main')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Ideas</h2>
                </div>
                {{-- <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control">
                            <option value="">Latest</option>
                            <option value="">Oldest</option>
                        </select>
                    </div>
                </div> --}}
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form action="" name="searchForm" id="searchForm">                        
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Keywords</h2>
                                <input value="{{ Request::get('keyword') }}" type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Category</h2>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            

                            <div class="mb-4">
                                <h2>Idea Type</h2>
                                @foreach ($idea_types as $idea_type)
                                    <div class="form-check mb-2">
                                        <input {{ (in_array($idea_type,$idea_typeArray)) ? 'checked' : '' }} class="form-check-input " name="idea_type" type="checkbox"
                                            value="{{ $idea_type }}" id="idea_type">
                                        <label class="form-check-label " for="{{ $idea_type }}">{{ $idea_type }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('ideas') }}" type="submit" class="btn btn-primary mt-3">Clear Filters</a>

                        </div>
                    </form>
                </div>

                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @if ($ideas->isNotEmpty())
                                    @foreach ($ideas as $idea)
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body">
                                                    <h3 class="border-0 fs-5 pb-2 mb-0">
                                                        {{ $idea->title }}</h3>
                                                    <p>{{ Str::limit($idea->description, 25, '...') }}</p>
                                                    <div class="bg-light p-3 border w-[300px] h-[500px]">
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                            <span class="ps-1">{{ $idea->category }}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                            <span class="ps-1">{{ $idea->idea_type }}</span>
                                                        </p>
                                                        {{-- <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                            <span class="ps-1">
                                                                <p>{{ implode(', ', json_decode($idea->tags)) }}</p>
                                                            </span>
                                                        </p> --}}
                                                    </div>

                                                    <div class="d-grid mt-3">
                                                        <a href="{{ route('ideaDetail', $idea->id) }}" class="btn btn-primary btn-lg">Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex justify-center items-center">
                                        <div class=" font-semibold">Ideas not Found</div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    {{ $ideas->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </section>
@endsection


@section('customJs')
<script type="text/javascript">
$("#searchForm").submit(function(e){
    e.preventDefault();

    var url = '{{ route('ideas') }}'; // Start with the base URL

    var keyword = $("#keyword").val();
    var category = $("#category").val();
    var chechedIdeatypes = $("input:checkbox[name='idea_type']:checked").map(function(){
        return $(this).val();
    }).get();

    if (keyword != "") {
        url += (url.includes('?') ? '&' : '?') + 'keyword=' + keyword;
    }

    if (category != "") {
        url += (url.includes('?') ? '&' : '?') + 'category=' + category;
    }

    if(chechedIdeatypes.length > 0){
        url += (url.includes('?') ? '&' : '?') + 'idea_type=' + chechedIdeatypes;
    }

    window.location.href = url;
});
</script>
@endsection
