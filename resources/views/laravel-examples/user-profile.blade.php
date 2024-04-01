<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid ">
            <form action={{ route('users.update') }} method="POST">
                @csrf
                @method('PUT')
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

                                <div class="row">
                                    <div class="col-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', auth()->user()->name) }}" class="form-control">
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', auth()->user()->email) }}" class="form-control">
                                        @error('email')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @if ($role === 'student')
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="department_id">Select Department</label>
                                            <select class="form-control" id="department_id" name="department_id">
                                                @foreach ($departments as $department)
                                                    @if ($department->id >= 1 && $department->id <= 4)
                                                        <option value="{{ $department->id }}" {{ $user->student->department_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->department }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            {{-- @error('name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror --}}
                                        </div>
                                        <div class="col-6">
                                            <label for="organization_id">Select Organization</label>
                                            <select class="form-control" id="organization_id" name="organization_id">
                                                @foreach ($organizations as $organization)
                                                    <option value="{{ $organization->id }}" {{ $user->student->organization_id == $organization->id ? 'selected' : '' }}>
                                                        {{ $organization->organization }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('organization_id')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <label for="section_id">Select Course</label>
                                            <select class="form-control" id="section_id" name="section_id">
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}" {{ $user->student->section_id == $section->id ? 'selected' : '' }}>
                                                        {{ $section->section }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-6">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', auth()->user()->email) }}" class="form-control">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                    </div>
                                @endif

                                @if ($role === 'staff')
                                    <div class="col-6">
                                        <label for="department_id_staff">Select Department</label>
                                        <div class="select-wrapper">
                                            <select class="form-control" id="department_id_staff" name="department_id_staff">
                                                @foreach ($departments as $department)
                                                    @if ($department->id >= 6 && $department->id <= 13)
                                                        <option value="{{ $department->id }}" {{ optional($student)->department_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->department }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <i class="fa-solid fa-chevron-down icon"></i>
                                        </div>
                                    </div>
                                    <style>
                                        .select-wrapper {
                                            position: relative;
                                            display: inline-block;
                                            width: 100%;
                                        }
                                    
                                        .icon {
                                            position: absolute;
                                            top: 50%;
                                            right: 10px;
                                            transform: translateY(-50%);
                                            pointer-events: none;
                                        }
                                    </style>
                                @endif

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
                                <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm float-end">Save
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

</x-app-layout>
