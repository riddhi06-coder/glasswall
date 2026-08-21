<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Add About Us Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-about-us.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add About Us Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>About Us Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-about-us.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    @if($errors->any())
                                        <div class="col-12">
                                            <div class="alert alert-danger mb-0">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Description (rich text) -->
                                    <div class="col-md-12">
                                        <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter Description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Milestones (repeatable rows) -->
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0">Milestones</label>
                                            <button type="button" class="btn btn-sm btn-primary" id="addMilestoneRow">+ Add More</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle" id="milestonesTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width:260px;">Icon <span class="text-danger">*</span></th>
                                                        <th style="width:200px;">Count <span class="text-danger">*</span></th>
                                                        <th>Milestone <span class="text-danger">*</span></th>
                                                        <th style="width:90px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="milestonesBody">
                                                    <!-- rows are injected by JS -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                    <!-- Form Actions -->
                                    <div class="col-12 text-end">
                                        <a href="{{ route('manage-about-us.index') }}" class="btn btn-danger px-4">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>

                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>



       @include('components.backend.main-js')


</body>

</html>