@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')

                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Saved Ideas</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('account.createIdea') }}" class="btn btn-primary">Post a Idea</a>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">category</th>
                                            <th scope="col">Idea Type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($savedIdeas->isNotEmpty())
                                            @foreach ($savedIdeas as $idea)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $idea->idea->title }}</div>
                                                        {{-- <div class="info1">Fulltime . Noida</div> --}}
                                                    </td>
                                                    <td> {{ $idea->idea->category }}</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">{{ $idea->idea->idea_type }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <button href="#" class="btn" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="{{ route('ideaDetail', $idea->idea->id) }}"> <i
                                                                            class="fa fa-eye" aria-hidden="true"></i>
                                                                        View</a></li>
                                                                <li><a class="dropdown-item" onclick="removeIdea({{ $idea->id }})" href="#"><i
                                                                            class="fa fa-edit" aria-hidden="true"></i>
                                                                        Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                              {{ $savedIdeas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customJs')
    <script type="text/javascript">
    function removeIdea(id) {
            $.ajax({
                url: "{{ route('account.removeSavedIdea') }}",
                type: 'post',
                data: {id: id, _token: "{{ csrf_token() }}"},
                dataType: 'json', 
                success: function(response) {
                    window.location.href='{{ route('account.savedIdeas') }}';
                }
            })
        }
    </script>
@endsection
