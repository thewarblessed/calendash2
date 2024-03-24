<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <x-app.navbar />
      <div class="container-fluid py-4 px-5">
        <div class="row">
          <div class="col-12">
            <div class="card border shadow-xs mb-4" style="padding: 50px">
              <div>
                <h3 style="text-align: center">CREATE DEPARTMENT HEAD</h3>
                {{-- method="POST" action="{{ route('storeVenue') }}" enctype="multipart/form-data" --}}
                <form role="form" id="departmentHeadForm" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required>
                  </div>
  
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required />
                  </div>
  
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
  
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
  
                  {{-- <div class="form-group">
                    <label>Position</label>
                    <input type="text" class="form-control" name="official_role" id="official_role" required>
                  </div> --}}
  
                  <div class="form-group" style="display: block;" id="selectOrgDiv">
                    <label for="organization_id">Select Department</label>
                    <select class="form-control" id="department_id" name="department_id">
                        @foreach ($departments as $id => $department)
                            @if ($id >= 1 && $id <= 4)
                                <option value="{{ $id }}">{{ $department }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

  
                  <div class="form-group">
                    <label>Desired Passcode for approval of requests</label>
                    <input type="password" class="form-control" name="passcode" id="passcode" required>
                  </div>
  
                  <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                  </div>
  
                  <button type="submit" class="btn btn-primary btn-lg w-100" id="departmentHeadSubmit">SAVE</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
  </x-app-layout>