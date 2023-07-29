@extends('layouts.master')
@section('page_title', 'Student Management')
@section('content')

    <div class="students">
        <h1>Students</h1>
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#admit" class="nav-link active" data-toggle="tab">Admit Student</a></li>
            <li class="nav-item"><a href="#student-info" class="nav-link" data-toggle="tab">Class Information</a></li>
            <li class="nav-item"><a href="#student-promo" class="nav-link" data-toggle="tab">Student Promotion</a></li>
            <li class="nav-item"><a href="#manage-promo" class="nav-link" data-toggle="tab">Manage Promotions</a></li>
            <li class="nav-item"><a href="#graduated-students" class="nav-link" data-toggle="tab">Graduated Students</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="admit">
                <div class="card">
                    <div class="card-header bg-white header-elements-inline">
                        <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>

                        {!! Qs::getPanelOptions() !!}
                    </div>

                    <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation"
                        action="{{ route('students.store') }}" data-fouc>
                        @csrf
                        <!-- Your form fields and content here -->
                        <h6>Personal data</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name: <span class="text-danger">*</span></label>
                                        <input value="{{ old('name') }}" required type="text" name="name"
                                            placeholder="Full Name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address: <span class="text-danger">*</span></label>
                                        <input value="{{ old('address') }}" class="form-control" placeholder="Address"
                                            name="address" type="text" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email address: </label>
                                        <input type="email" value="{{ old('email') }}" name="email"
                                            class="form-control" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gender">Gender: <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="gender" name="gender" required data-fouc
                                            data-placeholder="Choose..">
                                            <option value=""></option>
                                            <option {{ old('gender') == 'Male' ? 'selected' : '' }} value="Male">Male
                                            </option>
                                            <option {{ old('gender') == 'Female' ? 'selected' : '' }} value="Female">Female
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Phone:</label>
                                        <input value="{{ old('phone') }}" type="text" name="phone"
                                            class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Telephone:</label>
                                        <input value="{{ old('phone2') }}" type="text" name="phone2"
                                            class="form-control" placeholder="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date of Birth:</label>
                                        <input name="dob" value="{{ old('dob') }}" type="text"
                                            class="form-control date-pick" placeholder="Select Date...">

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nal_id">Nationality: <span class="text-danger">*</span></label>
                                        <select data-placeholder="Choose..." required name="nal_id" id="nal_id"
                                            class="select-search form-control">
                                            <option value=""></option>
                                            @foreach ($nationals as $nal)
                                                <option {{ old('nal_id') == $nal->id ? 'selected' : '' }}
                                                    value="{{ $nal->id }}">{{ $nal->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="state_id">State: <span class="text-danger">*</span></label>
                                    <select onchange="getLGA(this.value)" required data-placeholder="Choose.."
                                        class="select-search form-control" name="state_id" id="state_id">
                                        <option value=""></option>
                                        @foreach ($states as $st)
                                            <option {{ old('state_id') == $st->id ? 'selected' : '' }}
                                                value="{{ $st->id }}">
                                                {{ $st->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="lga_id">LGA: <span class="text-danger">*</span></label>
                                    <select required data-placeholder="Select State First"
                                        class="select-search form-control" name="lga_id" id="lga_id">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bg_id">Blood Group: </label>
                                        <select class="select form-control" id="bg_id" name="bg_id" data-fouc
                                            data-placeholder="Choose..">
                                            <option value=""></option>
                                            @foreach (App\Models\BloodGroup::all() as $bg)
                                                <option {{ old('bg_id') == $bg->id ? 'selected' : '' }}
                                                    value="{{ $bg->id }}">{{ $bg->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">Upload Passport Photo:</label>
                                        <input value="{{ old('photo') }}" accept="image/*" type="file"
                                            name="photo" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size
                                            2Mb</span>
                                    </div>
                                </div>
                            </div>

                        </fieldset>

                        <h6>Student Data</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my_class_id">Class: <span class="text-danger">*</span></label>
                                        <select onchange="getClassSections(this.value)" data-placeholder="Choose..."
                                            required name="my_class_id" id="my_class_id"
                                            class="select-search form-control">
                                            <option value=""></option>
                                            @foreach ($my_classes as $c)
                                                <option {{ old('my_class_id') == $c->id ? 'selected' : '' }}
                                                    value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="section_id">Section: <span class="text-danger">*</span></label>
                                        <select data-placeholder="Select Class First" required name="section_id"
                                            id="section_id" class="select-search form-control">
                                            <option {{ old('section_id') ? 'selected' : '' }}
                                                value="{{ old('section_id') }}">
                                                {{ old('section_id') ? 'Selected' : '' }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my_parent_id">Parent: </label>
                                        <select data-placeholder="Choose..." name="my_parent_id" id="my_parent_id"
                                            class="select-search form-control">
                                            <option value=""></option>
                                            @foreach ($parents as $p)
                                                <option {{ old('my_parent_id') == Qs::hash($p->id) ? 'selected' : '' }}
                                                    value="{{ Qs::hash($p->id) }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year_admitted">Year Admitted: <span
                                                class="text-danger">*</span></label>
                                        <select data-placeholder="Choose..." required name="year_admitted"
                                            id="year_admitted" class="select-search form-control">
                                            <option value=""></option>
                                            @for ($y = date('Y', strtotime('- 10 years')); $y <= date('Y'); $y++)
                                                <option {{ old('year_admitted') == $y ? 'selected' : '' }}
                                                    value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="dorm_id">Dormitory: </label>
                                    <select data-placeholder="Choose..." name="dorm_id" id="dorm_id"
                                        class="select-search form-control">
                                        <option value=""></option>
                                        @foreach ($dorms as $d)
                                            <option {{ old('dorm_id') == $d->id ? 'selected' : '' }}
                                                value="{{ $d->id }}">
                                                {{ $d->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Dormitory Room No:</label>
                                        <input type="text" name="dorm_room_no" placeholder="Dormitory Room No"
                                            class="form-control" value="{{ old('dorm_room_no') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sport House:</label>
                                        <input type="text" name="house" placeholder="Sport House"
                                            class="form-control" value="{{ old('house') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Admission Number:</label>
                                        <input type="text" name="adm_no" placeholder="Admission Number"
                                            class="form-control" value="{{ old('adm_no') }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <!-- Students information starts -->
            <div class="tab-pane fade" id="student-info">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Class List</h6>
                        {!! Qs::getPanelOptions() !!}
                    </div>

                    <div class="card-body">
                        <!-- New content with submenu for Student Information -->
                        <div class="card-body">
                            <ul class="nav flex-column">
                                @foreach (App\Models\MyClass::orderBy('name')->get() as $c)
                                    <li class="nav-item"><a href="{{ route('students.list', $c->id) }}"
                                            class="nav-link ">{{ $c->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Promotions starts -->
            <div class="tab-pane fade" id="student-promo">
                @include('pages.support_team.students.promotion.index')
            </div>

            <!-- Manage Promotions starts -->
            <div class="tab-pane fade" id="manage-promo">
                @include('pages.support_team.students.promotion.reset')
            </div>

            <!-- Graduated students starts -->
            <div class="tab-pane fade" id="graduated-students">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Students Graduated</h6>
                        {!! Qs::getPanelOptions() !!}
                    </div>

                    <div class="card-body">
                        <!-- Graduated students table content here -->
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            <li class="nav-item"><a href="#all-students" class="nav-link active" data-toggle="tab">All
                                    Graduated Students</a></li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Select
                                    Class</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach ($my_classes as $c)
                                        <a href="#c{{ $c->id }}" class="dropdown-item"
                                            data-toggle="tab">{{ $c->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="all-students">
                                <table class="table datatable-button-html5-columns">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>ADM_No</th>
                                            <th>Section</th>
                                            <th>Grad Year</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $s)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img class="rounded-circle" style="height: 40px; width: 40px;"
                                                        src="{{ $s->user->photo }}" alt="photo"></td>
                                                <td>{{ $s->user->name }}</td>
                                                <td>{{ $s->adm_no }}</td>
                                                <td>{{ $s->my_class->name . ' ' . $s->section->name }}</td>
                                                <td>{{ $s->grad_date }}</td>
                                                <td class="text-center">
                                                    <div class="list-icons">
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item"
                                                                data-toggle="dropdown">
                                                                <i class="icon-menu9"></i>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-left">
                                                                <a href="{{ route('students.show', Qs::hash($s->id)) }}"
                                                                    class="dropdown-item"><i class="icon-eye"></i> View
                                                                    Profile</a>
                                                                @if (Qs::userIsTeamSA())
                                                                    <a href="{{ route('students.edit', Qs::hash($s->id)) }}"
                                                                        class="dropdown-item"><i class="icon-pencil"></i>
                                                                        Edit</a>
                                                                    <a href="{{ route('st.reset_pass', Qs::hash($s->user->id)) }}"
                                                                        class="dropdown-item"><i class="icon-lock"></i>
                                                                        Reset
                                                                        password</a>

                                                                    {{-- Not Graduated --}}
                                                                    <a id="{{ Qs::hash($s->id) }}" href="#"
                                                                        onclick="$('form#ng-'+this.id).submit();"
                                                                        class="dropdown-item"><i
                                                                            class="icon-stairs-down"></i> Not
                                                                        Graduated</a>
                                                                    <form method="post" id="ng-{{ Qs::hash($s->id) }}"
                                                                        action="{{ route('st.not_graduated', Qs::hash($s->id)) }}"
                                                                        class="hidden">@csrf @method('put')</form>
                                                                @endif

                                                                <a target="_blank"
                                                                    href="{{ route('marks.year_selector', Qs::hash($s->user->id)) }}"
                                                                    class="dropdown-item"><i class="icon-check"></i>
                                                                    Marksheet</a>

                                                                {{-- Delete --}}
                                                                @if (Qs::userIsSuperAdmin())
                                                                    <a id="{{ Qs::hash($s->user->id) }}"
                                                                        onclick="confirmDelete(this.id)" href="#"
                                                                        class="dropdown-item"><i class="icon-trash"></i>
                                                                        Delete</a>
                                                                    <form method="post"
                                                                        id="item-delete-{{ Qs::hash($s->user->id) }}"
                                                                        action="{{ route('students.destroy', Qs::hash($s->user->id)) }}"
                                                                        class="hidden">@csrf @method('delete')</form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
