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
            <form action="" method="PUT" id="editIdeaForm" name="editIdeaForm">
              @csrf
              <div class="card border-0 shadow mb-4 ">
                <div class="card-body card-form p-4">
                    <h3 class="fs-4 mb-1">Edit Idea</h3>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="" class="mb-2">Title<span class="req">*</span></label>
                            <input type="text" value="{{ $idea->title }}" placeholder="idea Title" id="title" name="title" class="form-control">
                            <p></p>
                        </div>
                        <div class="col-md-6 mb-4">
                          <label for="category" class="mb-2">Category<span class="req">*</span></label>
                          <select name="category" id="category" class="form-control">
                              <option value="">Select a Category</option>
                              <option value="Full stack Website" {{ $idea->category == 'Full stack Website' ? 'selected' : '' }}>Full stack Website</option>
                              <option value="Ai Saas" {{ $idea->category == 'Ai Saas' ? 'selected' : '' }}>Ai Saas</option>
                              <option value="Cloud/Devops" {{ $idea->category == 'Cloud/Devops' ? 'selected' : '' }}>Cloud/Devops</option>
                              <option value="Bussiness Model" {{ $idea->category == 'Bussiness Model' ? 'selected' : '' }}>Bussiness Model</option>
                          </select>
                          <p></p>
                      </div>
                      
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="" class="mb-2">Idea Type<span class="req">*</span></label>
                            <select name="idea_type" id="idea_type" class="form-select">
                              <option value="Tech & Development" {{ $idea->idea_type == 'Tech & Development' ? 'selected' : '' }}>Tech & Development</option>
                              <option value="Bussiness & Marketing" {{ $idea->idea_type == 'Bussiness & Marketing' ? 'selected' : '' }}>Bussiness & Marketing</option>
                              <option value="Startup" {{ $idea->idea_type == 'Startup' ? 'selected' : '' }}>Startup</option>
                          </select>                          
                            <p></p>
                        </div>
                        <div class="col-md-6  mb-4">
                            <label for="" class="mb-2">Are you working on it?<span class="req">*</span></label>
                            <select name="working_on_it" id="working_on_it" class="form-select">
                              <option value="Yes" {{ $idea->working_on_it == 'Yes' ? 'selected' : '' }}>Yes</option>
                              <option value="No" {{ $idea->working_on_it == 'No' ? 'selected' : '' }}>No</option>
                          </select>
                            <p></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="" class="mb-2">Description<span class="req">*</span></label>
                        <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $idea->description }}</textarea>
                        <p></p>
                    </div>

                    <div class="mb-4">
                        <label for="" class="mb-2">Relevant Links<span class="req"></span></label>
                        <input type="text" value="{{ $idea->relevant_links }}" placeholder="Add relevant links" id="relevant_links" name="relevant_links" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="" class="mb-2">Tags & Keywords<span class="req">*</span></label>
                        <input type="text" value="{{ $idea->tags }}"  placeholder="Add relevant technologies or tools " id="tags" name="tags" class="form-control">
                        <p></p>
                    </div>
                </div> 
                <div class="card-footer  p-4">
                    <button type="submit" class="btn btn-primary">Update idea</button>
                </div>               
              </div>
            </form>
              
          </div>
      </div>
  </div>
</section>
@endsection


@section('customJs')
    <script type="text/javascript">
    $("#editIdeaForm").submit(function(e){
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: "{{ route('account.updateIdea', $idea->id) }}",
            type: "POST",
            dataType: "json",
            data: $("#editIdeaForm").serializeArray(),

            success: function(response) {
              $("button[type='submit']").prop('disabled', false);
                if(response.status == true){
                    $("#title").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                    $("#category").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                    $("#idea_type").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                    $("#working_on_it").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                    $("#description").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                    $("#tags").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')

                      setTimeout(function() {
                        window.location.href='{{ route("account.myIdeas") }}'; // Redirect without adding to history
                      }, 1000);

                    

                } else {
                    var errors = response.errors;

                    if(errors.title) {
                      $("#title").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.title)
                    } else {
                      $("#title").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }
                
                    if(errors.category) {
                      $("#category").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.category)
                    } else {
                      $("#category").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }

                    if(errors.idea_type) {
                      $("#idea_type").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.idea_type)
                    } else {
                      $("#idea_type").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }

                    if(errors.working_on_it) {
                      $("#working_on_it").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.working_on_it)
                    } else {
                      $("#working_on_it").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }

                    if(errors.description) {
                      $("#description").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.description)
                    } else {
                      $("#description").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }

                    if(errors.tags) {
                      $("#tags").addClass('is-invalid')
                      .siblings('p')
                      .addClass('invalid-feedback')
                      .html(errors.tags)
                    } else {
                      $("#tags").removeClass('is-invalid')
                      .siblings('p')
                      .removeClass('invalid-feedback')
                      .html('')
                    }

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        return false;
    })
    </script>
@endsection