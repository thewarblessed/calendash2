<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid ">
            <form>
                @csrf
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <img src="../../../assets/img/header-orange-purple.jpg" alt="pattern-lines"
                                class="top-0 rounded-2 position-absolute start-0 w-100 h-100">

                            <div class="row z-index-2 justify-content-center align-items-center">
                                {{-- <div class="col-sm-auto col-4">
                                    <div class="avatar avatar-xl position-relative">
                                        <img src="../assets/img/team-2.jpg" alt="bruce"
                                            class="w-100 h-100 object-fit-cover border-radius-lg shadow-sm"
                                            id="preview">
                                    </div>
                                </div> --}}
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <p class="mb-0 font-weight-bold text-sm">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                    {{-- <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23"
                                            checked onchange="visible()">
                                    </div>
                                    <label class="text-white form-check-label mb-0">
                                        <small id="profileVisibility">
                                            Switch to invisible
                                        </small>
                                    </label> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" id="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert" id="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mb-5 row justify-content-center">
                    <div class="col-lg-9 col-12 ">
                        <div class="card " id="basic-info">
                            <div class="card-header">
                                <h5>Your Info</h5>
                            </div>
                            <div class="pt-0 card-body">

                                <div class="align-items-center justify-content-center flex-column">
                                    <div>
                                        <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" class="form-control" hidden>
                                        <label for="currentPasscode">Your current passcode</label>
                                        <div class="input-group">
                                            <input type="password" name="currentPasscode" id="currentPasscode" class="form-control">
                                            <button type="button" class="btn btn-outline-secondary" id="toggleCurrentPasscode">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <span id="passcodeCheckResult"></span>
                                        @error('currentPasscode')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                
                                    <div>
                                        <label for="newPasscode">Type new passcode</label>
                                        <div class="input-group">
                                            <input type="password" name="newPasscode" id="newPasscode" class="form-control">
                                            <button type="button" class="btn btn-outline-secondary" id="toggleNewPasscode">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('newPasscode')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                
                                    <div>
                                        <label for="retypeNewPasscode">Re-type new passcode</label>
                                        <div class="input-group">
                                            <input type="password" name="retypeNewPasscode" id="retypeNewPasscode" class="form-control">
                                            <button type="button" class="btn btn-outline-secondary" id="toggleRetypeNewPasscode">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <span id="passcodeError" class="text-danger"></span>
                                        @error('retypeNewPasscode')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                
                                    <script>
                                        document.getElementById('toggleCurrentPasscode').addEventListener('click', function () {
                                            const input = document.getElementById('currentPasscode');
                                            input.type = input.type === 'password' ? 'text' : 'password';
                                        });

                                        document.getElementById('toggleNewPasscode').addEventListener('click', function () {
                                            const input = document.getElementById('newPasscode');
                                            input.type = input.type === 'password' ? 'text' : 'password';
                                        });

                                        document.getElementById('toggleRetypeNewPasscode').addEventListener('click', function () {
                                            const input = document.getElementById('retypeNewPasscode');
                                            input.type = input.type === 'password' ? 'text' : 'password';
                                        });

                                        // passcode validation
                                        document.getElementById('retypeNewPasscode').addEventListener('input', function () {
                                            const newPasscode = document.getElementById('newPasscode').value;
                                            const retypeNewPasscode = document.getElementById('retypeNewPasscode').value;
                                            const passcodeError = document.getElementById('passcodeError');

                                            if (newPasscode === retypeNewPasscode) {
                                                passcodeError.textContent = 'Passcode matched!';
                                                passcodeError.classList.remove('text-danger');
                                                passcodeError.classList.add('text-success');
                                            } else {
                                                passcodeError.textContent = 'Passcodes do not match';
                                                passcodeError.classList.remove('text-success');
                                                passcodeError.classList.add('text-danger');
                                            }
                                        });
                                    </script>
                                

                                

                                {{-- <div class="row">
                                    <div class="col-6">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" id="location"
                                            placeholder="Bucharest, Romania"
                                            value="{{ old('location', auth()->user()->location) }}"
                                            class="form-control">
                                        @error('location')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" placeholder="0733456987"
                                            value="{{ old('phone', auth()->user()->phone) }}" class="form-control">
                                        @error('phone')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <label for="about">About me</label>
                                    <textarea name="about" id="about" rows="5" class="form-control">{{ old('about', auth()->user()->about) }}</textarea>
                                    @error('about')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <button id="passcodeSubmit" class="mt-6 mb-0 btn btn-primary btn-sm float-end">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <x-app.footer />
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
