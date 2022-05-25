@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">Settings
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Settings</h3>
                            </div>
                            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group" bis_skin_checked="1">
                                        <label for="exampleInputFile">Logo</label>
                                        <div id="img-preview" style="display: block;">
                                          @if(isset($siteSetting->site_name)) <img src="{{asset($siteSetting->logo)}}"> @endif
                                        </div>
                                        <div class="input-group" bis_skin_checked="1">
                                          <div class="custom-file" bis_skin_checked="1">
                                            <input type="file" accept="image/*"  id="choose-file" name="logo">
                                            <label class="custom-file-label" for="choose-file">Choose file</label>
                                          </div>
                                        </div>
                                    </div>
                
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">School Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="school_name"
                                            placeholder="Enter School Name" @if(isset($siteSetting)) value="{{ $siteSetting->school_name }}"  @endif >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="phone"
                                            placeholder="Enter School Phone" @if(isset($siteSetting)) value="{{ $siteSetting->phone }}"  @endif >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="address"
                                            placeholder="Enter School Adddress" @if(isset($siteSetting)) value="{{ $siteSetting->address }}"  @endif >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date Time System</label>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="radio" name="date_system" value="AD" @if(isset($siteSetting) && $siteSetting->date_system)=="AD") checked  @endif > AD 
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="radio" name="date_system" value="BS" @if(isset($siteSetting) && $siteSetting->date_system=="BS") checked  @endif > BS 
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
<script>
  const chooseFile = document.getElementById("choose-file");
  const imgPreview = document.getElementById("img-preview");

  chooseFile.addEventListener("change", function () {
    getImgData();
  });

  function getImgData() {
    const files = chooseFile.files[0];
    if (files) {
      const fileReader = new FileReader();
      fileReader.readAsDataURL(files);
      fileReader.addEventListener("load", function () {
        imgPreview.style.display = "block";
        imgPreview.innerHTML = '<img src="' + this.result + '" />';
      });    
    }
  }
</script>
@endsection
