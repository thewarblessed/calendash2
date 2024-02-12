<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4" style="padding: 50px">
                        <div>
                            <h3 style="text-align: center">CREATE OFFICIAL</h3>
                            {{-- method="POST" action="{{ route('storeVenue') }}" enctype="multipart/form-data" --}}
                            <form role="form" id="officialForm" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group">
                                        <label>First Name</label>
                                      <input type="text" class="form-control" name="firstname" id="firstname" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label>Last Name</label>
                                      <input type="text" class="form-control" name="lastname" id="lastname" required/>
                                    </div>
                            
                                    <div class="form-group">
                                        <label>Email</label>
                                      <input type="email" class="form-control" name="email" id="email" required>
                                    </div>
                                 
                                    <div class="form-group">
                                        <label>Password</label>
                                      <input type="password" class="form-control" id="password" name="password"required>
                                    </div>  

                                    {{-- <div class="form-group">
                                        <label>Position</label>
                                      <input type="text" class="form-control" name="official_role" id="official_role" required>
                                    </div> --}}

                                    <div class="form-group">
                                    <label>Position</label>
                                    <select class="form-control form-control-lg" id="official_role" name="official_role">
                                        <option value="org_adviser">Organization Head</option>
                                        <option value="section_head">Section Head</option>
                                        <option value="department_head">Department Head</option>
                                        <option value="osa">OSA</option>
                                        <option value="atty">ATTY</option>
                                        <option value="adaa">ADAA</option>
                                        <option value="campus_director">Campus Director</option>
                                      </select>
                                    </div>
                                      
                                    <div class="form-group">
                                        <label>Desired Passcode</label>
                                      <input type="password" class="form-control" name="passcode" id="passcode" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Upload Image</label>
                                      <input type="file" class="form-control" id="image" name="image"required>
                                    </div>  
                                
                                {{-- <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group has-success">
                                      <input type="text" placeholder="Success" class="form-control is-valid" />
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group has-danger">
                                      <input type="email" placeholder="Error Input" class="form-control is-invalid" />
                                    </div>
                                  </div>
                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="officialSubmit">SAVE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
